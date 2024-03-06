<?php
$SiteSettings = new OssnSite;
$com_white_theme_mode = $SiteSettings->getSettings('com_white_theme_mode');
$image = 'screen.png';
if(!empty($com_white_theme_mode) && $com_white_theme_mode == 'darkmode'){
	$image = 'screen-dark.png';
}
?>
 <fieldset class="titleform">
 	<div class="alert alert-warning">
    	<?php echo ossn_print('theme:goblue:browercache');?>
    </div>	
 	<div>	
    	<label><?php echo ossn_print('theme:goblue:logo:site');?> (400x60 - 500 KB PNG Max) </label>
        <input type="file" name="logo_site" />
        <div class="logo-container-goblue">
            	<?php if(ossn_site_settings('cache') == true){?>
            	<img src="<?php echo ossn_theme_url();?>images/logo.png" />
                <?php } else { ?>
            	<img src="<?php echo ossn_theme_url();?>images/logo.png?v=<?php echo time();?>" />                
                <?php } ?>
        </div>
    </div>
  	<div>	
    	<label><?php echo ossn_print('theme:goblue:logo:admin');?> (180x45 - 500 KB JPG Max)</label>
        <input type="file" name="logo_admin" />
        <div class="logo-container-goblue">
        	<?php
			$logo_url = ossn_add_cache_to_url(ossn_theme_url("images/logo_admin.jpg?v={$time}"));
		?>
            	<img src="<?php echo $logo_url;?>" />
        </div>
    </div>  
  	<div>	
    	<label><?php echo ossn_print('theme:white:homepage:image');?> (PNG, JPG - 500KB Max)</label>
        <input type="file" name="background" />
        <div class="logo-container-goblue">
        	<?php
			$himg= ossn_add_cache_to_url(ossn_theme_url("images/{$image}?v={$time}"));
		?>
            	<img src="<?php echo $himg;?>" />  
        </div>
    </div>      
    <div>
        <label><?php echo ossn_print('theme:white:latestmember:widget');?></label>    
        <?php
			$SiteSettings = new OssnSite;
			$com_white_theme_members_widget = $SiteSettings->getSettings('com_white_theme_members_widget');
			echo ossn_plugin_view('input/dropdown', array(
					'name' => 'com_white_theme_members_widget',
					'value' => $com_white_theme_members_widget,
					'options' => array(
						'enabled' => ossn_print('admin:button:enabled'),
					 	'disabled' => ossn_print('admin:button:disabled'),
					),
			));
		?>  	
    </div>    
    <div>
    	<label><?php echo ossn_print('theme:white:default:mode');?></label>    	
        <?php
			$SiteSettings = new OssnSite;
			$com_white_theme_mode = $SiteSettings->getSettings('com_white_theme_mode');
			echo ossn_plugin_view('input/dropdown', array(
					'name' => 'com_white_theme_mode',
					'value' => $com_white_theme_mode,
					'options' => array(
						'litemode' => ossn_print('theme:white:litemode'),
					 	'darkmode' => ossn_print('theme:white:darkmode'),
					),
			));
		?>  	
    </div>        
	<input type="submit" class="btn btn-success btn-sm" value="<?php echo ossn_print('save');?>"/>
</fieldset>