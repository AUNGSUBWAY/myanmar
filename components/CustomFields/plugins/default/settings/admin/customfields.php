<?php
$page = input('cpage', '', 'add');
if(!custom_fields_init()){
	$page = 'init';
}
switch($page){
	case 'init':
		echo ossn_plugin_view('customfields/init');	
	break;
	case 'list':
		echo ossn_plugin_view('customfields/list');
	break;
	case 'add':
		echo ossn_plugin_view('customfields/add');
		break;
	case 'edit':
		echo ossn_plugin_view('customfields/edit');
		break;		
}	