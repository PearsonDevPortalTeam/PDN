<?php

/**
 * admin related settings and it's funtions
 */

/**
 * Form builder function for module settings.
 */
function pdn_product_settings_form() {
  $voc = taxonomy_get_vocabularies();
  $v_list = array();
  foreach($voc as $val) {
    $v_list[$val->vid] = $val->name;
  }
  $type = node_type_get_types();
  $n_list = array();
  foreach($type as $val) {
    $n_list[$val->type] = $val->name;
  }
  $fields = field_info_fields();
  $f_list = array();
  foreach($fields as $val) {
    $f_list[$val['field_name']] = $val['field_name'];
  }
  $form['term_related'] = array(
    '#type' => 'fieldset',
    '#title' => t('Taxonomy Setting.'),
    '#weight' => 5,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $menu = menu_get_menus();
  $form['term_related']['product_voc'] = array(
    '#type' => 'select',
    '#title' => t('Product Vocabulary'),
    '#default_value' => variable_get('product_voc', 10),
    '#options' => $v_list,
    '#description' => t('Select the product vocabulary.'),
  );
  $form['term_related']['product_api_voc'] = array(
    '#type' => 'select',
    '#title' => t('Product API Vocabulary'),
    '#default_value' => variable_get('product_api_voc', 6),
    '#options' => $v_list,
    '#description' => t('Select the product API vocabulary'),
  );
  $form['term_related']['term_api_menu'] = array(
    '#type' => 'select',
    '#title' => t('Product Menu'),
    '#default_value' => variable_get('term_api_menu', 'menu-api'),
    '#options' => $menu,
    '#description' => t('Select a menu for side bar content.'),
  );
  $form['content_related'] = array(
    '#type' => 'fieldset',
    '#title' => t('Content Settings.'),
    '#weight' => 6,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['content_related']['product_type'] = array(
    '#type' => 'select',
    '#title' => t('Product Node type'),
    '#default_value' => variable_get('product_type', 'product_overview'),
    '#options' => $n_list,
    '#description' => t('Select the product node type.'),
  );
  $form['content_related']['product_field'] = array(
    '#type' => 'select',
    '#title' => t('Product identifier Field'),
    '#default_value' => variable_get('product_field', 'field_product'),
    '#options' => $f_list,
    '#description' => t('Select product identifier field for contents.'),
  );
  $form['content_related']['product_api_field'] = array(
    '#type' => 'select',
    '#title' => t('Product API field'),
    '#default_value' => variable_get('product_api_field', 'field_plat_prod_type'),
    '#options' => $f_list,
    '#description' => t('Select product API field for contents.'),
  );
  return system_settings_form($form);
}