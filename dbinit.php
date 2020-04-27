<?php
/**
 * Plugin Name: DB Init
 * Version: 1.0.0
 * Plugin URI: https://www.donbranco.fi/
 * Description: Various must use settings for Don & Branco wordpress installations
 * Author: Jere Hirvonen
 * Author URI: https://www.donbranco.fi/
 * Requires at least: 5.0
 * Tested up to: 5.3
 */

// Disallow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DB_Init {

  /**
   * Change if needed based on your current project setup
   */
  var $namespace;

  function __construct() {
    $this->namespace = 'dbinit';

    add_action('plugins_loaded', array($this, 'init_plugin'));
    add_action('admin_init', array($this, 'after_load'));
    add_action('admin_init', array($this, 'init_styles'));
  }

  function init_plugin() {
    /**
     * CPT - Custom post types
     */
    include 'cpt/index.php';

    // Options page
    include 'custom-options.php';
  }

  function after_load() {
    // Must use settings
    include 'settings/index.php';
  }

  function init_styles() {
    // Initialize admin styles
    wp_register_style('admin-css', plugins_url('assets/styles/style.css',__FILE__ ));
    wp_enqueue_style('admin-css');
  }

}

new DB_Init;
