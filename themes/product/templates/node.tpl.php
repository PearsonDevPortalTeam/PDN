<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <header>
    <?php print render($title_prefix); ?>
    <?php if (!$page && $title): ?>
      <h2<?php print $title_attributes; ?>>
	   <?php if($node->type != "advpoll") { ?>
	  <a href="<?php print $node_url; ?>">
	  <?php print $title; ?></a>
	  <?php } ?>
	  </h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>

    <?php if ($display_submitted): ?>
      <span class="submitted">
        <?php //print $submitted; Commented by govind?> 
      </span>
    <?php endif; ?>
  </header>

  <?php
    // Hide comments, tags, and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
    hide($content['field_tags']);
	//Added by govind for displaying page read count
	$static_Content=$content['links']['statistics'];
	unset($content['links']['statistics']);
	print render($content);
	//Added by govind for displaying page read count
	print render($static_Content);
  ?>

  <?php if (!empty($content['field_tags']) || !empty($content['links'])): ?>
    <footer>
      <?php print render($content['field_tags']); ?>
      <?php print render($content['links']); ?>
    </footer>
  <?php endif; ?>

  <?php print render($content['comments']); ?>

</article> <!-- /.node -->