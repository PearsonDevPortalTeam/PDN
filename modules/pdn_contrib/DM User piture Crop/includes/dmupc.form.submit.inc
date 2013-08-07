<?php
/**
 * @file
 * Adds module forms submit logic.
 */

/**
 * Avatar form submit handler.
 */
function dmupc_avatar_form_submit($form, &$form_state) {

  switch ($form_state['stage']) {
    case 'crop':
      $form_state['multistep_values'][$form_state['stage']] = $form_state['values'];
      if ($form_state['triggering_element']['#value'] != 'Back') {
        dmupc_avatar_crop_form_submit($form, $form_state);
        $form_state['complete'] = TRUE;
      }
      break;

    default:
      $form_state['multistep_values'][$form_state['stage']] = $form_state['values'];
      $form_state['new_stage'] = dmupc_avatar_form_move_to_next_stage($form, $form_state);
      break;
  }

  if (isset($form_state['complete'])) {
    drupal_goto('dmupc/complete-page');
  }

  if ($form_state['triggering_element']['#value'] == 'Back') {
    $form_state['new_stage'] = dmupc_avatar_form_move_to_previous_stage($form, $form_state);
  }

  if (isset($form_state['multistep_values']['form_build_id'])) {
    $form_state['values']['form_build_id'] = $form_state['multistep_values']['form_build_id'];
  }
  $form_state['multistep_values']['form_build_id'] = $form_state['values']['form_build_id'];
  $form_state['stage'] = $form_state['new_stage'];
  $form_state['rebuild'] = TRUE;
}

/**
 * Crop image.
 */
function _dmupc_crop_image($src, $x, $y, $w, $h, $targ_w, $targ_h, $animated = FALSE) {
  $jpeg_quality = 90;
  $mtype = getimagesize($src);
  $mtype = $mtype['mime'];
  switch ($mtype) {
    case 'image/gif':
      $img_r = imagecreatefromgif($src);
      break;

    case 'image/jpeg':
      $img_r = imagecreatefromjpeg($src);
      break;

    case 'image/png':
      $img_r = imagecreatefrompng($src);
      break;

    default:
      trigger_error('Unsupported filetype!', E_USER_WARNING);
      break;
  }
  $dst_r = imagecreatetruecolor($targ_w, $targ_h);
  if ($mtype == 'image/gif' || $mtype == 'image/png') {
    if ($mtype == 'image/gif' && $animated && function_exists('exec')) {
      exec("convert -version", $out, $rcode);
      if ($rcode == 0) {
        list($width, $height, $type, $attr) = getimagesize($src);
        exec("convert $src -coalesce $src");
        exec("convert -size $width" . "x" . "$height $src -resize  $targ_w" . "x" . "$targ_h $src");
        return;
      }
    }
    $transparency = imagecolortransparent($img_r);
    if ($transparency >= 0) {
      $transparency       = imagecolorallocate($img_r, 0, 0, 0);
      imagefill($dst_r, 0, 0, $transparency);
      imagecolortransparent($dst_r, $transparency);
    }
    elseif ($mtype == 'image/png') {
      imagealphablending($dst_r, FALSE);
      $color = imagecolorallocatealpha($dst_r, 0, 0, 0, 127);
      imagefill($dst_r, 0, 0, $color);
      imagesavealpha($dst_r, TRUE);
    }
  }
  imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);
  switch ($mtype) {
    case 'image/gif':
      imagegif($dst_r, $src);
      break;

    case 'image/jpeg':
      imagejpeg($dst_r, $src, $jpeg_quality);
      break;

    case 'image/png':
      imagepng($dst_r, $src);
      break;

    default:
      trigger_error('Unsupported filetype!', E_USER_WARNING);
      break;
  }
}

/**
 * Avatar crop form submit handler.
 */
function dmupc_avatar_crop_form_submit($form, &$form_state) {
  $account = user_load(arg(1));

  $file = $form_state['multistep_values']['upload']['dmupc_avatar_upload_file_upload'];

  $dimension = variable_get('user_picture_dimensions', '100x100');
  $width_x_height = explode('x', $dimension);

  $x = $form_state['values']['dmupc_x1'];
  $y = $form_state['values']['dmupc_y1'];
  $w = $form_state['values']['dmupc_w'];
  $h = $form_state['values']['dmupc_h'];

  $src = file_stream_wrapper_get_instance_by_uri($file->uri)->realpath();
  _dmupc_crop_image($src, $x, $y, $w, $h, $width_x_height[0], $width_x_height[1], isset($form_state['values']['dmupc_animated']));
  $info = image_get_info($file->uri);
  $picture_directory = file_default_scheme() . '://' . variable_get('user_picture_path', 'pictures');
  $destination = file_stream_wrapper_uri_normalize($picture_directory . '/picture-' . $account->uid . '-' . REQUEST_TIME . '.' . $info['extension']);

  if ($picture = file_move($file, $destination, FILE_EXISTS_REPLACE)) {
    $picture->status = FILE_STATUS_PERMANENT;
    user_save($account, array('picture' => file_save($picture)));
  }
}

/**
 * Goto next step logic.
 */
function dmupc_avatar_form_move_to_next_stage($form, &$form_state) {

  switch ($form_state['stage']) {
    case 'upload':
      return 'crop';

  }

}

/**
 * Goto prev step logic.
 */
function dmupc_avatar_form_move_to_previous_stage($form, &$form_state) {

  switch ($form_state['stage']) {
    case 'crop':
      return 'upload';

  }
}
