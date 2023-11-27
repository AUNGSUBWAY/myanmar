<?php
/**
 * Open Source Social Network
 *
 * @package   (openteknik.com).ossn
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright 2014-2017 OpenTeknik LLC
 * @license   OPENTEKNIK LLC, COMMERCIAL LICENSE  https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.openteknik.com/
 */
if(!isset($params['post']->multiupload_guids)){
		return;
}
$photos = MultiUpload::getPhotos($params['post']->multiupload_guids); 
if(!$photos){
	return;	
}

$content = '<div class="multiupload-output">';
foreach($photos as $image){
	$url =  multiupload_image_url($image);
	$urls[] = $url;
}
$total_actual = intval(count($urls));
$total = false;
if($total_actual > 5){
	$total  = $total_actual-5;
}
$photos = array_chunk($urls, 5);
foreach($photos[0] as $item){
	$content.= "<li><img class='multiupload-photo-item' src='{$item}' /></li>";	
}
$content .= '</div>';
?>
<div class="hidden">
	<?php
    	foreach ($urls as $photo) {	
	?>
		<a data-fancybox="gallery" class="multiupload-gallery-<?php echo $params['post']->guid;?>" data-thumb="<?php echo $photo;?>" href="<?php echo $photo;?>"></a>
    <?php
	}
	?>
</div>
<script>
		$(document).ready(function(){
					var $code = <?php echo json_encode($content);?>;
					$('#activity-item-<?php echo $params['post']->guid;?>').find('.post-contents').append($code);
					
					$('.multiupload-gallery-<?php echo $params['post']->guid;?>').fancybox();
					
					var last = $('#activity-item-<?php echo $params['post']->guid;?> .multiupload-output li:last');					
					$('body').on('click', '#activity-item-<?php echo $params['post']->guid;?> .multiupload-output li', function () {
						$('.multiupload-gallery-<?php echo $params['post']->guid;?>').eq(0).trigger('click');
					});					
					<?php if($total){ ?>
					last.append("<span class='multiupload-view-more'>+<?php echo $total;?></span>");
					last.find('img').addClass('multiupload-img-last');
					<?php } ?>
		});
</script>