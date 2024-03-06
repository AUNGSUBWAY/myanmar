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
namespace Ossn\Component\BusinessPage;
class Page extends \OssnObject {
		/**
		 * Categories for page
		 *
		 * @return array
		 */
		public static function categories() {
				return array(
						'business',
						'brand',
						'product',
						'artist',
						'public:figure',
						'entertainment',
						'cause',
						'community',
						'org'
				);
		}
		/**
		 * Add business page
		 * 
		 * @param array $vars A option values
		 * 
		 * @return boolean
		 */				
		public function addPage(array $vars = array()) {
				if(!empty($vars['name']) && !empty($vars['category']) && !empty($vars['description'])) {
						$this->title       = $vars['name'];
						$this->description = $vars['description'];
						
						$this->type       = 'user';
						$this->owner_guid = ossn_loggedin_user()->guid;
						$this->subtype    = 'business:page';
						
						$this->data->category = $vars['category'];
						$this->data->website  = $vars['website'];
						$this->data->phone    = $vars['phone'];
						$this->data->address  = $vars['address'];
						return $this->addObject();
				}
				return false;
		}
		/**
		 * Edit business page
		 * 
		 * @param integer $guid A page guid
		 * 
		 * @return boolean
		 */				
		public function editPage($guid, $vars) {
				$page = ossn_get_object($guid);
				if(empty($guid) || !$page) {
						return false;
				}
				if($page->owner_guid == ossn_loggedin_user()->guid || ossn_loggedin_user()->canModerate()) {
						$page->title          = $vars['name'];
						$page->description    = $vars['description'];
						$page->data->category = $vars['category'];
						$page->data->website  = $vars['website'];
						$page->data->phone    = $vars['phone'];
						$page->data->address  = $vars['address'];
						return $page->save();
				}
				return false;
		}
		/**
		 * Delete businesspage
		 * 
		 * @param integer $guid A page guid
		 * 
		 * @return boolean
		 */				
		public function deletePage($guid) {
				$page = get_business_page($guid);
				if(empty($guid) || !$page) {
						return false;
				}
				return business_page_delete($page);
		}		
		/**
		 * Get user pages
		 *
		 * @param array $params A option values
		 * 
		 * @return object
		 */
		public function getUserPages($user_guid, $params = array()) {
				if(empty($user_guid)) {
						return false;
				}
				$vars = array(
						'type' => 'user',
						'subtype' => 'business:page',
						'owner_guid' => $user_guid
				);
				$args = array_merge($vars, $params);
				return $this->searchObject($args);
		}
		/**
		 * Get business pages
		 * 
		 * @param array $params A option values
		 * 
		 * @return boolean
		 */				
		public function getPages($params = array()) {
				$vars = array(
						'type' => 'user',
						'subtype' => 'business:page',
				);
				$args = array_merge($vars, $params);
				return $this->searchObject($args);
		}	
		/**
		 * Get photo URL
		 * 
		 * @param string $type A photo type
		 * 
		 * @return string
		 */				
		public function photoURL($type = "master") {
				if(isset($this->photo_entity_guid) && !empty($this->photo_entity_guid)) {
						$hash = sha1($this->guid);
						return ossn_site_url("page/photo/{$this->photo_entity_guid}/{$type}/{$hash}.jpg");
				} else {
						return ossn_site_url("page/photo/{$this->guid}/default.jpg");
				}
		}
		/**
		 * Get cover URL
		 * 
		 * @return string
		 */			
		public function coverURL() {
				if(isset($this->cover_entity_guid) && !empty($this->cover_entity_guid)) {
						$hash = sha1($this->guid);
						return ossn_site_url("page/cover/{$this->cover_entity_guid}/{$hash}.jpg");
				} else {
						return ossn_site_url("page/cover/{$this->guid}/default.jpg");
				}
		}
		/**
		 * Get pages that user liked
		 *
		 * @return boolean|array
		 */
		 public function getLikedPages($guid = '', $params = array()) {
			 	if(empty($guid)){
					return false;	
				}
				$vars = array(
						'type' => 'user',
						'subtype' => 'business:page',
						'wheres' => "(o.guid IN(SELECT DISTINCT subject_id FROM `ossn_likes` WHERE `guid` = {$guid}  AND `type` LIKE 'business:page'))",
						
				);
				$args = array_merge($vars, $params);
				return $this->searchObject($args);
		 }
}