<?php
 $name = input('name');
 $description = input('description');
 $category = input('category');
 
 if(empty($name) || empty($description) || empty($category)){
		ossn_trigger_message(ossn_print('bpage:fileds:required'), 'error');
		redirect(REF);
 }
 $vars = array(
		'name' => $name,
		'description' => $description,
		'phone' => input('phone'),
		'address' => input('address'),
		'website' => input('website'),
		'category' => $category,
 );
 $page = new \Ossn\Component\BusinessPage\Page;
 if($guid = $page->addPage($vars)){
		ossn_trigger_message(ossn_print('bpage:added'));
		redirect("page/view/{$guid}");
 }
 ossn_trigger_message(ossn_print('bpage:add:failed'), 'error');
 redirect(REF); 