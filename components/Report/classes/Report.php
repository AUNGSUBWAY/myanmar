<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright 2014-2017 OpenTeknik LLC
 * @license   OPENTEKNIK LLC, COMMERCIAL LICENSE v1.0  https://www.openteknik.com/license/
 * @link      https://www.openteknik.com/
 */
 class Report extends OssnObject {
		public function addReport($guid = '', $reason = '', $type = ''){
				if(empty($guid) || empty($type)){
					return false;	
				}
				$this->title 		= "";
				$this->type  		= 'site';
				$this->subtype 		= 'report';
				$this->owner_guid  	= 1;
				$this->description = $reason;
				
				$this->data->container_guid = $guid;
				$this->data->container_type = $type;
				$this->data->reported_by 	= ossn_loggedin_user()->guid;
				return $this->addObject();
		}
		public function getAll(array $params = array()) {
				$default             = array();
				$default['type']     = 'site';
				$default['subtype']  = 'report';
				$default['order_by'] = 'o.guid DESC';
				
				$vars = array_merge($default, $params);
				return $this->searchObject($vars);
		}
 }