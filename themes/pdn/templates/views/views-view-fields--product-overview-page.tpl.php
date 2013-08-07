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
foreach ($row as $id => $value) {
    if ($id == 'products') {
        $products = $value;
    }
    if ($id == 'functional_area') {
        $functional_area = $value;
    }
    if ($id == 'column_count') {
        $column_count = $value;
    }
}
$class = ($column_count > 1) ? 'class="span12"' : '';
drupal_add_js(libraries_get_path('jquery.quicksearch') . '/jquery.quicksearch.js');
drupal_add_js("jQuery(document).ready(function(){
	  jQuery('input#product-api').quicksearch('.accordion-body a');
  });",'inline');
?>
<div>
<input type="text" class="search-query span4 form-text" id="product-api" placeholder="Filter by API">
</div>
<div class="row">
    <?php
    if (!empty($products)) :
        $product_count = 1;
        ?>
        <div <?php print $class; ?>>
            <div class="accordion" id="accordion_prod">
                <?php foreach ($products as $key => $product): ?>
                    <div class="accordion-group">
                        <div class="accordion-heading accordionheadingbg">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_prod" href="#collapseprod<?php print $product_count; ?>">
                                <?php print $product['name']; ?>
                            </a>
                        </div>
                        <div id="collapseprod<?php print $product_count; ?>" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <span class="productoverview"> 
                                    <?php print implode('</span><span class="productoverview">', $product['terms']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php $product_count++;
                endforeach;
                ?>
            </div>
        </div>
    <?php endif; ?>
    <?php
    if (!empty($functional_area)) :
        $functional_count = 1;
        ?>
        <div <?php print $class; ?>>
            <div class="accordion" id="accordion_func">
    <?php foreach ($functional_area as $key => $functional): ?>
                    <div class="accordion-group">
                        <div class="accordion-heading accordionheadingbg">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_func" href="#collapsefunc<?php print $functional_count; ?>">
        <?php print $functional['name']; ?>
                            </a>
                        </div>
                        <div id="collapsefunc<?php print $functional_count; ?>" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <span class="productoverview"> 
        <?php print implode('</span><span class="productoverview">', $functional['terms']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php $functional_count++;
                endforeach;
                ?>
            </div>
        </div>
<?php endif; ?>
</div>
