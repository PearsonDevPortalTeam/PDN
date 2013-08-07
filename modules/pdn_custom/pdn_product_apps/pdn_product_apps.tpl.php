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
drupal_add_js("var product='';var lan='';",'inline');
 if($default != 'all'){
	// drupal_add_js("product='.".$default."'; ",'inline');
	// drupal_add_js("jQuery(document).ready(function(){
		// jQuery('#productvalue').html(('product  <a href=\'#\' id=\'lclose\'>x</a>'));
		// jQuery('.portfolioContainer').isotope({
			// filter: product,
			// animationOptions: {
			// duration: 750,
			// easing: 'linear',
			// queue: false
		// }
    // });return false; });",'inline');
}
 drupal_add_js("jQuery(document).ready(function(){
	jQuery('.product').hover(function(){
		jQuery('.product').removeClass('hide');
	});
	jQuery('.language').hover(function(){
		jQuery('.language').removeClass('hide');
	});
	jQuery('.product a').click(function(){
	    jQuery('.product .current').removeClass('current');
		var selector = jQuery(this).attr('data-filter');
		jQuery('#productvalue').html((jQuery(this).text()+'  <a href=\'#\' id=\'pclose\'>x</a>'));
		jQuery('#language').html('');
		product=selector;
		jQuery('.product').addClass('hide');
		jQuery('.portfolioContainer').isotope({
            filter: selector,
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
         });
		 return false;
    }); 
	jQuery('.language a').click(function(){
		jQuery('.language .current').removeClass('current');
		var selector = jQuery(this).attr('data-filter');
		lan=selector;
		jQuery('#language').html((jQuery(this).text()+'  <a href=\'#\' id=\'lclose\'>x</a>'));
		if(product != 'undefined' && product != ''){
			var appfilter=product+selector;
		} else	{
			var appfilter=selector;
		}
		jQuery('.language').addClass('hide');
		jQuery('.portfolioContainer').isotope({
            filter: appfilter,
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
         });
        return false;
    });
	jQuery('#lclose').live('click', function() {
		if(product != 'undefined' && product != ''){
		} else	{
			product='.isotope-item';
		}
		jQuery('.portfolioContainer').isotope({
            filter: product,
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
         });
		 jQuery('#language').html('');
		 return false;
	});
	jQuery('#pclose').live('click', function() {
		jQuery('.portfolioContainer').isotope({
            filter: '.isotope-item',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
         });
		 product='.isotope-item';
		 jQuery('#language').html('');
		 jQuery('#productvalue').html('');
		 return false;
	});

});",'inline');
 // add needed stylesheet
 drupal_add_css(drupal_get_path('theme', 'pdn') .'/css/style-iso.css');
?>
<div>
	<p>You could be a developer for the Mobile, Desktop or Tablet, we at Pearson Developer Network has library wrappers and tools that can simplify development.</p>
	<p>Please select a product/language of your choice from the dropdown menu. Once you've made your selection, the list of Sample Apps will display with the ability to view and download the Sample App code.	</p>
</div>
<div>
<ul id="nav-pro">
    <li>
        <a href="#">Product</a>
		<ul class="product">
		<?php 
		if(!empty($products)){
			foreach($products as $key=>$val){ 
			?>
			<li class="pager-item app"><a href="#" data-filter=".<?php print "p_".$key; ?>"><?php print $val; ?></a></li>
		<?php 
			}
		}
		?>
		</ul>
    </li>

    <li>
        <a href="#">Language</a>
		<ul class="language">
			<?php 
			if(!empty($language)){
				foreach($language as $key=>$val){ 
				?>
				<li class="pager-item app"><a href="#" data-filter=".<?php print "l_".$key; ?>"><?php print $val; ?></a></li>
			<?php 
				}
			} 
			?>
		</ul>
    </li>
</ul>

</div>

<div class="optionholder">	
<span class="option" id="productvalue"></span><span class="option" id="language"></span>
</div>
<?php if(!empty($apps)){ ?>
<p style="margin-top:35px;clear:both">Sample Applications</p>
<?php } ?>
<div class="portfolioContainer" style="width:800px;min-height:250px;">
	<?php 
	if(!empty($apps)){
		foreach($apps as $appsResult){ ?>
			<div class="isotope-item <?php print "p_".$appsResult->field_app_product_tid." l_".$appsResult->field_language_tid; ?>" id="isotope-app">
				<p><?php print $appsResult->field_app_name_value; ?></p>
				<a href="<?php print url($appsResult->field_app_view_link_url); ?>" target="_blank"><?php echo t("View"); ?></a> | 
				<a href="<?php print url($appsResult->field_app_download_link_url); ?>" target="_blank"><?php echo t("Download"); ?></a>
			</div>
			<?php
		}
	}else{ ?>
		<p>No Apps uploaded</p>
	<?php }
	?>
	
	
</div>
