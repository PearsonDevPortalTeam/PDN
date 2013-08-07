<?php
/**
 * @file
 * Adds module forms logic.
 */

/**
 * Avatar form.
 */
function dmupc_avatar_form($form, &$form_state) {
  $form = array();
  if (function_exists('admin_menu_suppress')) {
    admin_menu_suppress();
  }
  drupal_add_css(drupal_get_path('module', 'dmupc') . '/css/dmupc.css');
  if (variable_get('user_pictures', '0') == 0) {
    $form['dmupc_avatar_disabled'] = array(
      '#prefix' => '<div class="message error">',
      '#suffix' => '</div>',
      '#markup' => t('Please enable user picture first to use Avatar crop.'),
    );
    return $form;
  }

  if (!isset($form_state['stage'])) {
    $form_state['stage'] = 'upload';
  }

  switch ($form_state['stage']) {
    case 'crop':
      return dmupc_avatar_crop_form($form, $form_state);

    case 'upload':
    default:
      return dmupc_avatar_upload_form($form, $form_state);

  }

  return $form;
}

/**
 * Crop avatar form.
 */
function dmupc_avatar_crop_form($form, &$form_state) {
  $dimension = variable_get('user_picture_dimensions', '100x100');
  $width_x_height = explode('x', $dimension);

  $library_path = libraries_get_path('jquery.jcrop');
  drupal_add_js($library_path . '/js/jquery.Jcrop.min.js');
  drupal_add_css($library_path . '/css/jquery.Jcrop.min.css');

  drupal_add_js(drupal_get_path('module', 'dmupc') . '/js/dmupc.js');

  $file = $form_state['multistep_values']['upload']['dmupc_avatar_upload_file_upload'];
  $info = getimagesize(file_stream_wrapper_get_instance_by_uri($file->uri)->realpath());
  drupal_add_js(array(
    'dmupc' => array(
      'a_width' => $width_x_height[0],
      'a_height' => $width_x_height[1],
      'x' => $info[0],
      'y' => $info[1],
    ),
  ),
  'setting');

  $form['dmupc_avatar_crop_title'] = array(
    '#prefix' => '<h1 class="dmupc-avatar-upload-title">',
    '#suffix' => '</h1>',
    '#markup' => t('Make a selection on the below image to define the crop area.'),
  );

  $form['dmupc_imageview'] = array(
    '#markup' => '<div class="img-container"><img src="' . file_create_url($file->uri) . '?' . date("U") . '"  id="cropbox" alt="" /></div><br />',
  );

  $form['dmupc_x1'] = array(
    '#type' => 'hidden',
  );
  $form['dmupc_y1'] = array(
    '#type' => 'hidden',
  );
  $form['dmupc_x2'] = array(
    '#type' => 'hidden',
  );
  $form['dmupc_y2'] = array(
    '#type' => 'hidden',
  );
  $form['dmupc_h'] = array(
    '#type' => 'hidden',
  );
  $form['dmupc_w'] = array(
    '#type' => 'hidden',
  );
  $form['back'] = array(
    '#type' => 'submit',
    '#value' => t('Back'),
  );
  $form['cropsubmit'] = array(
    '#type' => 'submit',
    '#value' => 'Continue',
  );

  if ($file->filemime == 'image/gif' && _dmupc_is_animated_gif(file_stream_wrapper_get_instance_by_uri($file->uri)->realpath()) != FALSE) {
    $img_info = getimagesize(file_stream_wrapper_get_instance_by_uri($file->uri)->realpath());
    $form['dmupc_avatar_crop_title'] = array(
      '#prefix' => '<h1 class="dmupc-avatar-upload-title">',
      '#suffix' => '</h1>',
      '#markup' => t('Animated GIF resize only.'),
    );

    $form['dmupc_animated'] = array(
      '#type' => 'hidden',
      '#value' => '1',
    );
    $form['dmupc_x1']['#value'] = '0';
    $form['dmupc_y1']['#value'] = '0';
    $form['dmupc_w']['#value'] = $form['dmupc_x2']['#value'] = $img_info[0];
    $form['dmupc_h']['#value'] = $form['dmupc_y2']['#value'] = $img_info[1];
  }
  return $form;
}

/**
 * Avatar upload form.
 */
function dmupc_avatar_upload_form($form, &$form_state) {
  $form['#attributes']['enctype'] = 'multipart/form-data';

  $form['dmupc_avatar_upload_title'] = array(
    '#prefix' => '<h1 class="dmupc-avatar-upload-title">',
    '#suffix' => '</h1>',
    '#markup' => t('Choose profile picture.'),
  );

  $form['dmupc_avatar_upload_file_upload'] = array(
    '#title' => t('Upload file'),
    '#type' => 'file',
  );
  $form['submit_upload'] = array(
    '#type' => 'submit',
    '#value' => 'Upload',
  );

  return $form;
}

/**
 * Animated gif check.
 */
function _dmupc_is_animated_gif($filename) {
  $lsd_offset = 6;
  $gct_offset = 13;
  $chunk_size = 2048;

  $fd = fopen($filename, 'r');
  $buff = fread($fd, $chunk_size);
  fclose($fd);

  $packed = ord($buff[$lsd_offset + 4]);
  $gct_flag = ($packed >> 7) & 1;
  $gct_size = $packed & 7;

  $gct_length = 1 << ($gct_size + 1);
  $data_offset = $gct_offset + ($gct_flag ? 3 * $gct_length : 0);

  while ($data_offset < strlen($buff)) {
    if ((ord($buff[$data_offset]) == 0x21) && (ord($buff[$data_offset + 1]) == 0xf9)) {
      $delay_time = ord($buff[$data_offset + 5]) << 8 | ord($buff[$data_offset + 4]);
      if ($delay_time > 0) {
        return TRUE;
      }
      else {
        return FALSE;
      }
    }
    elseif ((ord($buff[$data_offset]) == 0x21) && (ord($buff[$data_offset + 1]) == 0xff)) {
      $app_name = substr($buff, $data_offset + 3, 8);
      $app_bytes = substr($buff, $data_offset + 11, 3);
      $app_data = array();
      $data_offset += 14;
      do {
        $size = ord($buff[$data_offset]);
        $app_data[] = substr($buff, $data_offset + 1, $size);
        $data_offset += $size + 1;
      } while (ord($buff[$data_offset]) != 0);
      $data_offset += 1;
      if (('NETSCAPE' == $app_name) && ('2.0' == $app_bytes) && (3 == strlen($app_data[0])) && (1 == ord($app_data[0][0]))) {
        return TRUE;
      }
    }
    elseif ((ord($buff[$data_offset]) == 0x21) && (ord($buff[$data_offset + 1]) == 0xfe)) {
      $data_offset += 2;
      do {
        $size = ord($buff[$data_offset]);
        $data_offset += $size + 1;
      } while (ord($buff[$data_offset]) != 0);
      $data_offset += 1;
    }
    elseif (ord($buff[$data_offset]) == 0x2c) {
      return FALSE;
    }
    else {
      die("GIF format error.<br />");
    }
  }
}
