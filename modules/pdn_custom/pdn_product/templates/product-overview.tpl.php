<?php
/* 
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

$products = $product->products;
$functional_area = $product->functional_area;
$column_count = $product->column_count;

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
