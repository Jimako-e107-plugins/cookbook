<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Latest recipes menu
*/

if (!defined('e107_INIT'))
{
    require_once("../../class2.php");
}

// TODO Make menu inaccessible when plugin is not installed.

// Load the LAN files
e107::lan('cookbook', false, true);

class cookbook_categoriesmenu
{

    public $template = array();

    function __construct()
    {
        $this->template = e107::getTemplate('cookbook', 'cookbook_categoriesmenu', 'default');
    }

    public function render($parm = null)
    {
        $text = '';
        //$limit  = 10; // Number of categories to display // Unused for now

        // Retrieve the categories
        if($count = e107::getDb()->count('cookbook_categories'))
        {
            if($categories = e107::getDb()->retrieve('cookbook_categories', 'c_id', '', true))
            {
                // Load shortcodes
                $sc = e107::getScBatch('cookbook', TRUE);

                foreach($categories as $category)
                {
                    // Convert to vars used in shortcodes:
                    $category['r_category'] = $category['c_id'];

                    // Pass vars to shortcodes
                    $sc->setVars($category);
                    
                    // Return render item from template
                    $text .= e107::getParser()->parseTemplate($this->template['item'], false, $sc);
                }
            }
            else
            {
                $text = LAN_ERROR; 
                // TODO check for SQL error 
            }

            return $text; 
        }
        // Query invalid or no categories
        else
        {
            $text = LAN_CB_NOCATS;
            // TODO check for SQL error 
        }

        return $text;
    }
}



$class = new cookbook_categoriesmenu;

if(!isset($parm))
{
    $parm = null;
}

$text = $class->render($parm);


// Set default caption
$caption = LAN_CATEGORIES;


// Allow for custom caption through shortcode parm 
if (!empty($parm))
{
    if(isset($parm['caption'][e_LANGUAGE]))
    {
        $caption = empty($parm['caption'][e_LANGUAGE]) ? LAN_CATEGORIES : $parm['caption'][e_LANGUAGE];
    }
}

// Pass caption to shortcode in template 
$var        = array('COOKBOOK_CATEGORIESMENU_CAPTION' => $caption);
$caption    = e107::getParser()->simpleParse($class->template['caption'], $var);

// Load start and end from template
$start  = $class->template['start'];
$end    = $class->template['end'];

e107::getRender()->tablerender($caption, $start . $text . $end, 'cookbook_categoriesmenu');