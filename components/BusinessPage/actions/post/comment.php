<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright 2014-2016 OpenTeknik LLC
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$OssnComment = new OssnComments;
$image       = input('comment-attachment');
//comment image check if is attached or not
if(!empty($image)) {
		$OssnComment->comment_image = $image;
}
//post on which comment is going to be posted
$post = input('post');

//comment text
$comment = input('comment');
if($OssnComment->PostComment($post, ossn_loggedin_user()->guid, $comment)) {
		$vars            = array();
		$object = ossn_get_object($post);
		$vars['comment'] = (array)ossn_get_comment($OssnComment->getCommentId());
		if($object && $object->type == 'businesspage'){
			$business = get_business_page($object->owner_guid);
			if($vars['comment']['owner_guid'] == $business->owner_guid){
					$vars['businesspage'] = $business;
			}
		}		
		$data            = ossn_comment_view($vars);
		if(!ossn_is_xhr()) {
				redirect(REF);
		} else {
				header('Content-Type: application/json');
				echo json_encode(array(
						'comment' => $data,
						'process' => 1
				));
		}
} else {
		if(!ossn_is_xhr()) {
				redirect(REF);
		} else {
				header('Content-Type: application/json');
				echo json_encode(array(
						'process' => 0
				));
		}
}