<?php
/**
 * Meta
 * 
 * @package    Meta
 * @subpackage Admin
 * @author     David Mézière <dmeziere@free.fr>
 * @copyright  Copyright (c) 2014 David Mézière <dmeziere@free.fr>
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

defined('DOKU_INC') or die('This script cannot be called by itself.');

defined('DOKU_PLUGIN') or define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');

require_once(DOKU_PLUGIN . 'admin.php');

class admin_plugin_meta extends DokuWiki_Admin_Plugin
{
    /**
     * return prompt for admin menu
     */
    function getMenuText($language)
    {
        return $this->getLang('menu');
    }

    /**
     * return sort order for position in admin menu
     */
    function getMenuSort()
    {
        return 10;
    }
    
    /**
     * handle user request
     *
     * Initializes internal vars and handles modifications
     * 
     * @return none
     */
    function handle()
    {
        
    }
    
    /**
     * @return none
     */
    function html()
    {
        printf(
            '<div class="row"><div class="col-md-12"><h1>%s</h1></div></div>'.PHP_EOL,
            $this->getLang('title')
        );
    }
}