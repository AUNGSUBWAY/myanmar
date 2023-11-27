<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OPENTEKNIK  LLC, COMMERCIAL LICENSE
 * @license   OPENTEKNIK  LLC, COMMERCIAL LICENSE, COMMERCIAL LICENSE https://www.openteknik.com/license/commercial-license-v1
 * @link      http://www.opensource-socialnetwork.org/licence
 */
$owner = ossn_user_by_guid($params['event']->owner_guid);
//pass the each relation id to loop, becasue there is bug in OSSN v4.1 which is fixed in v4.2 , 
//the relation with array types without inverse throws error
$default_status = false;
foreach(ossn_events_relationship_default() as $item) {
        $data = ossn_relation_exists(ossn_loggedin_user()->guid, $params['event']->guid, $item);
        if(isset($data)) {
                $loop_decision[$item] = $data;
				if($data){
						$default_status = $item;
				}
        }
}
$decision     = $loop_decision;
$interested   = ossn_get_relationships(array(
        'to' => $params['event']->guid,
        'type' => 'event:interested',
        'count' => true
));
$nointerested = ossn_get_relationships(array(
        'to' => $params['event']->guid,
        'type' => 'event:nointerested',
        'count' => true
));
$going        = ossn_get_relationships(array(
        'to' => $params['event']->guid,
        'type' => 'event:going',
        'count' => true
));
$comment_wall = ossn_get_entities(array(
		'type' => 'object',
		'subtype' => 'event:wall',
		'owner_guid' => $params['event']->guid,
));
$comments = $comment_wall[0];
?>
<div class="ossn-page-contents">
	<div class="events">
		<?php if(isset($params['event']->is_finished) && $params['event']->is_finished == 'yes'){ ?>
        	<div class="alert alert-warning"><?php echo ossn_print('event:finished'); ?></div>
		<?php } ?>
        <div class="event-title">
    		<span><?php echo $params['event']->title;?></span>
             <div class="controls">                       
                   <?php if($params['event']->owner_guid == ossn_loggedin_user()->guid || (ossn_isLoggedin() && ossn_loggedin_user()->canModerate())){ ?>
                       <a href="<?php echo ossn_site_url("event/edit/{$params['event']->guid}");?>" class="badge bg-success label label-success" title=" <?php echo ossn_print("edit");?>"><i class="fa fa-pencil-alt"></i></a>
                       <a href="<?php echo ossn_site_url("action/event/delete?guid={$params['event']->guid}", true);?>" class="badge bg-danger label label-danger ossn-make-sure" title="<?php echo ossn_print("delete");?>" data-ossn-msg="<?php echo ossn_print('event:delete:makesure');?>"><i class="fa fa-trash"></i></a>
                   <?php } ?>
             </div>            
    	</div>
        
        <div class="row margin-top-10">
        	<div class="col-md-5">
            	<div class="image-event">
                	<img src="<?php echo $params['event']->iconURL();?>" />
                </div>
                <div class="manager-control">
                	<div class="event-manager">
                    	<?php 
						$url = ossn_plugin_view('output/url', array(
									'href' => $owner->profileURL(),
									'text' => $owner->fullname,
						));
						echo ossn_print("event:created:by", array($url)); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-7 event-info">
             <div class="event-actions">
             	<?php 
				if(ossn_isLoggedin() && (isset($params['event']->is_finished) && $params['event']->is_finished != 'yes' || !isset($params['event']->is_finished)) ){
					if(isset($decision['event:going']) && !$decision['event:going']){?>
                  <a href="<?php echo ossn_site_url("action/event/decision?guid={$params['event']->guid}&type=going", true);?>" class="btn btn-primary"><?php echo ossn_print("event:going");?></a>
                <?php } ?>
                
                <?php if(isset($decision['event:interested']) && !$decision['event:interested']){?>
            	  <a href="<?php echo ossn_site_url("action/event/decision?guid={$params['event']->guid}&type=interested", true);?>" class="btn btn-info"><?php echo ossn_print("event:interested");?></a>
                <?php } ?>
				
				<?php if(isset($decision['event:nointerested']) && !$decision['event:nointerested']){?>                
            	  <a href="<?php echo ossn_site_url("action/event/decision?guid={$params['event']->guid}&type=nointerested", true);?>" class="btn btn-warning"><?php echo ossn_print("event:nointerested");?></a>
                <?php } ?>
                
				<?php if($default_status !== false){?>
		       			  <button class="btn btn-default"><?php echo ossn_print($default_status);?> </button>
                <?php }
				}?>   
            </div>               
            	<p><?php echo nl2br($params['event']->description);?></p>
            </div>
        </div>
        
        <!-- bottom panel -->
        <!-- bottom panel -->
        <div class="row event-bottom-panel">
        	<div class="col-md-4">
            	<div class="title"><?php echo ossn_print("event:date");?></div>
                <div class="event-date">
                		<div class="event-date-day">
                        	<?php echo date("F, d Y", strtotime($params['event']->date));?>
                        </div>
                </div>                
            </div>
        	<div class="col-md-8">
            	<div class="title"><?php echo ossn_print("event:location");?></div>
                <div class="event-basic-info">
                	<?php echo $params['event']->location; ?>
                </div>                
            </div>             
        </div>   
             
        <div class="row event-bottom-panel">
        	<div class="col-md-4">
            	<div class="title"><?php echo ossn_print("event:going");?></div>
                <div class="counter event-relation" data-guid="<?php echo $params['event']->guid;?>" data-type="1" >
                	<?Php echo $going;?>
                </div>
            </div>
        	<div class="col-md-4">
            	<div class="title"><?php echo ossn_print("event:interested");?></div>
                <div class="counter event-relation" data-guid="<?php echo $params['event']->guid;?>" data-type="2" >
                	<?php echo $interested;?>
                </div>                
            </div>
        	<div class="col-md-4">
            	<div class="title"><?php echo ossn_print("event:nointerested");?></div>
                <div class="counter event-relation" data-guid="<?php echo $params['event']->guid;?>" data-type="3" >
                	<?php echo $nointerested;?>
                </div>                
            </div>
        </div>
        
         <div class="row event-bottom-panel">
        	<div class="col-md-4">
            	<div class="title"><?php echo ossn_print("event:start:time");?></div>
                <div class="counter">
                	<?php echo $params['event']->start_time; ?>
                </div>
            </div>
        	<div class="col-md-4">
            	<div class="title"><?php echo ossn_print("event:end:time");?></div>
                <div class="counter">
                	<?php echo $params['event']->end_time; ?>
                </div>                
            </div>
        	<div class="col-md-4">
            	<div class="title"><?php echo ossn_print("event:price");?></div>
                <div class="counter">
                 	<?php echo $params['event']->event_cost; ?>
                </div>                
            </div>
        </div>       
	<?php
		if($params['event']->allowed_comments_likes){
			$vars['entity'] = ossn_get_entity($comments->guid);
			if(isset($params['event']->is_finished) && $params['event']->is_finished == 'yes'){
				$vars['allow_comment'] = false;
				$vars['allow_like'] = false;			
			}
			echo ossn_plugin_view('entity/comment/like/share/view', $vars);
		}
	?>        
	</div>
</div>