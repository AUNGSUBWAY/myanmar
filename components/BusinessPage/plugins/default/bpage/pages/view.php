<?php
/**
 * Open Source Social Network
 *
 * @package   (openteknik.com).ossn
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   OPENTEKNIK  LLC, COMMERCIAL LICENSE, COMMERCIAL LICENSE https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.opensource-socialnetwork.org/
 */
$cover_top = '';
if(!empty($params['page']->cover_top)){
	$cover_top = "top:{$params['page']->cover_top};";
}
$cover_left = '';
if(!empty($params['page']->cover_left)){
	$cover_left = "left:{$params['page']->cover_left};";
}
$like = new \Ossn\Component\BusinessPage\Likes;
$total_likes = $like->CountLikes($params['page']->guid);
if(empty($total_likes)){
	$total_likes = 0;	
}
$cats = business_page_categories();
?>
<div class="container business-page">
	<div class="row">
    	<div class="col-md-2">
        		<img class="logo-page" src="<?php echo $params['page']->photoURL();?>" />
                <?php
					if(ossn_isLoggedin()){
						if($params['page']->owner_guid == ossn_loggedin_user()->guid || ossn_loggedin_user()->canModerate()){
							echo ossn_view_form('bpage/photo', array(
									'action' => ossn_site_url('action/bpage/photo/add'),
									'params' => $params,
									'id' => 'upload-photo-page',
						 	 ));
				?>
                <div class="controls">
	                <a href="<?php echo ossn_site_url("page/edit/{$params['page']->guid}");?>" class="btn btn-success btn-sm"><?php echo ossn_print('bpage:edit');?></a>
    	            <a href="<?php echo ossn_site_url("action/bpage/delete?guid={$params['page']->guid}", true);?>" class="btn-sm btn btn-danger ossn-make-sure"><?php echo ossn_print('bpage:delete');?></a>
                </div>    
                <?php } 
				}?>
                <div class="menu hidden">
                	<li><a href="#">Timeline</a></li>
                	<li><a href="#">About</a></li>
                </div>
                <div class="margin-top-20">
                	<?php if(ossn_isLoggedin() && ossn_site_settings('theme') == 'social'){ 
                			echo ossn_plugin_view('theme/page/elements/sidebar');   
                   		}
					?> 
                </div>
        </div>
        <div  class="col-md-9">
        <div class="top-container">
					<div id="container" class="business-page-cover">
							<div class="business-page-cover-controls">
                         <?php
							if(ossn_isLoggedin()){
									if($params['page']->owner_guid == ossn_loggedin_user()->guid || ossn_loggedin_user()->canModerate()){     
							?>
							<a href="javascript:void(0);" onclick="Ossn.Clk('.coverfile');" class="btn-action change-cover" id="change-bpcover-btn">
								<?php echo ossn_print('bpage:change:cover');?>
                            </a>
							<a href="javascript:void(0);" id="reposition-cover-page" class="btn-action reposition-cover">
								<?php echo ossn_print('bpage:reposition');?>
                            </a>
							<a href="javascript:void(0);" id="save-position-cover-page" class="btn-action reposition-cover">
								<?php echo ossn_print('bpage:save:position');?>
                            </a>              
                            <?php } ?>
                            <?php if(!$like->isLiked($params['page']->guid, ossn_loggedin_user()->guid)){ ?>
                        	<a href="javascript:void(0);" class="btn-action change-cover like-page" data-guid="<?php echo $params['page']->guid;?>">
								<i class="fa fa-thumbs-up"></i><?php echo ossn_print('ossn:like');?>
                            </a>             
                            <?php } else { ?>
                        	<a href="javascript:void(0);" class="btn-action change-cover unlike-page" data-guid="<?php echo $params['page']->guid;?>">
								<i class="fa fa-thumbs-down"></i><?php echo ossn_print('ossn:unlike');?>
                            </a>                            
                            <?php }
							}?>                            
						</div>
                        <?php
						echo ossn_view_form('bpage/cover', array(
								'action' => ossn_site_url('action/bpage/cover/add'),
								'params' => $params,
								'id' => 'upload-cover-page',
					 	 ))
						?>
						<img id="draggable" class="business-page-cover-img" src="<?php echo $params['page']->coverURL();?>" data-guid="<?php echo $params['page']->guid;?>" style='<?php echo $cover_top; ?><?php echo $cover_left; ?>' />
					</div>
					
					<div class="user-fullname"><?php echo $params['page']->title;?></div>
                    <div class="user-fullname business-page-role"><?php echo $cats[$params['page']->category];?></div>
                    <div class="user-fullname business-page-info">
                    	<?php if(!empty($params['page']->phone)){ ?>
                    	<li><i class="fa fa-phone-square"></i><?php echo $params['page']->phone;?></li>
                        <?php } ?>
                    	<?php if(!empty($params['page']->address)){ ?>
                    	<li><i class="fa fa-location-arrow"></i><?php echo $params['page']->address;?></li>
                         <?php } ?>
                    	<?php if(!empty($params['page']->website)){ 
							   $urlw = false;
							   if(filter_var($params['page']->website, FILTER_VALIDATE_URL)){
								   	$urlw = $params['page']->website;
							   } elseif(strpos($params['page']->website, ".") !== false){
								   	$urlp = parse_url($params['page']->website);
									$count = count($urlp);
									if(isset($urlp['path']) && !empty($urlp['path']) && $count === 1){
										$urlw = "http://{$urlp['path']}/";
									}
							   }	
							   if(!empty($urlw)){
						?>                       
                    	<li><i class="fa fa-link"></i><a style="color:#fff;text-decoration:none;" href="<?php echo $urlw;?>" target="_blank"><?php echo $urlw;?></a></li>
                        <?php
							   }
						} ?>
                    </div>
                    	
                    <div id="business-page-hr-menu" class="business-page-hr-menu">
							<div class="row business-page-metadata">
                            	<div class="col-md-9">
                                		<div class="business-page-desc">
                            			<?php echo $params['page']->description;?>
                           			 </div>
                                </div>
                                <div class="col-md-3 page-likes">
                                		<i class="fa fa-thumbs-up"></i><?php echo $total_likes;?>
                                </div>
                            </div>
                    </div>

			
				</div>
                
                <?php echo ossn_plugin_view('bpage/view/bottom', $params); ?>
        </div>
    </div>
</div>