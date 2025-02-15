<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Main template
*/

if (!defined('e107_INIT')) { exit; }

// OVERVIEW GRID
$COOKBOOK_TEMPLATE['overview_grid']['start'] = '
<div class="row">';

$COOKBOOK_TEMPLATE['overview_grid']['items'] = '
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            {SETIMAGE: w=200&h=150&crop=1}
            {COOKBOOK_RECIPE_THUMB}
            <div class="caption text-center">
                <h3>{COOKBOOK_RECIPE_NAME}</h3>
                <p>{COOKBOOK_SUMMARY: max=150}</p>

                <ul class="list-inline text-center">
                    <li>{GLYPH=fa-clock} {COOKBOOK_TIME}</li>
                    <li>{GLYPH=fa-user} {COOKBOOK_AUTHOR}</li>
                </ul>
            </div>
        </div>
    </div>
';

$COOKBOOK_TEMPLATE['overview_grid']['end'] = '
</div>
<div class="row"> 
   {GRID_NEXTPREV}
</div>';   


// OVERVIEW TABLE 
$COOKBOOK_TEMPLATE['overview_datatable']['start'] = '
<div align="left pull-left">
<table class="table table-bordered text-left recipes dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
		<tr>
		  	<th width="40%">{LAN=LAN_CB_RECIPE}</th>
		  	<th>{GLYPH=fa-cutlery}</th>
		  	<th>{GLYPH=fa-users}</th>
	  	 	<th>{GLYPH=fa-clock-o}</th>
	  	 	<th>{GLYPH=fa-toolbox}</th>
            <th>{GLYPH=fa-star}</th>
	  	 	<th>{GLYPH=fa-tags}</th>
		</tr>
	</thead>
    <tbody>
';

$COOKBOOK_TEMPLATE['overview_datatable']['items'] = '
		<tr>
			<td>{COOKBOOK_RECIPE_NAME}</td>
	    	<td>{COOKBOOK_CATEGORY_NAME}</td>
	    	<td>{COOKBOOK_PERSONS}</td>
	    	<td>{COOKBOOK_TIME}</td>
            <td>{COOKBOOK_DIFFICULTY}</td>
	    	<td>{COOKBOOK_AUTHORRATING}</td>
	    	<td>{COOKBOOK_KEYWORDS: limit=5}</td>
    	</tr>
';

$COOKBOOK_TEMPLATE['overview_datatable']['end'] = '
	</tbody>
</table>
</div>
';


// INDVIDUAL RECIPE LAYOUT 
$COOKBOOK_TEMPLATE['recipe_layout'] = '
<div class="row">
	<div class="col-md-12">
		{---RECIPE-CONTENT---}
		{---RECIPE-INFO---}
	</div> <!-- col-md-12 -->
</div> <!-- row -->

<div class="row">
    <div class="col-md-12">
        {SETSTYLE=cookbook_comments}
        {COOKBOOK_COMMENTS}
        {SETSTYLE=default}
    </div>
</div>

<div class="row">
    <div class="col-md-12">  
        {SETSTYLE=cookbook_related}   
        {COOKBOOK_RELATED}
        {SETSTYLE=default}
    </div>
</div>
';

$COOKBOOK_TEMPLATE['recipe_content'] = '
<!-- Start content left  -->
<div class="col-md-8 recipe-box">
    <div class="recipe-box-title">{COOKBOOK_RECIPE_NAME=no_url}</div>
    <div class="recipe-box-content">
        <h3>{LAN=LAN_CB_INGREDIENTS}</h3>
        {SETIMAGE: w=180&h=180}
        <img class="img-thumbnail pull-right hidden-xs" alt="{COOKBOOK_RECIPE_NAME=sef}" src="{COOKBOOK_RECIPE_THUMB=url}">
        {COOKBOOK_INGREDIENTS}
        <div class="recipe-instructions">
            <h3>{LAN=LAN_CB_INSTRUCTIONS}</h3>
            {COOKBOOK_INSTRUCTIONS}
        </div>
    </div>
</div>
<!-- End content left-->
';

$COOKBOOK_WRAPPER['recipe_info']['COOKBOOK_AUTHORRATING: type=stars']   = '<div id="rating">{---}</div>';
$COOKBOOK_WRAPPER['recipe_info']['COOKBOOK_DIFFICULTY: type=stars']     = '<div id="difficulty">{---}</div>';

$COOKBOOK_TEMPLATE['recipe_info'] = '
<!-- Sidebar -->
<div class="col-md-4 recipe-sidebar">
    <h3>{LAN=LAN_CB_RECIPEINFO}</h3>
    <ul class="fa-ul">
        <li>{GLYPH: type=fa-cutlery&class=fa-li} {COOKBOOK_CATEGORY_NAME=no_url}</li>
        <li>{GLYPH: type=fa-users&class=fa-li} {COOKBOOK_PERSONS}</li>
        <li>{GLYPH: type=fa-clock-o&class=fa-li} {COOKBOOK_TIME}</li>
        <li>{GLYPH: type=fa-tags&class=fa-li} {COOKBOOK_KEYWORDS}</li>
        <li>{GLYPH: type=fa-trophy&class=fa-li} {COOKBOOK_AUTHORRATING: type=stars}</li>
        <li>{GLYPH: type=fa-toolbox&class=fa-li} {COOKBOOK_DIFFICULTY: type=stars}</li>
        <li>{GLYPH: type=fa-user&class=fa-li} {COOKBOOK_AUTHOR}</li>
        <li>{GLYPH: type=fa-calendar-alt&class=fa-li} {COOKBOOK_DATE}</li>
    </ul>

    <h3>{LAN=LAN_CB_ACTIONS}</h3>
    <ul class="fa-ul">
        {COOKBOOK_BOOKMARK}
        <li>{GLYPH: type=fa-pencil&class=fa-li} {COOKBOOK_EDIT}</li>
        <li>{GLYPH: type=fa-print&class=fa-li} {COOKBOOK_PRINT}</li>
    </ul>
</div>
<!-- End sidebar -->
';


// KEYWORD OVERVIEW (TAGCLOUD) (div #id should always be 'recipe_tagcloud')
$COOKBOOK_TEMPLATE['keyword_overview'] = '
{COOKBOOK_TAGCLOUD}
<div id="recipe_tagcloud" class="container-fluid" style="min-height: 350px;"></div>
';


$COOKBOOK_WRAPPER['print_recipe_layout'] = $COOKBOOK_WRAPPER['recipe_info']; 

// PRINT TEMPLATE FOR INDIVIDUAL RECIPE
$COOKBOOK_TEMPLATE['print_recipe_layout'] = '
<h1>{COOKBOOK_RECIPE_NAME=no_url}<h1>

<h2>{LAN=LAN_CB_INGREDIENTS}</h2>
<p>{COOKBOOK_INGREDIENTS}</p>
	            
<h2>{LAN=LAN_CB_INSTRUCTIONS}</h2>
{COOKBOOK_INSTRUCTIONS}
	           
<h3>{LAN=LAN_CB_RECIPEINFO}</h3>
<ul class="fa-ul">
	<li>{GLYPH: type=fa-cutlery&class=fa-li} {COOKBOOK_CATEGORY_NAME=no_url}</li>
	<li>{GLYPH: type=fa-users&class=fa-li} {COOKBOOK_PERSONS}</li>
	<li>{GLYPH: type=fa-clock-o&class=fa-li} {COOKBOOK_TIME}</li>
	<li>{GLYPH: type=fa-tags&class=fa-li} {COOKBOOK_KEYWORDS}</li>
    <li>{GLYPH: type=fa-trophy&class=fa-li} {COOKBOOK_AUTHORRATING: type=stars}</li>
    <li>{GLYPH: type=fa-toolbox&class=fa-li} {COOKBOOK_DIFFICULTY: type=stars}</li>
    <li>{GLYPH: type=fa-user&class=fa-li} {COOKBOOK_AUTHOR}</li>
    <li>{GLYPH: type=fa-calendar-alt&class=fa-li} {COOKBOOK_DATE}</li>
</ul>
';

$COOKBOOK_TEMPLATE['related']['caption']    = '{LAN=LAN_CB_RELATEDRECIPES}';
$COOKBOOK_TEMPLATE['related']['start']      = '{SETIMAGE: w=150&h=150&crop=1}<div class="row">';
$COOKBOOK_TEMPLATE['related']['item']       = '<div class="col-md-3 col-sm-6">
                                                 <a href="{RELATED_URL}">{RELATED_IMAGE}</a>
                                                 <h4><a href="{RELATED_URL}">{RELATED_TITLE}</a></h4>
                                                </div>';
$COOKBOOK_TEMPLATE['related']['end']        = '</div>';