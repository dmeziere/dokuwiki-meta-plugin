<?php
/**
 * Meta
 * 
 * @package    Meta
 * @subpackage Plugin
 * @author     David Mézière <dmeziere@free.fr>
 * @copyright  Copyright (c) 2014 David Mézière <dmeziere@free.fr>
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

defined('DOKU_INC') or die('This script cannot be called by itself.');

defined('DOKU_PLUGIN') or define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');

require_once(DOKU_PLUGIN . 'syntax.php');

/**
 * Syntax plugin meta
 */
class syntax_plugin_meta extends DokuWiki_Syntax_Plugin
{
    /**
     * Allowed meta names.
     * @var array
     * @see http://www.w3schools.com/tags/tag_meta.asp
     * @see https://support.google.com/webmasters/answer/79812?hl=en
     */
    private $names = array(
        'application-name',
        'author',
        'description',
        'generator',
        'keywords',
        'robots',
        'google'
    );
    
    /**
     * General info.
     * 
     * @see /inc/plugin.php
     * 
     * @return array Associative array.
     */
    function getInfo()
    {
        return array(
            'base'   => 'meta',
            'author' => 'David Mézière',
            'email'  => 'dmeziere@free.fr',
            'date'   => '2014-12-01',
            'name'   => 'Meta tag handling',
            'desc'   => 'Allows to handle global and local meta tags.',
            'url'    => 'https://github.com/dmeziere',
        );
    }
    
    /**
     * Syntax type.
     * 
     * @see /inc/parser/parser.php
     * 
     * @return string One of the $PARSER_MODES.
     */
    function getType()
    {
        return 'substition';
    }

    /**
     * Paragraph type.
     * 
     * @see /lib/plugins/syntax.php
     * 
     * @return string One of normal / block / stack.
     */
    function getPType()
    {
        return 'block';
    }

    /**
     * @return integer Sort order of this plugin.
     */
    function getSort()
    {
        return 98;
    }

    /**
     * Connect pattern to lexer.
     * 
     * @param string $mode Input type.
     * 
     * @return none.
     */
    function connectTo($mode)
    {
        $this->Lexer->addSpecialPattern('\{META (?:'.join('|', $this->names).')\}[^}]+\{\/META\}', $mode, 'plugin_meta');
    }

    /**
     * Handle the match.
     * 
     * @param string $match The text matched by the patterns.
     * @param integer $state The lexer state for the match.
     * @param integer $pos The character position of the matched text.
     * @param Doku_Handler $handler The Doku_Handler object.
     * 
     * @return array All data you want to use in render.
     */
    function handle($match, $state, $pos, &$handler)
    {
        $data = array();

        // Get the numeric part of the tag.
        preg_match("/^\{META (?P<meta>(?:'.join('|', $this->names).'))\}(?P<value>[^}]+)\{\/META\}$/", $match, $data);
        
        return array(
            $data['meta'] => trim($data['value'])
        );
    }

    /**
     * Handles the actual output creation.
     * 
     * @param string $format Output format being rendered.
     * @param Doku_Renderer $renderer The current renderer object.
     * @param array $data Data created by handler().
     * 
     * @return boolean Rendered correctly?
     */
    function render($format, &$renderer, $data)
    {
        // Ads display when format is xhtml.
        if ($format === 'metadata') {
            if (isset($renderer->meta['plugin_meta'])) {
                $renderer->meta['plugin_meta'] = array_merge(
                    $renderer->meta['plugin_meta'],
                    $data
                );
            } else {
                $renderer->meta['plugin_meta'] = $data;
            }
        }
        
        return true;
    }

}
