<?php
namespace DB;

/**
 * MANAGE ADMIN PAGES
 */
function manage_admin_pages($email) {

  if(!$email) {
    $email = '@donbranco.fi';
  }

  global $user_ID;

  $user_data = get_userdata( $user_ID );
  $user_email = isset( $user_data->user_email ) ? $user_data->user_email : '';
  
  if ( ! strpos( $user_email, $email ) ) {
    
    remove_menu_page( 'plugins.php' );

    remove_submenu_page( 'themes.php', 'themes.php' );
    remove_submenu_page( 'themes.php', 'customize.php?return=' . urlencode( $_SERVER['REQUEST_URI'] ) );

    // Comment out the following to show widgets if they are in fact used in your project.
    remove_submenu_page( 'themes.php', 'widgets.php' );
    remove_submenu_page( 'index.php', 'update-core.php' );

    // Hide plugins
    remove_menu_page( 'plugins.php' );

    // Hide tools
    remove_menu_page ( 'tools.php' );

    // Hide general options
    remove_menu_page ( 'options-general.php' );

    // Remove ACF page
    remove_menu_page ( 'edit.php?post_type=acf-field-group' );
  }

}
add_action( 'admin_init', __NAMESPACE__.'\\manage_admin_pages' );

function db_custom_logo($logo) {
  ?>
  <style type="text/css">
  body.login div#login h1 a {
  background-image: url($logo);
  height: 45px;
  width: 210px;
  background-size: contain;
  }
  </style>
  <?php
  }

if(get_option('db_custom_logo_url')) {
  add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\db_custom_logo' );
}
/**
 * EDIT ADMIN FOOTER TEXT
 */
function db_admin_edit_footer () {
    echo get_option('db_footer_text') . ' © ' . date('Y');
  }

if(get_option('db_footer_text')) {
  add_filter('admin_footer_text', __NAMESPACE__ . '\\db_admin_edit_footer');
}

/**
 * DISABLE EMOJIS
 */
if(get_option('db_disable_emojis')) {
  add_action( 'init', __NAMESPACE__ . '\\disable_emojis' );
}

/**
 * HIDE WP UPDATE
 */
function wp_hide_update() {
  remove_action('admin_notices', 'update_nag', 3);
  }

if(get_option('db_hide_update')) {
  add_action('admin_menu', __NAMESPACE__ . '\\wp_hide_update');
}

function disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}

/**
* Filter function used to remove the tinymce emoji plugin.
* 
* @param array $plugins 
* @return array Difference betwen the two arrays
*/
function disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
      return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
      return array();
  }
}

/**
* Remove emoji CDN hostname from DNS prefetching hints.
*
* @param array $urls URLs to print for resource hints.
* @param string $relation_type The relation type the URLs are printed for.
* @return array Difference betwen the two arrays.
*/
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
  if ( 'dns-prefetch' == $relation_type ) {
      /** This filter is documented in wp-includes/formatting.php */
      $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

      $urls = array_diff( $urls, array( $emoji_svg_url ) );
  }

  return $urls;
}

/**
 * DISABLE DEFAULT DASHBOARD WIDGETS
 */
if(get_option('db_hide_dashboard_widgets')) {
  add_action('wp_dashboard_setup', __NAMESPACE__ . '\\db_hide_dashboard_widgets', 999);
}
function db_hide_dashboard_widgets() {
    global $wp_meta_boxes;
    // wp..
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    // // bbpress
    // unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
    // // yoast seo
    // unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
    // // gravity forms
    // unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
  }
?>