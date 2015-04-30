<?php 

/*
 * Пример:
$conf = array(
		'pr' => 0, //Приоритет параметров. Если "pr" установлен в 1, то более приоритетными считаются значения в конфиге, иначе - значения переданные в ссылке
		'update_time' => 1800, //Частота обновления списка доменов в сек (минимум 1200). Внимание: не рекомендуется уменьшать время обращения скрипта к API, так как это может привести к бану ip с которого идет запрос антиддос защитой, что приведет скрипт в нерабочее состояние.
		'service' => 'FilePoisk,Zagroozki',
		'code_level' => 1, //Если параметр в конфиге установлен в 1, при редиректе на платник передаваемые данные шифруются. По умолчанию 'code_level' установлен в 0 - данные передаются как есть
		'ignore_get' => 0, //Если параметр в конфиге установлен в 1 (включено), и в ссылке был всего один параметр http://yoursite.com/lp_target_link.php?q=XXX, считается, что этот параметр "q" - поисковый запрос, Какой бы переменной он не передавался.
		'r' => 1000,
		'q' => 'поисковый запрос',
		'sl' => '',
		'files' => array(
				'http://loadpays.com/module/files/loadpays_dle_plugin.zip',
				'http://loadpays.com/module/files/loadpays_wordpress_plugin.zip',
		),
		'i' => 'http://mydomain.com/img.jpg',
);
*/

$conf = array(
		'pr' => 0,
		'update_time' => 1200,	//Частота обновления списка доменов в сек	
		'service' => 'SearchFiles', //сервис платников. Пример: loadroom или loadroom.com или LoadRoom
		'code_level' => 0,
		'ignore_get' => 0,
		'r' => 0, //поток траффика
		//'q' => 'поисковый запрос',
		'sl' => '', //ссылки на файлы, который будут доступны для скачивания пользователям после оплаты на сайте
		'files' => array(), // Список файлов для параметра sl
		'i' => '',
);
/*
 * Строки ниже не изменять!!!
*/
$redir = new LpTargetRedirect();
$redir->run($conf);

class LpTargetRedirect
{
	private $config = array();
	// время обновления доменов, сек
	private $minUpdateTime = 1200;

	// имя файла конфига
	public $domainListFile = 'data.cfg';

	// адрес API актуальных доменов
	public $apiUrl = 'http://loadpays.com/api/conf/conf.txt';

	public $lockFile = 'lock.cfg';

	public function run($conf=array())
	{
		if (empty($conf) || !is_array($conf)) $conf = array();
		
		$this->setConfig($conf);
		$domain = $this->getDomain();
		$url = $domain . '/';	
		echo $url;
	}

	private function setConfig($conf)
	{	
		$checkGet = (isset($conf['ignore_get']) && $conf['ignore_get'] == 1)?1:0;
		if ($checkGet) $this->checkGet();
		$pr = (isset($conf['pr']) && $conf['pr'] == 1)?1:0;	
		$this->config['ut'] = (isset($conf['update_time']) && (((int)$conf['update_time']) > $this->minUpdateTime))?(int)$conf['update_time']:$this->minUpdateTime;
		$this->config['service'] = $this->getParam('service', $conf, $pr);
		$this->config['code_level'] = $this->getParam('code_level', $conf, $pr);
		$this->config['url']['r'] = $this->getParam('r', $conf, $pr);
		$this->config['url']['q'] = $this->getParam('q', $conf, $pr);
		//$this->config['url']['t'] = $this->getParam('t', $conf, $pr);
		$this->config['url']['sl'] = $this->getParam('sl', $conf, $pr);
		if (empty($this->config['url']['sl']) && (!empty($conf['files'])))
		{
			$this->config['url']['sl'] = $this->getSlParam($conf['files']);
		}
		$this->config['i'] = $this->getParam('i', $conf, $pr);
	}

	private function getParam($paramName, $conf, $pr)
	{
		$val = '';
		if (isset($conf[$paramName])&&(!empty($conf[$paramName])))
		{
			$val = $conf[$paramName];
			if ($pr) return $val;
		}
		if (isset($_GET[$paramName])&&(!empty($_GET[$paramName])))
		{
			$val = $_GET[$paramName];
		}
		return $val;
	}

	private function getSlParam($files)
	{
		if (!is_array($files)) return '';
		$str = '';
		$delimiter = '';
		foreach ($files as $file)
		{
			if (empty($file)) continue;
			$str .= $delimiter.$file;
			$delimiter = ';';
		}
		if ($str != '') $str = base64_encode($str);
		return $str;
	}

	private function getDomainList()
	{
		if (!file_exists($this->lockFile) || intval(file_get_contents($this->lockFile)) < time() - $this->config['ut'])
		{
			file_put_contents($this->lockFile, time());
			chmod($this->lockFile, 0777);
			$this->refreshDomainList();
		}
		return unserialize(file_get_contents($this->domainListFile));
	}

	private function refreshDomainList()
	{
		if (!function_exists('curl_init')) {
			$data = file_get_contents($this->apiUrl);
		} else {
			$data = $this->getDataByCurl();
			if (empty($data)) {
				$data = file_get_contents($this->apiUrl);
			}
		}
		if (empty($data)) return;
		$data = unserialize($data);
		if (is_array($data))
		{
			file_put_contents($this->domainListFile, serialize($data));
			chmod($this->domainListFile, 0777);
		}

	}

	private function getDataByCurl()
	{
		$data = '';
		$curl = curl_init($this->apiUrl);
		$options = array(
			CURLOPT_RETURNTRANSFER => true,    
			CURLOPT_CONNECTTIMEOUT => 90,  
			CURLOPT_TIMEOUT        => 90, 
		);
		curl_setopt_array($curl, $options);
		$res = curl_exec($curl);
		if (!curl_errno($curl) && $res !== false) {
			$data = $res;
		}
		curl_close($curl);
		return $data;
	}

	private function getDomain()
	{
		$domain = '';
		$domainList = $this->getDomainList();
		if (isset($this->config['service']))
		{
			$sList = explode(",", $this->config['service']);
			foreach ($sList as $serviceName)
			{
				$service = str_replace(array('http://', '/', '.', 'com', 'net'), '', $serviceName);
				$service = strtolower(trim($service));
				$services = array_map('strtolower', $domainList['services']);
				if ($id = array_search($service, $services))
				{
					$domain = $domainList['domains'][$id];
				}
				if (!empty($domain)) break;
			}
		}
		if (empty($domain))
		{
			$domain = $domainList['domains'][array_rand($domainList['domains'])];
		}
		return $domain;
	}

	private function getQueryParams()
	{
		$params = array();
		foreach ($this->config['url'] as $k=>$v)
		{
			if (!empty($v))
			{
				$params[$k] = $v;
			}
		}
		return $params;
	}
	
	private function checkGet()
	{
		if (count($_GET) == 1 && (empty($_GET['q'])))
		{
			foreach ($_GET as $key=>$val)
			{
				$_GET['q'] = $val;
				unset($_GET[$key]);
			}		
		}
	}
	
	private function getQuery()
	{
		$query = http_build_query($this->getQueryParams());
		if (!empty($this->config['code_level']) && (function_exists('gzcompress')))
		{
			$z = urlencode(base64_encode(gzcompress($query, 9)));
			$query ='z='.$z;			
		}
		return $query;
	}

	}
?>
