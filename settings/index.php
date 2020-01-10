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

// DB\disable_emojis();