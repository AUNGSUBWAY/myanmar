<video id="videojs-wall-item-<?php echo $params['itemguid'];?>" class="ossn-video-player video-js vjs-theme-sea" poster="<?php echo $params['video']->getCoverURL();?>" controls="controls" preload="none">
	<source type="video/mp4" src="<?php echo $params['video']->getFileURL();?>"></source>
</video> 
<script>
	var player = videojs('videojs-wall-item-<?php echo $params['itemguid'];?>');
	player.fluid(true);
</script>
<div class="ossn-video-description">
	<p><?php echo $params['video']->description;?></p>
</div>
<?php