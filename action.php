<?php
/**
 * Meta
 * 
 * @package    Meta
 * @subpackage Action
 * @author     David Mézière <dmeziere@free.fr>
 * @copyright  Copyright (c) 2014 David Mézière <dmeziere@free.fr>
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

defined('DOKU_INC') or die('This script cannot be called by itself.');

defined('DOKU_PLUGIN') or define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');

require_once(DOKU_PLUGIN . 'action.php');

/**
 * Action plugin meta
 */
class action_plugin_meta extends DokuWiki_Action_Plugin
{
    /**
     * @param Doku_Event_Handler $controller
     */
    function register(Doku_Event_Handler &$controller)
    {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'meta', array());
    }

    /**
     * @param Doku_Event $event
     * @param array $param
     */
    function meta(Doku_Event &$event, $param)
    {
        global $ID;
        $data = p_get_metadata($ID);
        
        // For each user-defined meta tags
        foreach($data['plugin_meta'] as $name => $content) {
            $found = false;
            
            // Search it in engine meta tags
            foreach($event->data['meta'] as $index => $meta) {
                if ($meta['name'] === $name) {
                    $event->data['meta'][$index]['content'] = $content;
                    $found = true;
                }
            }

            // When not found, create it
            if (!$found) {
                $event->data['meta'][] = array('name' => $name, 'content' => $content);
            }
        }
    }
}
