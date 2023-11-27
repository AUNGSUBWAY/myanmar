<?php
	$count = $params['poll']->countVotes();
?>
<div class="row">
<div class="col-md-12">
        <div class="poll-container">
            <div class="poll-title">
                <i class="fa fa-line-chart"></i> 
				<?php echo $params['poll']->title;?> 
                <?php if($count > 0){ ?> <span class="poll-votes-total">(<i class="fas fa-users"></i> <?php echo $count; ?>) </span><?php } ?>
            </div>
            <div class="poll-body">
            	<?php
				$poll = $params['poll'];
				$options = $poll->getOptions();
				$votes = $poll->getVotes();
                if($options){
					foreach($options as $key => $option){ 
						$color = substr($key, 0, 3);
						if($color == '000' || $color == 'fff'){
								$color = '';
						}
						if(strlen($color) > 0){
								$color = "background-color:#{$color};";
						}
				?>
               	 <div class="ossn-polls-item">
				   <div class="row">
                   <div class="col-md-1 col-sm-1 col-xs-1">
                         <div class="btn-group btn-group-vertical" data-toggle="buttons">
       						 <label class="btn active">
        						  <input type="radio" name='option' value="<?php echo $key;?>">
       						 </label>
        </div>
                   </div> 
                  	<div class="col-md-11 col-sm-11 col-xs-11">
                        	  <label><?php echo $option;?></label>
	                		   <div class="progress">
                               		<?php if(isset($votes[$key])){ ?>
 									 <div class="progress-bar" role="progressbar" style="width: <?php echo $votes[$key];?>%;<?php echo $color;?>" aria-valuemax="100">
                      				   <?php echo $votes[$key];?>
                       			    </div>
                                    <?php } else { ?>
  									 <div class="progress-bar" role="progressbar" style="width: 0%;<?php echo $color;?>" aria-valuemax="100">
                      				   &nbsp;0%
                       			    </div>                                   
                                    <?php } ?>
				   			</div>
                 		  </div>
                    </div>   
                 </div>   
                   <?php
					}
				}
				?>
            </div>
            <div class="poll-footer text-center">
            	<input type="hidden" name="guid" value="<?php echo $params['poll']->guid;?>" />
                <?php 
				if(isset($params['poll']->is_ended) && $params['poll']->is_ended == false){ ?>
                <input type="submit" class="btn btn-primary btn-block btn-sm" id="poll-submit-button" value="<?php echo ossn_print('polls:vote');?>"/>
                <?php } ?>
                <div class="ossn-poll-loading-submit">
                	<div class="ossn-loading"></div>
                </div>
    <div class="margin-top-10 text-left">
	                <?php
					if((ossn_isLoggedin() && $poll->owner_guid == ossn_loggedin_user()->guid) || ossn_isAdminLoggedin()){ ?>
                    <?php
					if(!isset($poll->is_ended) || $poll->is_ended == false){ ?>
                    <a href="<?php echo ossn_site_url("action/poll/end?guid={$poll->guid}", true);?>" class="btn btn-sm btn-primary"><?php echo ossn_print('polls:end');?></a>
                    <?php } ?>
                    
                    <?php if($poll->container_type == 'user'){ ?>
        	        <a href="<?php echo ossn_site_url("action/poll/delete?guid={$poll->guid}", true);?>" class="btn btn-sm btn-danger"><?php echo ossn_print('polls:delete');?></a>
                    <?php } ?>
                    
                    <?php } ?>
                    <?php
					if(ossn_isLoggedin() && $poll->container_type == 'group'){
								if(function_exists('ossn_get_group_by_guid')){
										$group =  ossn_get_group_by_guid($poll->container_guid);
										if($group && $group->owner_guid == ossn_loggedin_user()->guid){
	 													?>
           	       										 <a href="<?php echo ossn_site_url("action/poll/delete?guid={$poll->guid}", true);?>" class="btn btn-sm btn-danger"><?php echo ossn_print('polls:delete');?></a>
                                                        <?php
										}	
								}
					}
					?>                    
                </div>
                <?php if(isset($poll->is_ended) && $poll->is_ended == true){ ?>
                		<div class="alert alert-warning margin-top-10"><?php echo ossn_print('polls:ended');?></div>     
                <?php } ?>                
            </div>
        </div>
</div>
</div>