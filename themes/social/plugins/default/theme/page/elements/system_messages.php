<?php
/**
 * Open Source Social Network
 *
 * @package   (openteknik.com).ossn
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   OPENTEKNIK  LLC, COMMERCIAL LICENSE, COMMERCIAL LICENSE https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.opensource-socialnetwork.org/
 */
 	$col = "col-md-11";
	if(isset($params['admin']) && $params['admin'] === true){
		$col = "col-md-12";
	}
 ?>
<div class="ossn-system-messages">
   <div class="row">
	   <div class="<?php echo $col;?> ossn-system-messages-inner">
    		<?php echo ossn_display_system_messages(); ?>
   		</div>
	</div>
</div>    