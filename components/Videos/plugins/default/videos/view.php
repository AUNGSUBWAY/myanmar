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
 if(isset($video->is_pending) && $video->is_pending != false){
	 $contents = ossn_plugin_view('videos/pending', $params);
 } else {
	 $contents = ossn_plugin_view('videos/view_inner', $params); 
 }
 ?>
 <div class="ossn-page-contents">
 	<?php 
		echo ossn_plugin_view('widget/view', array(
				'title' => $video->title, 
				'contents' => $contents,
		));
	?>
 </div>