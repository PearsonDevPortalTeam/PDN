<?php
global $user, $base_url;
$current_path = implode("/", arg());
?>
<header id="navbar" role="banner" class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <?php if ($logo): ?>
        <a class="brand" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
        </a>
      <?php endif; ?>
      <div class="nav-collapse">
        <nav role="navigation">
          <?php if ($main_menu): ?>
            <?php print render($page['menu']); ?>
          <?php endif; ?>
          <div id='login-buttons' class="span7 pull-right">
            <ul class="nav pull-right">
              <?php if ($user->uid == 0) { ?>
                <!-- show/hide login and register links depending on site registration settings -->
                <?php if (($user_reg_setting != 0) || ($user->uid == 1)): ?>
                  <li class="<?php echo (($current_path == "user/register") ? "active" : ""); ?>"><?php echo l(t("register"), "user/register"); ?></li>
                  <li class="<?php echo (($current_path == "user/login") ? "active" : ""); ?>"><?php echo l(t("login"), "user/login"); ?></li>
                <?php endif; ?>
                <?php
              } else {
                $user_url = "user/" . $user->uid;
                ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php print $user->mail; ?>"><?php print $truncated_user_email; ?><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                      <li><i class="icon-dashboard"></i><?php echo l('Dashboard', $base_url . '/dashboard'); ?></li>
                    <?php if (module_exists('devconnect_developer_apps')): ?>
                      <li><i class="icon-pencil"></i><?php echo l('My Apps', $user_url . '/apps'); ?></li>
                    <?php endif; ?>
                    <li><i class="icon-user"></i><?php echo l('View Profile', $user_url); ?></li>
                    <li><i class="icon-off"></i><?php echo l(t("Logout"), "user/logout"); ?></li>
                  </ul>
                </li>
                <li><?php echo l(t("logout"), "user/logout"); ?></li>
              <?php } ?>
            </ul>
          </div>
        </nav>
      </div>

    </div>
  </div>
</header>
<div class="master-container">
  <!-- Header -->
  <header role="banner" id="page-header">
    <?php print render($page['header']); ?>
  </header>
  <!-- Breadcrumbs -->
  <div id="breadcrumb-navbar">
    <div class="container">
      <div class="row">
        <div class="span19">
          <?php
          if ($breadcrumb): print $breadcrumb;
          endif;
          ?>
        </div>
        <div class="span5 pull-right">
          <?php if ($search): ?>
            <?php
            if ($search): print render($search);
            endif;
            ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- Title -->
  <?php if (drupal_is_front_page()): ?>
    <section class="page-header">
      <div class="container">
        <div class="row">
          <div class="span9">
            <div class="title">
              <?php if (theme_get_setting('welcome_message')): ?>
                <h1><?php print theme_get_setting('welcome_message'); ?></h1>
              <?php else: ?>
                <h1><span class="welcome">Welcome</span><br />to the&nbsp;<span><?php print $site_name ?></h1></span>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="page-header-content">
          <?php print render($page['homepage_header']); ?>
        </div>
      </div>
    </section>
  <?php else: ?>
    <section class="page-header">
      <div class="container">
        <div class="row">
          <span class="<?php print _apigee_base_content_span($columns); ?>">
            <!-- Title Prefix -->
            <?php print render($title_prefix); ?>
            <!-- Title -->
            <h1><?php print render($title); ?></h1>
            <!-- SubTitle -->
            <h2 class="subtitle"><?php print render($subtitle); ?></h2>              <!-- Title Suffix -->
            <?php print render($title_suffix); ?>
          </span>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <?php if ($page['preface_first'] || $page['preface_middle'] || $page['preface_last']) : ?>
    <section class="preface-content">
      <div class="container">
        <div class="row">
          <div id="preface-wrapper" class="in<?php print (bool) $page['preface_first'] + (bool) $page['preface_middle'] + (bool) $page['preface_last']; ?> clearfix span24">
            <?php if ($page['preface_first']) : ?>
              <div class="column A">
                <?php print render($page['preface_first']); ?>
              </div>
            <?php endif; ?>
            <?php if ($page['preface_middle']) : ?>
              <div class="column B">
                <?php print render($page['preface_middle']); ?>
              </div>
            <?php endif; ?>
            <?php if ($page['preface_last']) : ?>
              <div class="column C">
                <?php print render($page['preface_last']); ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <?php if (drupal_is_front_page()): ?>
    <?php if ($page['homecontent_first'] || $page['homecontent_last']) : ?>
      <section class="homepage-content">
        <div class="container">
          <div class="row">
            <div id="homecontent-wrapper" class="in<?php print (bool) $page['homecontent_first'] + (bool) $page['homecontent_last']; ?> clearfix span24">
              <?php if ($page['homecontent_first']) : ?>
                <div class="column A">
                  <?php print render($page['homecontent_first']); ?>
                </div>
              <?php endif; ?>
              <?php if ($page['homecontent_last']) : ?>
                <div class="column B">
                  <?php print render($page['homecontent_last']); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>
  <?php else: ?>
  <div class="page-content">
    <div class="container">
      <?php print $messages; ?>
      <?php if ($page['help']): ?>
        <div class="well"><?php print render($page['help']); ?></div>
      <?php endif; ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <div class="row">
        <!-- Sidebar First (Left Sidebar)  -->
        <?php if ($page['sidebar_first']): ?>
          <aside class="span6 pull-left" role="complementary">
            <?php print render($page['sidebar_first']); ?>
          </aside>
        <?php endif; ?>
        <!-- Main Body  -->
        <section class="<?php print _apigee_base_content_span($columns); ?>">
          <?php if ($page['highlighted']): ?>
            <div class="highlighted hero-unit"><?php print render($page['highlighted']); ?></div>
          <?php endif; ?>
          <?php if (($tabs) && (!$is_front)): ?>
            <?php print render($tabs); ?>
          <?php endif; ?>
          <a id="main-content"></a>
          <?php print render($page['content']); ?>
		  <!-- For get satisfaction module -->
		  <div id="getsat-widget-6268">
		  </div>
		  <?php 
		  if (url($_GET['q']) == "/community"): ?>
			<a href="https://getsatisfaction.com/pdn/topics.rss?sort=created_at" target="_blank"><img src="http://pdn.com/sites/all/themes/pdn/images/rss.png" /><span style="vertical-align:-2px; margin-left:3px">RSS</span></a>		
			<?php endif; ?>
		  <!-- For get satisfaction module -->
        </section>
        <!-- Sidebar Second (Right Sidebar)  -->
        <?php if ($page['sidebar_second']): ?>
          <aside class="span6 pull-right" role="complementary">
            <?php print render($page['sidebar_second']); ?>
          </aside>  <!-- /#sidebar-second -->
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
  <?php if ($page['bottom_first'] || $page['bottom_middle'] || $page['bottom_last']) : ?>
    <section class="bottom-content">
      <div class="container">
        <div class="row">
          <div id="bottom-wrapper" class="in<?php print (bool) $page['bottom_first'] + (bool) $page['bottom_middle'] + (bool) $page['bottom_last']; ?> clearfix span24">
            <?php if ($page['bottom_first']) : ?>
              <div class="column A">
                <?php print render($page['bottom_first']); ?>
                 <div style="">
                     <a href="<?php print $base_url ."/blog";?>" title="more" class="readmore blog-more">more</a>
                 </div>
              </div>
            <?php endif; ?>
            <?php if ($page['bottom_middle']) : ?>
              <div class="column B">
                <?php print render($page['bottom_middle']); ?>
              </div>
            <?php endif; ?>
            <?php if ($page['bottom_last']) : ?>
              <div class="column C">
                <?php print render($page['bottom_last']); ?>
                 <div style="">
                     <a href="<?php print $base_url ."/events";?>" title="more" class="readmore">more</a>
                 </div>
              </div>
              
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>
</div>
<!-- Footer  -->
<footer class="footer">
  <?php if ($page['footer_first'] || $page['footer_middle'] || $page['footer_last']) : ?>
    <section class="footer-content">
      <div class="container">
        <div class="row">
          <div id="footer-wrapper" class="in<?php print (bool) $page['footer_first'] + (bool) $page['footer_middle'] + (bool) $page['footer_last']; ?> clearfix">
            <?php if ($page['footer_first']) : ?>
              <div class="column A">
                <?php print render($page['footer_first']); ?>
              </div>
            <?php endif; ?>
            <?php if ($page['footer_middle']) : ?>
              <div class="column B">
                <?php print render($page['footer_middle']); ?>
              </div>
            <?php endif; ?>
            <?php if ($page['footer_last']) : ?>
              <div class="column C">
                <?php print render($page['footer_last']); ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <div class="footer-inner">
    <div class="container">
      <?php print render($page['footer']); ?>
    </div>
  </div>
</footer>
