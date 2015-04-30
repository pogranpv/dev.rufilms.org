<?php

/*
=============================================================================
 ����: catface.php (frontend) ������ 2.3 
-----------------------------------------------------------------------------
 �����: ����� ��������� ����������, mail@mithrandir.ru
-----------------------------------------------------------------------------
 ����������: ����� SEO ������� ��� ��������� � ������� ��������
=============================================================================
*/

// ���������
if (!defined('DATALIFEENGINE')) {
	die("Hacking attempt!");
}

/*
 * ����� ������ SEO ������� ��� ��������� � ������� ��������
 */
class CategoryFace {
	/*
	 * ����������� ������ CategoryFace - ����� �������� �������� dle_config � db
	 */
	public function __construct() {
		global $db, $config;
		$this->dle_config = $config;
		$this->db = $db;
	}


	/*
	 * ������� ����� ������ CategoryFace
	 */
	public function run() {
		// ������������ ���������� ����������
		global $dle_module, $cat_info, $category_id;

		// ������ �������� ������� $cat_info � ���������� $category_id, ����� ����� ����������� �� �������������
		$categoryInfo = $cat_info;
		$categoryId = $category_id;

		// �������� �� �������� ��������� (��� ������� ��������) � �� ������� ������ ���������
		if (($dle_module == 'cat' && $categoryId > 0 && !empty($categoryInfo[$categoryId])) || ($dle_module == 'main')) {
			// ������������� ������������ �������� ��������, ���� ������������� ������� ��������
			if ($dle_module == 'main') {
				$categoryId = 0;
				$categoryInfo[0]['name'] = $this->dle_config['home_title'];
				$categoryInfo[0]['descr'] = $this->dle_config['description'];
			}

			// �������� ����� ��������
			$page = intval($_REQUEST['cstart']);

			// ������� ���������� ���������� ������ �� ����
			$output = false;

			$output = dle_cache('catface_', md5($categoryId . '_' . $page) . $this->dle_config['skin']);

			// ���� �������� ���� ��� ������ ������������ ��������, ������� ���������� ����
			if ($output !== false) {
				$this->showOutput($output);
				return;
			}

			// ���� ��������������� ������ � ������� category_face
			$categoryFace = $this->db->super_query("SELECT * FROM " . PREFIX . "_category_face WHERE category_id = '" . $categoryId . "'");

			// ��������� ����� ������ � ��� ������, ���� ������ ������� � ������ ����������� �� ������� ��������
			if (!empty($categoryFace) && $categoryFace['module_placement'] != 'nowhere' && ($categoryFace['module_placement'] == 'all_pages' || $page < 2)) {
				// ����� ���������
				if ($categoryFace['name_placement'] == 'all_pages' || $page < 2) {
					switch ($categoryFace['show_name']) {
						case 'show':
							if ($categoryFace['name'] != '') {
								$name = stripslashes($categoryFace['name']);
							}
							break;
						case 'default':
							if ($categoryInfo[$categoryId]['name'] != '') {
								$name = stripslashes($categoryInfo[$categoryId]['name']);
							}
							break;
						case 'hide':
							break;
					}
				}

				// ���� ������ �������������� ��������� ��� ��������� �������, � �������� ������������ ������ �� ������
				elseif ($page >= 2 && $categoryFace['name_pages'] != '') {
					$name = stripslashes($categoryFace['name_pages']);
				}

				// ����� ��������
				if ($categoryFace['description_placement'] == 'all_pages' || $page < 2) {
					switch ($categoryFace['show_description']) {
						case 'show':
							if ($categoryFace['description'] != '') {
								$description = stripslashes($categoryFace['description']);
							}
							break;
						case 'default':
							if ($categoryInfo[$categoryId]['descr'] != '') {
								$description = stripslashes($categoryInfo[$categoryId]['descr']);
							}
							break;
						case 'hide':
							break;
					}
				}

				// ���� ������� �������������� �������� ��� ��������� �������, � �������� ������������ ������ �� ������
				elseif ($page >= 2 && $categoryFace['description_pages'] != '') {
					$description = stripslashes($categoryFace['description_pages']);
				}

				$output = $this->applyTemplate('catface',
					array(
						'{name}'        => $name,
						'{description}' => $description,
					),
					array(
						"'\[show_name\\](.*?)\[/show_name\]'si"               => !empty($name) ? "\\1" : '',
						"'\[show_description\\](.*?)\[/show_description\]'si" => !empty($description) ? "\\1" : '',
					)
				);
			}

			// ���� ������ �� ����������� �� ������ �������� ��� ������ �� �������, �� ����� ������ ����������
			else {
				// ���������� ����� � ������ ����� � (������� +1 ������ �� �������� ���� ��� ������).
				$output = 'empty';
			}
		}


		// ������ ��� �����
		create_cache('catface_', $output, md5($categoryId . '_' . $page) . $this->dle_config['skin']);


		$this->showOutput($output);
	}


	/*
	 * ����� ������� ��������� ������ ������ � �������
	 * @param $output - ��������������� ���������
	 */
	public function showOutput($output) {
		if ($output != 'empty') {
			echo $output;
		}
	}


	/*
	 * ����� ������������ tpl-������, �������� � �� ���� � ���������� ����������������� ������
	 * @param $template - �������� �������, ������� ����� ���������
	 * @param $vars - ������������� ������ � ������� ��� ������ ���������� � �������
	 * @param $vars - ������������� ������ � ������� ��� ������ ������ � �������
	 *
	 * @return string tpl-������, ����������� ������� �� ������� $data
	 */
	public function applyTemplate($template, $vars = array(), $blocks = array()) {
		// ���������� ���� ������� $template.tpl, ��������� ���
		if (!isset($tpl)) {
			$tpl = new dle_template();
			$tpl->dir = TEMPLATE_DIR;
		}
		else {
			$tpl->result[$template] = '';
		}
		$tpl->load_template($template . '.tpl');

		// ��������� ������ �����������
		$tpl->set('', $vars);

		// ��������� ������ �������
		foreach ($blocks as $block => $value) {
			$tpl->set_block($block, $value);
		}

		// ����������� ������ (��� �� ��� �� �������� ;))
		$tpl->compile($template);

		// ������� ���������
		return $tpl->result[$template];
	}
}

/*---End Of CategoryFace Class---*/

// ������ ������ ������ CategoryFace
$CategoryFace = new CategoryFace;

// ��������� ������� ����� ������
$CategoryFace->run();

?>