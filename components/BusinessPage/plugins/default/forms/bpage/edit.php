<div>
	<label><?php echo ossn_print('bpage:name');?></label>
	<input type="text" name="name" value="<?php echo $params['page']->title;?>" />
</div>
<div>
	<label><?php echo ossn_print('bpage:desc');?></label>
	<textarea maxlength="250" name="description"><?php echo $params['page']->description;?></textarea>
</div>
<div>
	<label><?php echo ossn_print('bpage:phone');?></label>
	<input type="text" name="phone" value="<?php echo $params['page']->phone;?>" />
</div>
<div>
	<label><?php echo ossn_print('bpage:address');?></label>
	<input type="text" name="address" value="<?php echo $params['page']->address;?>" />
</div>
<div>
	<label><?php echo ossn_print('bpage:website');?></label>
	<input type="text" name="website" value="<?php echo $params['page']->website;?>" />
</div>
<div>
	<label><?php echo ossn_print('bpage:type');?></label>
	<?php
		echo ossn_plugin_view('input/dropdown', array(
				'name' => 'category',
				'value' => $params['page']->category,
				'options' => business_page_categories(),
		));
	?>
</div>
<div>
	<input name="guid" type="hidden" value="<?php echo $params['page']->guid;?>" />
	<input type="submit" value="<?php echo ossn_print('save');?>" class="btn btn-primary btn-sm" />
</div>