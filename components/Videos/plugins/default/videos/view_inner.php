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
 $video = $params['video'];
 $entity = ossn_get_entities(array(
		'type' => 'object',
		'owner_guid' => $video->guid,
		'subtype' => 'file:video',
  ));
 ?>
<video id="videojs-item-<?php echo $video->guid;?>" class="ossn-video-player video-js vjs-theme-sea" poster="<?php echo $video->getCoverURL();?>" controls="controls" preload="none">
	<source type="video/mp4" src="<?php echo $video->getFileURL();?>"></source>
</video> 
<script>
	var player = videojs('videojs-item-<?php echo $video->guid;?>');
	player.fluid(true);
</script>
<div class="ossn-video-description">
	<p><?php echo $video->description;?> <span class="time-created"><?php echo ossn_user_friendly_time($video->time_created); ?></span></p>
</div>
<?php
	$vars['entity'] = $entity[0];
	$vars['full_view'] = true;
	echo ossn_plugin_view('entity/comment/like/share/view', $vars);
?>
<?php 
$user = ossn_loggedin_user();
if(ossn_isLoggedin()){
	if($user->guid == $video->owner_guid || $user->canModerate()){ ?>
<div class="ossn-video-controls"> 
	<a href="<?php echo $video->getDeleteURL();?>" class="btn btn-danger btn-sm"><?php echo ossn_print('video:com:delete');?></a>
	<a href="<?php echo $video->getEditURL();?>" class="btn btn-success btn-sm"><?php echo ossn_print('video:com:edit');?></a>
</div>
<?php
	}
}