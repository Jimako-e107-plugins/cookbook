<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Main frontend
*/

if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}

// Make this page inaccessible when plugin is not installed.
if (!e107::isInstalled('cookbook'))
{
	header('location:'.e_BASE.'index.php');
	exit;
}

// Load the LAN files
e107::lan('cookbook', false, true);

require_once(HEADERF);
$sql = e107::getDb();
$tp  = e107::getParser();

// Load template and shortcodes
$sc = e107::getScBatch('cookbook', TRUE);
$template = e107::getTemplate('cookbook');
$template = array_change_key_case($template); // temporary fix until proper solution is found
$text = '';

/*
	Use $_GET to determine which view we are on, either:
	1. ID = indivual recipe (id = id)
	2. Category = specific category (category = id)
	3. Tag (tag = id)
	4. Tag overview (tag = 0)
	5. Category overview = all recipes split by category (category = 0)
	6. Recipe overview = index (no $_GET specified)
*/

// Individual recipe
if(isset($_GET['id']))
{
	// Retrieve all information of the individual recipe from the database
	if($recipe = $sql->retrieve('cookbook_recipes', '*', 'r_id = '.(int)$_GET['id'].''))
	{
		// Set title
		$caption = " - ".$recipe['r_name'];

		// Pass database info onto the shortcodes
		$sc->setVars($recipe);

		// Display using template
		$text .= $tp->parseTemplate($template['recipe_item'], false, $sc);
	}
	// Recipe ID not found
	else
	{
		$text .= "<div class='alert alert-danger text-center'>".LAN_CB_RECIPENOTFOUND."</div>";
		// TODO notify admin
	}

	// Let's render and show it all!
	e107::getRender()->tablerender(LAN_CB_RECIPE.$caption, $text);
}

// Individual category
elseif(isset($_GET['category']) && $_GET['category'] != 0)
{
	// Split and do some lookups do figure out category id and name.
	$category_full 	= e107::getParser()->toDb($_GET['category']);
	$category 		= explode('/', $category_full);
	$category_id 	= $category[0];
	$category_name 	= $sql->retrieve('cookbook_categories', 'c_name', 'c_id = '.$category_id.'');

	// Retrieve all recipe entries within this category
	$recipes = $sql->retrieve('cookbook_recipes', '*', 'r_category = '.$category_id.'', TRUE);

	// Check if there are recipes in this category
	if($recipes)
	{
	 	$text .= $tp->parseTemplate($template['overview']['start'], false, $sc);

		foreach($recipes as $recipe)
		{
			// Pass query values onto the shortcodes
			$sc->setVars($recipe);
			$text .= $tp->parseTemplate($template['overview']['items'], false, $sc);
		}

		$text .= $tp->parseTemplate($template['overview']['end'], false, $sc);
	}
	// No recipes yet
	else
	{
		$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPESINCAT."</div>";
	}

	// Let's render and show it all!
	e107::getRender()->tablerender(LAN_CATEGORY." - ".$category_name, $text);
}

// Tag
elseif(isset($_GET['tag']) && $_GET['tag'] != '0')
{
	$tag = e107::getParser()->toDb($_GET['tag']);

	// Retrieve all recipe entries with this tag
	$recipes = $sql->retrieve('cookbook_recipes', '*', 'r_tags LIKE "%'.$tag.'%"', TRUE);

	// Check if there are recipes in this category
	if($recipes)
	{
	 	$text .= $tp->parseTemplate($template['overview']['start'], false, $sc);

		foreach($recipes as $recipe)
		{
			// Pass query values onto the shortcodes
			$sc->setVars($recipe);
			$text .= $tp->parseTemplate($template['overview']['items'], false, $sc);
		}

		$text .= $tp->parseTemplate($template['overview']['end'], false, $sc);
	}
	// No recipes with this tag
	else
	{
		$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPES."</div>";
	}

	// Let's render and show it all!
	e107::getRender()->tablerender(LAN_CB_TAG." - ".$tag, $text);
}

// Tag overview
elseif(isset($_GET['tag']) && $_GET['tag'] == '0')
{
	$text .= $tp->parseTemplate($template['tagoverview'], false, $sc);
	e107::getRender()->tablerender(LAN_CB_TAG_OVERVIEW, $text);
}

// Category overview
elseif(isset($_GET['category']) && $_GET['category'] == '0')
{
	// Retrieve all categories
	$categories = $sql->retrieve('cookbook_categories', '*', '', TRUE);

	// Loop through categories and display recipes for each category
	foreach($categories as $category)
	{
		$text .= "<h3>".$category['c_name']."</h3>";

		// Retrieve all recipe entries for this category
		$recipes = $sql->retrieve('cookbook_recipes', '*', 'r_category = '.$category["c_id"].'', TRUE);

		// Check if there are recipes in this category
		if($recipes)
		{
		 	$text .= $tp->parseTemplate($template['overview']['start'], false, $sc);

			foreach($recipes as $recipe)
			{
				// Pass query values onto the shortcodes
				$sc->setVars($recipe);
				$text .= $tp->parseTemplate($template['overview']['items'], false, $sc);
			}

			$text .= $tp->parseTemplate($template['overview']['end'], false, $sc);
		}
		// No recipes for this category, display info message
		else
		{
			$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPESINCAT."</div>";
		}
	}

	// Let's render and show it all!
	e107::getRender()->tablerender(LAN_CB_CATEGORY_OVERVIEW, $text);
}

// Recipe overview
else
{
	// Retrieve all recipe entries
	$recipes = $sql->retrieve('cookbook_recipes', '*', '', TRUE);

	// Check if there are recipes in this category
	if($recipes)
	{
	 	$text .= $tp->parseTemplate($template['overview']['start'], false, $sc);

		foreach($recipes as $recipe)
		{
			// Pass query values onto the shortcodes
			$sc->setVars($recipe);
			$text .= $tp->parseTemplate($template['overview']['items'], false, $sc);
		}

		$text .= $tp->parseTemplate($template['overview']['end'], false, $sc);
	}
	// No recipes yet
	else
	{
		$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPES."</div>";
	}

	// Let's render and show it all!
	e107::getRender()->tablerender(LAN_CB_RECIPE_OVERVIEW, $text);
}
require_once(FOOTERF);
exit;