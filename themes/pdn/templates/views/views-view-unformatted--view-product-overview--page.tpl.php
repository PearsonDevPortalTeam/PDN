<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
    <h3><?php print $title; ?></h3>
<?php endif; ?>
 <?php if($rows):?>
    <div class="accordion" id="accordion2">
        <?php foreach($rows as $row):
            print $row;
        endforeach;
        ?>
    </div>
    
 <?php endif; ?>
