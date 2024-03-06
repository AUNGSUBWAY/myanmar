<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OPENTEKNIK  LLC, COMMERCIAL LICENSE
 * @license   OPENTEKNIK  LLC, COMMERCIAL LICENSE, COMMERCIAL LICENSE https://www.openteknik.com/license/commercial-license-v1
 * @link      http://www.openteknik.com/
 */
define('_MultiUpload_', ossn_route()->com . 'MultiUpload/');
ossn_register_class(array(
		'MultiUpload' => _MultiUpload_ . 'classes/MultiUpload.php',
));
ossn_register_callback('ossn', 'init', function (): void {
		ossn_extend_view('css/ossn.default', 'multiupload/css');
		ossn_extend_view('js/ossn.site', 'multiupload/js');

		if(ossn_isLoggedin()) {
				ossn_extend_view('wall/templates/wall/user/item', 'multiupload/item');
				ossn_extend_view('wall/templates/wall/group/item', 'multiupload/item');
				ossn_extend_view('wall/templates/wall/businesspage/item', 'multiupload/item');

				ossn_register_callback('wall', 'post:created', 'multiupload');
				ossn_register_callback('action', 'load', 'multiupload_action_init');
		}

		ossn_register_page('multiupload', 'multiupload_image_handler');

		ossn_new_external_js('jquery.fancybox.min.js', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', false);
		ossn_new_external_css('jquery.fancybox.min.css', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css', false);

		ossn_load_external_css('jquery.fancybox.min.css');
		ossn_load_external_js('jquery.fancybox.min.js');
});
function multiupload_image_url($image) {
		if($image) {
				$hash = hash('sha1', $image->guid);
				return ossn_site_url("multiupload/{$image->guid}/{$hash}.jpg");
		}
}
function multiupload_image_handler($pages) {
		$guid = $pages[0];
		$file = ossn_get_file($guid);
		if($file && $file->type == 'object' && $file->subtype == 'file:wallmultiupload') {
				$file->output();
		}
}
function multiupload($callback, $type, $params) {
		$guid = $params['guid'];
		$wall = new OssnWall();
		if($post = $wall->getPost($guid)) {
				$images = ossn_input_images('multiphotos');
				if($images) {
						$guids = array();
						$total = count($images);
						if($total > 1) {
								foreach($images as $image) {
										$_FILES['_tempMultiUpload'] = $image;
										$file                       = new OssnFile();
										$file->owner_guid           = $post->guid;
										$file->type                 = 'object';
										$file->subtype              = 'wallmultiupload';
										$file->setExtension(array(
												'jpg',
												'png',
												'jpeg',
												'jfif',
												'gif',
												'webp',
										));
										$file->setFile('_tempMultiUpload');
										$file->setPath('ossnwall/multiupload/');
										if(ossn_file_is_cdn_storage_enabled()) {
												$file->setStore('cdn');
										}
										if($fileguid = $file->addFile()) {
												$guids[] = $fileguid;
										}
								}
								if(!empty($guids)) {
										$json = $post->description;
										$data = json_decode($json, true);

										//restore text
										$text = ossn_input_escape($data['post']);
										$text = ossn_restore_new_lines($text);

										//make sure we restore new linse back to \r\n
										$data['post'] = ossn_input_escape($data['post']);
										$post->description = json_encode($data, JSON_UNESCAPED_UNICODE);

										$post->data->multiupload_guids = implode(',', $guids);
										$post->save();
								}
						}
				}
		}
}
function multiupload_action_init($callback, $type, $params) {
		$wall = array(
				'wall/post/a',
				'wall/post/g',
				'wall/post/u',
				'wall/post/bpage',
		);
		if(in_array($params['action'], $wall)) {
				$images = ossn_input_images('multiphotos');
				if($images) {
						$total = count($images);
						if($total == 1) {
								//if it is one image treat it as wall photo.
								$_FILES['ossn_photo'] = $images[0];
						}
				}
		}
}