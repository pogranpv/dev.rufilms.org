<?php
if(!defined('DATALIFEENGINE')) { die("не работает"); }
	$config['allow_cache'] = "yes";
	$catlist = dle_cache("catlist", $config['skin']);
if( !$catlist ) {
	$catrow = array();
	$s = microtime(true);
    $sql_result = $db->query("select ct.id, ct.alt_name, ct.name, ct.posi, ct.parentid from ". PREFIX ."_category ct ORDER BY ct.posi");
	
	$catlist = '<nav><ul id="topmenu">';
	while($row = $db->get_row($sql_result)){
		if(!isset($prev)) {
			$prev = $row;
			continue;
		} 
		if($prev['parentid'] == 0 and $row['parentid'] == 0) {
			$catlist .= '<li><a href="'.$config['http_home_url'].$prev['alt_name'].'/">'.$prev['name'].'</a></li>';
		} elseif($prev['parentid'] == 0 and $row['parentid'] != 0) {
			$catlist .= '<li class="sublink"><a href="'.$config['http_home_url'].$prev['alt_name'].'/">'.$prev['name'].'</a>';
			$catlist .= '<span></span><ul style="display: none">';
		} elseif($prev['parentid'] != 0 and $row['parentid'] != 0) {
			$catlist .= '<li><a href="'.$config['http_home_url'].$prev['alt_name'].'/">'.$prev['name'].'</a></li>';
		} elseif($prev['parentid'] != 0 and $row['parentid'] == 0) {
			$catlist .= '<li><a href="'.$config['http_home_url'].$prev['alt_name'].'/">'.$prev['name'].'</a></li>';
			$catlist .= '</ul></li>';
		}
		$prev = $row;
	}
	if($prev['parentid'] == 0) {
		$catlist .= '<li><a href="'.$config['http_home_url'].$prev['alt_name'].'/">'.$prev['name'].'</a></li>';
	} else {
		$catlist .= '<li><a href="'.$config['http_home_url'].$prev['alt_name'].'/">'.$prev['name'].'</a></li>';
		$catlist .= '</ul></li>';
	}
	$catlist .= '</ul></nav>';
    create_cache("catlist", $catlist, $config['skin'] );    
}
echo $catlist;
?>

