<div  class="customfields-form-admin">
<fieldset class="titleform">
	<legend class="titleform"><?php echo ossn_print('customfield:add'); ?></legend>
<?php
	echo ossn_view_form('customfields/add', array(
    		'action' => ossn_site_url() . 'action/customfield/add',
	));
?>		
</fieldset>
<fieldset class="titleform">
	<legend class="titleform"><?php echo ossn_print('customfield:aboutpage'); ?></legend>
<?php
	echo ossn_view_form('customfields/aboutpage', array(
    		'action' => ossn_site_url() . 'action/customfield/aboutpage',
	));
?>		
</fieldset>
<?php echo ossn_plugin_view('customfields/menu');?>
	<div style="margin-top:20px;">
		<?php echo ossn_print('customfields:note');?>
	</div>
</div>