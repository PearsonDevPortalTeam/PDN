<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php 
 drupal_add_js(drupal_get_path('theme', 'pdn') . '/js/jquery.isotope.js');
 drupal_add_js("jQuery(document).ready(function(){    
	jQuery('.portfolioContainer').isotope({
        filter: '.mostrecent',
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        }
    });
    jQuery('.portfolioFilter a').click(function(){
	    jQuery('.portfolioFilter .current').removeClass('current');
        jQuery(this).addClass('current');
		 jQuery(this).parent().css('background-color','red');
		var selector = jQuery(this).attr('data-filter');
		if(selector=='new'){
			return true;
		}
        jQuery('.portfolioContainer').isotope({
            filter: selector,
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
         });
         //return false;
    }); 
});",'inline');
 // add needed stylesheet
 drupal_add_css(drupal_get_path('theme', 'pdn') .'/css/style-iso.css');
?>

<div class="portfolioFilter pagination">
<div class="item-list" style="float:left">
<ul>
	<li class="pager-item current"><a href="#" data-filter=".mostrecent" class="current">Most Recent</a></li>
	<li class="pager-item"><a href="#" data-filter=".mostviewed">Most Viewed</a></li>
	<li class="pager-item"><a href="#" data-filter=".mostliked">Most Liked</a></li>
	<li class="pager-item"><a href="#" data-filter=".mostdownload">Most Downloaded</a></li>
</ul>
</div>
	<div style="float:left; margin-left:100px">
	<ul>
		<li class="pager-item"><a href="node/add/product-showcase">Showcase Your Apps</a></li>
	</ul>
	</div>
</div>
<div class="portfolioContainer" style="width:800px;min-height:250px">
	<?php 
	if(!empty($mostrecent)){
		foreach($mostrecent as $mostrecentlists){?>
			<div class="isotope-item mostrecent" id="isotope-item">
				<p><a href="<?php print url('node/' .$mostrecentlists->nid); ?>"><?php print $mostrecentlists->title; ?></a></p>
				<img src="<?php echo image_style_url('showcase',$mostrecentlists->filepath);?>" alt="image" width="200px" height="100px" />
			</div>
			<?php
		}
	}
	?>
	<?php 
	if(!empty($mostview)){
	foreach($mostview as $mostviewlists){
	?>
	<div class="isotope-item mostviewed" id="isotope-item">
		<p><a href="<?php print url('node/' .$mostviewlists->nid); ?>"><?php print $mostviewlists->title; ?></a></p>
		<img src="<?php echo image_style_url('showcase',$mostviewlists->filepath);?>" alt="image" width="200px" height="100px" />
	</div><?php
	}
	}
	?>
	
	<?php 
	if(!empty($mostliked)){
		foreach($mostliked as $mostlikedlists){?>
			<div class="isotope-item mostliked" id="isotope-item">
				<p><a href="<?php print url('node/' .$mostlikedlists->nid); ?>"><?php print $mostlikedlists->title; ?></a></p>
				<img src="<?php echo image_style_url('showcase',$mostlikedlists->filepath);?>" alt="image" width="200px" height="100px" />
			</div>
			<?php
		}
	}
	?>
	
	<?php 
	if(!empty($mostdownload)){
	foreach($mostdownload as $mostdownloadlists){ ?>
	<div class="isotope-item mostdownload" id="isotope-item">
		<p><a href="<?php print url('node/' .$mostdownloadlists->nid); ?>"><?php print $mostdownloadlists->title; ?></a></p>
		<img src="<?php echo image_style_url('showcase',$mostdownloadlists->filepath);?>" alt="image" width="200px" height="100px" />
	</div><?php
	}
	}
	?>
	
</div>
