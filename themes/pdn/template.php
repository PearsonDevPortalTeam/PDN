<?php

/*
 * Implements hook_preprocess_html().
 */
function pdn_preprocess_html(&$variables) {
  $header_bg_color         = theme_get_setting('header_bg_color');
  $header_txt_color        = theme_get_setting('header_txt_color');
  $header_hover_bg_color   = theme_get_setting('header_hover_bg_color');
  $header_hover_txt_color  = theme_get_setting('header_hover_txt_color');
  $link_color              = theme_get_setting('link_color');
  $link_hover_color        = theme_get_setting('link_hover_color');
  $footer_bg_color         = theme_get_setting('footer_bg_color');
  $footer_link_color       = theme_get_setting('footer_link_color');
  $footer_link_hover_color = theme_get_setting('footer_link_hover_color');
  $button_background_color = theme_get_setting('button_background_color');
  $button_text_color       = theme_get_setting('button_text_color');

  drupal_add_css(".navbar-inner {background-color: $header_bg_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".navbar .nav > li > a, .menu span.dropdown-toggle, .menu ul.dropdown-menu a {color: $header_txt_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".navbar .nav > li > a:hover, .navbar .nav > li > a.active, .active-trail span.dropdown-toggle.nolink, ul.menu ul.dropdown-menu, ul.menu li.active-trail a {background-color: $header_hover_bg_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css("li.active-trail ul.sf-megamenu li a {background-color: $header_bg_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".navbar .nav .active > a, .navbar .nav .active > a:hover, .navbar.navbar-fixed-top #main-menu li a:hover {background-color: $header_hover_bg_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".dhtmmenu ul.menu li.active-trail a{background-color:#F5F5F5;};", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".navbar .nav > li > a:hover, .menu ul.dropdown-menu a:hover {color: $header_hover_txt_color}", array('group' => CSS_THEME, 'type' => 'inline'));

  drupal_add_css("a {color: $link_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css("a:hover {color: $link_hover_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".footer .footer-inner {background-color: $footer_bg_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".footer .footer-inner .navbar ul.footer-links > li > a {color: $footer_link_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".footer .footer-inner .navbar ul.footer-links > li > a:hover {color: $footer_link_hover_color}", array('group' => CSS_THEME, 'type' => 'inline'));

  drupal_add_css(".btn {background: $button_background_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".btn {color: $button_text_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  
  // Add a inline css for top menu
  drupal_add_css(".sf-menu.sf-style-custom li:hover, .sf-menu.sf-style-custom li.sfHover { background-color: $header_hover_bg_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".sf-menu.sf-style-custom li ul.sf-megamenu  li.sf-megamenu-wrapper{background-attachment: scroll;background-clip: border-box;background-color: $header_bg_color;padding: 0 10px;}.sf-menu.sf-style-custom a:hover,.sf-menu.sf-style-custom li:hover > a > a {color: #ffffff;background-color: $header_hover_bg_color;}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".content  ul.menu li.expanded a{background-color:#F5F5F5}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".openclass  ul.menu li.active-trail  a{background-color:#F5F5F5}", array('group' => CSS_THEME, 'type' => 'inline'));
  //drupal_add_css(".views-field-label,.views-field-message{float:left; padding-right:5px}", array('group' => CSS_THEME, 'type' => 'inline'));
  //drupal_add_css(".views-row-odd,.views-row-even{clear:both}", array('group' => CSS_THEME, 'type' => 'inline'));
  //drupal_add_css("li.sf-no-children:hover{ background-color:#2B3A9E !important ; width:100% }", array('group' => CSS_THEME, 'type' => 'inline'));
  //drupal_add_css("div.sf-megamenu-column ol li:empty:hover{ background-color:#2B3A9E !important;}", array('group' => CSS_THEME, 'type' => 'inline'));
  //drupal_add_css("ul.sf-megamenu{ overflow:hidden; };", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css("li.topic-question a{ color:#137AAA !important};", array('group' => CSS_THEME, 'type' => 'inline'));
}

/**
 * Preprocessor for theme('page').
 */
function pdn_preprocess_page(&$variables) {
  $variables['user_reg_setting'] = variable_get('user_register', USER_REGISTER_VISITORS_ADMINISTRATIVE_APPROVAL);

  if (module_exists('apachesolr')) {
    // todo: $searchTerm is undefined, so this parameter will always be empty
    $search = drupal_get_form('search_form', NULL, (isset($searchTerm) ? $searchTerm : ''));
    $search['basic']['keys']['#size'] = 20;
    $search['basic']['keys']['#title'] = '';
    unset($search['#attributes']);
    //$search['#action'] = base_path() . 'search/site'; // breaks apachesolr searching
    $search_form = drupal_render($search);
    $find = array('type="submit"', 'type="text"');
    $replace = array('type="hidden"', 'type="search" placeholder="search" autocapitalize="off" autocorrect="off"');
    $vars['search_form'] = str_replace($find, $replace, $search_form);
  }

  // Custom Search
  $variables['search'] = FALSE;
  if(theme_get_setting('toggle_search') && module_exists('search')) {
    $variables['search'] = drupal_get_form('search_form');
  }

  # Fix for long user names
  global $user;
  $user_email = $user -> mail;
  if (strlen($user_email) > 22) {
    $tmp = str_split($user_email, 16);
    $user_email = $tmp[0] . '&hellip;';
  }
  $variables['truncated_user_email'] = $user_email;

//statement to assign background image for the sub-container div
	$bg_img =get_background_image();
	$bg_path = '/'.path_to_theme().'/images/bg_images/'.$bg_img;
  drupal_add_css(".sub-container{background-image: url('{$bg_path}') !important;}", array('group' => CSS_THEME, 'type' => 'inline'));

}

function get_background_image(){

	if(arg(0)=='product_overview'){
		$bg_img =  theme_get_setting('api_background_image');
	}
	else if(arg(1)=='1346'){
		$bg_img =  theme_get_setting('product_background_image');
	}
	else{
		$bg_img =  theme_get_setting('home_background_image');
	}
	
return $bg_img;
}

/**
 * Preprocessor for theme('region').
 */
function pdn_preprocess_region(&$variables, $hook) {
  if ($variables['region'] == 'content') {
    $variables['theme_hook_suggestions'][] = 'region__no_wrapper';
  }

  if($variables['region'] == "sidebar_first") {
    $variables['classes_array'][] = 'well';
  }

  if ($variables['region'] == "sidebar_second") {
    $parent_id = 0;
    foreach ($variables['elements']['book_navigation'] as $element) {
      if (is_array($element) && isset($element['#theme'])) {
        $tmp = explode('_', $element['#theme']);
        $parent_id = $tmp[sizeof($tmp) - 1];
      }
    }
    $parent_info = node_load($parent_id);
    $tmp = $variables['content'];
    $tmp = str_replace('<h2>Topics</h2>', '<h3><a href="/' . $parent_info -> book['link_path'] . '">' . $parent_info -> title . '</a></h3><h2>Topics</h2>', $tmp);
    $variables['content'] = $tmp;
  }
}

/**
 * Implements hook_comment_form_alter()
 */
function pdn_form_comment_form_alter(&$form, &$form_state) {
  hide($form['subject']);
  hide($form['author']);
  hide($form['actions']['preview']);
  $form['actions']['submit']['#value'] = 'Add comment';
}

/**
 * Implements hook_css_alter()
 */
function pdn_css_alter(&$css) {
  if (isset($css['misc/ui/jquery.ui.theme.css'])) {
    $css['misc/ui/jquery.ui.theme.css']['data'] = drupal_get_path('theme', 'apigee_devconnect') . '/jquery_ui/jquery-ui-1.9.0.custom.css';
  }

  // Add/Remove apigee_devconnect_wide_layout.css depending on theme setting value (defaults to enabled)
  if (theme_get_setting('wide_layout') == 0) {
    unset($css[drupal_get_path('theme', 'apigee_devconnect') . '/css/apigee_devconnect_wide_layout.css']);
  }
}

/**
 * Preprocessor for theme('menu_link').
 */
function pdn_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    // Add our own wrapper
    unset($element['#below']['#theme_wrappers']);
	if ($element['#original_link']['menu_name'] != ('menu-api' || "menu-api-equella")) //Added By govind
		$sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
	else	
		$sub_menu = '<ul class="dropdown-menu-dhtml">' . drupal_render($element['#below']) . '</ul>';
	$element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
    $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    // Check if this element is nested within another
    if ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] > 1)) {
      // Generate as dropdown submenu
      $element['#attributes']['class'][] = 'dropdown-submenu';
    }
    else {
      // Generate as standard dropdown
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE; 
	  if ($element['#original_link']['menu_name'] != ('menu-api' || "menu-api-equella")) //Added By govind
		$element['#title'] .= '<span class="caret"></span>';
	  else	
		$element['#title'] .= '';
      
    }
  }

  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
* Implements hook_form_FORM_ID_alter()
* @see user_login()
*/

function pdn_form_user_login_alter(&$form, &$form_state, $form_id){
 global $base_url;
  $links = array(
	'register' => t('<a href="' . $base_url . '/user/register"> Request a new account. </a>'),
	'forget' => t('<a href="' . $base_url . '/user/password"> Forget your password? </a>'),
  );

  $form['link_placeholders'] = array(
	'#type' => 'item',
	'#markup' => '<div class="link_placeholders"><ul><li>' . implode('</li><li>', $links) . '</li></ui></div><div style="clear: both;"></div>',
    '#weight' => 88,
  );

}

/**
 * @override views exposed form filter
 * Implements hook_form_alter()
 */

function pdn_form_alter(&$form, $form_state, $form_id){
    // Events page filter form
    if(isset($form_state['view']) && $form_state['view']->name == 'events' 
            && $form_state['view']->current_display == 'eventpage') {
       $form['tid']['#options']['All'] = t('-City');
       $form['tid_1']['#options']['All'] = t('-Country');
    }
}