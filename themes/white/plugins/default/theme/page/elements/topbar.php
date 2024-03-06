<?php if(!ossn_isLoggedin()){ ?>
<div class="topbar site-name-sm">
	<div class="container-fluid">
    	<div class="row site-name-container">
        	<div class="col-md-8 site-name text-center">
                <span onclick="Ossn.redirect('');"><img class="site-logo" src="<?php echo ossn_theme_url();?>images/logo.png" /></span>
            </div>
            <div class="col-md-4 hidden-xs">
                    <a href="<?php echo ossn_site_url();?>login" class="btn btn-primary login-topbar"><?php echo ossn_print('site:login');?></a>
                    <a href="<?php echo ossn_site_url();?>login" class="btn btn-success register-topbar"><?php echo ossn_print('site:register');?></a>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php
	$hide_loggedin = '';
	if(!ossn_isLoggedin()){		
		$hide_loggedin = "hidden-xs hidden-sm";
		return;
	}
?>
<!-- ossn topbar -->
<div class="topbar visible-xs visible-sm site-name-sm">
	<div class="container-fluid">
    	<div class="row site-name-container">
        	<div class="col-md-12 site-name text-center">
                <span onclick="Ossn.redirect('');"><img class="site-logo" src="<?php echo ossn_theme_url();?>images/logo.png" /></span>
            </div>
        </div>
        <div class="search-topbar-sm">
                <?php
				echo ossn_view_form('search', array(
								'component' => 'OssnSearch',
								'class' => 'ossn-search',
								'tabindex' => 0,
								'autocomplete' => 'off',
								'method' => 'get',
								'security_tokens' => false,
								'action' => ossn_site_url("search"),
					), false);
				?>             
        </div>
   </div>
</div>
<div class="topbar">
	<div class="container-fluid">
		<div class="row">
			<div class="col-4 col-lg-2 col-md-3 col-lg-4 left-side left">
				<?php if(ossn_isLoggedin()){ ?>
				<div class="topbar-menu-left">
					<li id="sidebar-toggle" data-toggle='0'>
						<a role="button" data-target="#"> <i class="fa fa-th-list"></i></a>
					</li>
					<li id="topbar-search" class="hidden-md hidden-lg hidden-xl" data-toggle='0'>
						<a role="button" data-target="#"> <i class="fa fa-search"></i></a>
					</li>                    
                <?php
				echo ossn_view_form('search', array(
								'component' => 'OssnSearch',
								'class' => 'ossn-search hidden-xs hidden-sm',
								'tabindex' => 0,
								'autocomplete' => 'off',
								'method' => 'get',
								'security_tokens' => false,
								'action' => ossn_site_url("search"),
					), false);
				?>                   
				</div>
				<?php } ?>
			</div>
			<div class="d-none d-md-block col-md-5 col-lg-4 site-name text-center <?php echo $hide_loggedin;?>">
                <span onclick="Ossn.redirect('');"><img class="site-logo-logged" src="<?php echo ossn_theme_url();?>images/logo.png" /></span>
			</div>
			<div class="col-8 col-md-4 col-lg-4 text-right right-side">
				<div class="topbar-menu-right">
					<ul>
                	<li class="user-image-name hidden-xs hidden-sm">
                    	<img src="<?php echo ossn_loggedin_user()->iconURL()->smaller;?>" />
                        <span onclick="Ossn.redirect('u/<?php echo ossn_loggedin_user()->username;?>');"><?php echo ossn_loggedin_user()->first_name;?></span></a>
                    </li>                    
					<li class="ossn-topbar-dropdown-menu">
						<div class="dropdown">
						<?php
							if(ossn_isLoggedin()){						
								echo ossn_plugin_view('output/url', array(
									'role' => 'button',
									'data-bs-toggle' => 'dropdown',
									'data-bs-target' => '#',
									'text' => '<i class="fa fa-sort-down"></i>',
								));									
								echo ossn_view_menu('topbar_dropdown'); 
							}
							?>
						</div>
					</li>                
					<?php
						if(ossn_isLoggedin()){
							echo ossn_plugin_view('notifications/page/topbar');
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ./ ossn topbar -->
