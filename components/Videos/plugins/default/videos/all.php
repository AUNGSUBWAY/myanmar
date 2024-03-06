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
$videos = new Videos();
$owner  = input('owner_guid');
if(empty($owner)) {
		$vars = array(
				'entities_pairs' => array(
						array(
								'name'  => 'is_pending',
								'value' => false,
						),
				),
		);
		$all = $videos->getAll($vars);
		$vars['count'] = true;
		$count = $videos->getAll($vars);
} else {
		$all = $videos->getAll(array(
				'owner_guid'     => $owner,
				'entities_pairs' => array(
						array(
								'name'  => 'is_pending',
								'value' => false,
						),
				),
		));
		$count = $videos->getAll(array(
				'count'          => true,
				'owner_guid'     => $owner,
				'entities_pairs' => array(
						array(
								'name'  => 'is_pending',
								'value' => false,
						),
				),
		));
}
 if($all){
	echo "<div class='ossn-videos-list'>";
	foreach($all as $video){
		?>
        	<div class="row ossn-video-item">
            	<div class="col-md-12">
            		
                    <a href="<?php echo $video->getURL();?>">
                    	<div class="video-image" style="background:url('<?php echo $video->getCoverURL();?>');background-size: cover;"></div>
                    </a>
            		<div class="video-meta-data">
                    	
                        <div class="video-title">
                        		<a href="<?php echo $video->getURL();?>"><?php echo $video->title;?></a>
                        </div>
                        <div class="description">
                        	<?php echo strl($video->description, 200); ?>
                        </div>
                        <div class="time-created"><?php echo ossn_user_friendly_time($video->time_created); ?></div>
                    </div>  
                    
                                      
                </div>
            </div>
        <?php	
	}
	echo ossn_view_pagination($count);
	echo "</div>";
 }