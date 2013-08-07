<?php
/**
 * @file
 * Adds module forms validate logic.
 */

/**
 * Avatar form validate handler.
 */
function dmupc_avatar_form_validate($form, &$form_state) {

  if ($form_state['triggering_element']['#value'] == 'Back') {
    return;
  }

  switch ($form_state['stage']) {
    case 'crop':
      return dmupc_avatar_crop_form_validate($form, $form_state);

    case 'upload':
      return dmupc_avatar_upload_form_validate($form, $form_state);

  }
}

/**
 * Avatar crop form validate handler.
 */
function dmupc_avatar_crop_form_validate($form, &$form_state) {
  if (!isset($form_state['values']['dmupc_x1']) || !isset($form_state['values']['dmupc_y1']) ||
  !isset($form_state['values']['dmupc_x2']) || !isset($form_state['values']['dmupc_y2']) ||
  !isset($form_state['values']['dmupc_w']) || !isset($form_state['values']['dmupc_h'])) {
    form_set_error('', t('Please crop the image to continue.'));
  }
}

/**
 * Avatar upload form validate handler.
 */
function dmupc_avatar_upload_form_validate($form, &$form_state) {
  $account = user_load(arg(1));

  $validators = array(
    'file_validate_is_image' => array(),
    'file_validate_size' => array(variable_get('dmupc_image_file_size', '500') * 1024),
    'file_validate_extensions' => array('png jpg gif'),
  );

  $file = file_save_upload('dmupc_avatar_upload_file_upload', $validators);

  if ($file === FALSE) {
    form_set_error('dmupc_avatar_upload_file_upload', t("Failed to upload the picture image; the %directory directory doesn't exist or is not writable.", array('%directory' => variable_get('user_picture_path', 'pictures'))));
  }
  elseif ($file !== NULL) {
    $info = image_get_info($file->uri);
    $picture_directory = file_default_scheme() . '://' . variable_get('user_picture_path', 'pictures');

    file_prepare_directory($picture_directory, FILE_CREATE_DIRECTORY);
    $destination = file_stream_wrapper_uri_normalize($picture_directory . '/picture-' . $account->uid . '.' . $info['extension']);

    if ($picture = file_move($file, $destination, FILE_EXISTS_REPLACE)) {
      $form_state['values']['dmupc_avatar_upload_file_upload'] = $picture;
      $dimension = variable_get('dmupc_image_size', '550x550');
      $width_x_height = explode('x', $dimension);
      $img_info = getimagesize($destination);
      if ($img_info[0] > $width_x_height[0] || $img_info[1] > $width_x_height[1]) {
        $factor = min($width_x_height[0] / $img_info[0], $width_x_height[1] / $img_info[1]);

        $final_width  = round($img_info[0] * $factor);
        $final_height = round($img_info[1] * $factor);

        $src = file_stream_wrapper_get_instance_by_uri($picture->uri)->realpath();
        _dmupc_crop_image($src, 0, 0, $img_info[0], $img_info[1], $final_width, $final_height, $img_info['mime'] == 'image/gif' ? _dmupc_is_animated_gif($src) : FALSE);
      }
    }
    else {
      form_set_error('dmupc_avatar_upload_file_upload', t('Cannot upload file!'));
    }
  }
  else {
    form_set_error('dmupc_avatar_upload_file_upload', t('Cannot upload file!'));
  }
}
