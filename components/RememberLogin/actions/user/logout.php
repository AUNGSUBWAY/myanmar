<?php
/**
 * Open Source Social Network
 *
 * @package   (openteknik.com).ossn
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright 2014-2017 OpenTeknik LLC
 * @license   OPENTEKNIK  LLC, COMMERCIAL LICENSE, COMMERCIAL LICENSE https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.opensource-socialnetwork.org/
 */

if (isset($_COOKIE['rl_uma'])) {
    unset($_COOKIE['rl_uma']);
	setcookie('rl_uma', '', time() - 3600, '/');
}
if (isset($_COOKIE['rl_vfp'])) {
	unset($_COOKIE['rl_vfp']);
	setcookie('rl_vfp', '', time() - 3600, '/');
}
ossn_logout();
redirect();	
