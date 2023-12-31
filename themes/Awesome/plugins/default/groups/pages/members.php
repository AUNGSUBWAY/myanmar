<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright 2014-2017 OpenTeknik LLC
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$members = $params['group']->getMembers();
$count = $params['group']->getMembers(true);
if ($members) {
    foreach ($members as $user) {
      ?>
		<div class="ossn-group-members">
	        <div class="row">
            	<div class="col-md-2 col-sm-2 hidden-xs">
    	        		<img src="<?php echo $user->iconURL()->large; ?>" width="100" height="100"/>
				</div>
                <div class="col-md-10 col-sm-10 col-xs-12">
	    	        <div class="uinfo">
                        <?php
							echo ossn_plugin_view('output/url', array(
									'text' => $user->fullname,
									'href' =>  $user->profileURL(),
									'class' => 'userlink',
							));						
						?>
        	   		</div>
                        <div class="right request-controls">
	                        <?php
	    						if ((ossn_isAdminLoggedin() || ossn_loggedin_user()->guid == $params['group']->owner_guid) && $user->guid !== $params['group']->owner_guid && $params['group']->isMember($params['group']->guid, $user->guid)) {
	    								echo ossn_plugin_view('output/url', array(
	    									'text' => ossn_print('group:memb:remove'),
	    									'href' =>  ossn_site_url("action/group/member/decline?group={$params['group']->guid}&user={$user->guid}", true),
		    								'class' => 'btn btn-warning btn-responsive ossn-make-sure btn-sm'
		    						));
						        		echo ossn_plugin_view('output/url', array(
					    					'data-new-owner' => $user->fullname,
					    					'data-is-admin' => ossn_isAdminLoggedin(),
						    				'text' => ossn_print('group:memb:make:owner'),
						    				'href' =>  ossn_site_url("action/group/change_owner?group={$params['group']->guid}&user={$user->guid}", true),
						    				'class' => 'btn btn-danger btn-responsive ossn-group-change-owner btn-sm'
						    		));
		    					}
		    				?>		
                        </div>

               </div>
            </div>           
        </div>
    <?php
    }
	echo ossn_view_pagination($count);
}?>