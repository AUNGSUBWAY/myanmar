<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Source Social Network Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
echo '<div class="comments-likes">';
if (ossn_is_hook('post', 'likes:entity')) {
    $entity['entity_guid'] = $params['entity_guid'];
    echo ossn_call_hook('post', 'likes:entity', $entity);
}
if (ossn_is_hook('post', 'comments:entity')) {
    $entity['entity_guid'] = $params['entity_guid'];
    echo ossn_call_hook('post', 'comments:entity', $entity);
}
echo '</div>';