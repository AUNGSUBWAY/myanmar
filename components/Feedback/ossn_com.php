<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    OSSN Core Team https://www.openteknik.com/contact
 * @copyright (C) OpenTeknik LLC
 * @license   OPENTEKNIK  LLC, COMMERCIAL LICENSE, COMMERCIAL LICENSE https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.opensource-socialnetwork.org/
 */
define('Feedback', ossn_route()->com . 'Feedback/');
require_once Feedback . 'classes/Feedback.php';
function ossn_feedback_init() {
		ossn_register_com_panel('feedback', 'settings');
		ossn_extend_view('css/ossn.default', 'feedback/css');

		if(ossn_isLoggedin()) {
				ossn_register_action('feedback/add', Feedback . 'actions/add.php');
				ossn_new_external_css('jquery.rateyo.min.css', '//cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css', false);
				ossn_new_external_js('jquery.rateyo.min.js', '//cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js', false);

				ossn_register_page('feedback', 'feedback_page_handler');
				ossn_register_sections_menu('newsfeed', array(
						'name'   => 'feedback',
						'text'   => ossn_print('feedback'),
						'url'    => ossn_site_url('/feedback'),
						'parent' => 'links',
				));
		}
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('feedback/delete', Feedback . 'actions/delete.php');
		}

		//remove annoying button
		//$feedback = new Feedback;
		//if(!$feedback->feedbackExists() && ossn_isLoggedin()) {
		//ossn_extend_view('ossn/site/head', 'feedback/js');
		//}
}
function feedback_page_handler() {
		ossn_load_external_js('jquery.rateyo.min.js');
		ossn_load_external_css('jquery.rateyo.min.css');
		$title   = ossn_print('feedback');
		$content = ossn_set_page_layout('newsfeed', array(
				'content' => ossn_plugin_view('feedback/add'),
		));
		echo ossn_view_page($title, $content);
}
ossn_register_callback('ossn', 'init', 'ossn_feedback_init');