<?php

/**
 * @file
 * Function to generate likes page.
 */

/**
 * Generate the likes page.
 */
function likebtn_likes_page($entity, $entity_type) {

  $output = '';

  list($entity_id, $entity_revision_id, $bundle) = entity_extract_ids($entity_type, $entity);

  try {
    $query = db_select('votingapi_vote', 'vv')
      ->fields('vv')
      ->condition('vv.entity_type', $entity_type)
      ->condition('vv.entity_id', $entity_id)
      ->condition('vv.value_type', 'points')
      ->condition('vv.uid', 0)
      ->condition('vv.vote_source', '')
      ->orderBy('vv.tag', 'DESC');

    $votingapi_results = $query->execute();
  }
  catch (Exception $e) {

  }

  // Display a table with like counts per button.
  $rows = array();
  // Like and dislike rows has been found.
  $pair_rows_found = FALSE;
  $records_by_tag  = array();
  $fetch_finished  = FALSE;
  $total_likes_minus_dislikes = 0;

  while (1) {
    $record = $votingapi_results->fetchAssoc();

    // Records with likes and dislikes go one after another.
    if (!count($records_by_tag) || $record['tag'] == $records_by_tag[count($records_by_tag) - 1]['tag']) {
      // Do nothing.
    }
    elseif (count($records_by_tag)) {
      $first_record  = $records_by_tag[0];
      $second_record = array('value' => 0);
      if (!empty($records_by_tag[1])) {
        $second_record = $records_by_tag[1];
      }
      if ($first_record['value'] < 0) {
        $likes    = $second_record['value'];
        $dislikes = abs($first_record['value']);
      }
      else {
        $likes    = $first_record['value'];
        $dislikes = abs($second_record['value']);
      }
      $likes_minus_dislikes = $likes - $dislikes;

      $total_likes_minus_dislikes += $likes_minus_dislikes;
      $rows[] = array(
        _likebtn_get_name($first_record['tag']),
        $likes,
        $dislikes,
        $likes_minus_dislikes,
      );

      $records_by_tag = array();
    }
    $records_by_tag[] = $record;

    if (!$record) {
      break;
    }
  }

  $header = array(
    t('Button'),
    t('Likes'),
    t('Dislikes'),
    t('Likes minus dislikes'),
  );
  $output .= theme('table', array('header' => $header, 'rows' => $rows));

  $output .= '<p>' . t('Total likes minus dislikes (vote results):') . ' <strong> ' . $total_likes_minus_dislikes . '</strong></p>';
  $output .= '<p>' . t("If you don't see information on likes:") . '</p>';
  $output .= '<ul>';
  $output .= '<li>' . t('Make sure you have entered information correctly in') . ' <a href="/admin/config/services/likebtn">' . t('Auto-syncing likes into local database (PRO)') . '</a></li>';
  $output .= '<li>' . t('Make sure that PHP curl extension is enabled.') . '</a></li>';
  $output .= '<li>' . t('Maybe nobody voted for this content type yet.') . '</a></li>';
  $output .= '<li>' . t('Perhaps synchronization has not been launched yet.') . '</a></li>';
  $output .= '</ul>';

  return $output;
}

/**
 * Get like button name for the likes page.
 */
function _likebtn_get_name($tag) {
  $name = $tag;

  $tag_parts = explode('_', $tag);

  if ($tag_parts[0] != 'field') {
    $name = t('Like Button');
  }
  else {
    // Get field name.
    if (!empty($tag_parts[1])) {

      $field_info = field_info_field_by_id($tag_parts[1]);

      if (isset($field_info['field_name'])) {
        $name = t('Field') . ': ' . str_replace('field_', '', $field_info['field_name']);
      }

      if ($name && !empty($tag_parts[3])) {
        $name .= ' (' . $tag_parts[3] . ')';
      }
    }
  }

  return $name;
}
