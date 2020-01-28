<?php
/**
 * Enable various snippets here
 */
include_once 'snippets/index.php';

// Hide unnecessary pages from non admins
if(get_option('db_manage_admin_pages')) {
  if(get_option('db_manage_admin_pages_email')) {
    $email = get_option('db_manage_admin_pages_email');
  } else {
    $email = '';
  }
  DB\manage_admin_pages($email);
}

if(get_option('db_custom_logo_url')) {
  $logo = get_option('db_custom_logo_url');
  DB\db_custom_logo($logo);
}

// DB\custom_logo($url);
// DB\disable_emojis();