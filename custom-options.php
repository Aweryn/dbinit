<?php 
    add_action('admin_menu', 'create_settings_page');

    // Admin scripts & styles
    function create_settings_page() {
      add_submenu_page(
        'options-general.php', 
        'DB Init',
        'DB Init',
        'manage_options',
        'db-init-options',
        'db_init_options'
      );
  }

  function db_init_options() {
    
    if(!current_user_can('administrator')) {
      return false;
    }

    $html = '';

    ob_start(); 

    if(isset($_POST['submit'])) {
      $post_array = $_POST;
      $db_array = array();

      // print_r($_POST);

      if($post_array) {
        foreach($post_array as $key => $pobj) {
          preg_match("/db_/", $key, $matches);
          if($matches) {
            array_push($db_array, $key);
          }
        }
      }

      // Manage admin pages
      if(isset($_POST['db_manage_admin_pages'])) {
        update_option('db_manage_admin_pages', '1');
      } else {
        update_option('db_manage_admin_pages', '0');
      }

      // Hide unnecessary dashboard widgets
      if(isset($_POST['db_hide_dashboard_widgets'])) {
        update_option('db_hide_dashboard_widgets', '1');
      } else {
        update_option('db_hide_dashboard_widgets', '0');
      }

      // Disable emojis
      if(isset($_POST['db_disable_emojis'])) {
        update_option('db_disable_emojis', '1');
      } else {
        update_option('db_disable_emojis', '0');
      }

      // DB Hide update
      if(isset($_POST['db_hide_update'])) {
        update_option('db_hide_update', '1');
      } else {
        update_option('db_hide_update', '0');
      }

      if($db_array) {
        foreach($db_array as $db) {
          update_option($db, $_POST[$db]);
        }
      }

      add_settings_error( 'db_init', 'db_init_updated', __('Settings saved!', 'wpstarter'), 'updated' );
    }
    ?>
      <div class="wrap">
        <div id="db-init">

        <h1><span>Don & Branco WP startkit</span><img src="<?= plugins_url('assets/images/db_at.png',__FILE__ );?>" /></h1>
        <?php settings_errors(); ?>

        <?php
          if( isset( $_GET[ 'tab' ] ) ) {
            $active_tab = $_GET[ 'tab' ];
          } else {
            $active_tab = 'wordpress-snippets';
          }
        ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=db-init-options&tab=wordpress-snippets" class="nav-tab <?php echo $active_tab == 'wordpress-snippets' ? 'nav-tab-active' : ''; ?>">Wordpress snippets</a>
            <a href="?page=db-init-options&tab=sage-snippets" class="nav-tab <?php echo $active_tab == 'sage-snippets' ? 'nav-tab-active' : ''; ?>">Sage snippets</a>
            <a href="?page=db-init-options&tab=woocommerce-snippets" class="nav-tab <?php echo $active_tab == 'woocommerce-snippets' ? 'nav-tab-active' : ''; ?>">Woocommerce snippets</a>
            <a href="?page=db-init-options&tab=about" class="nav-tab <?php echo $active_tab == 'about' ? 'nav-tab-active' : ''; ?>">About</a>
        </h2>

      <?php 
      /**
       * Tab 'Wordpress snippets'
       */
      if($active_tab == 'wordpress-snippets') { ?>
      <div class="tab-content">
        <form id="db-options" method="post" novalidate="novalidate">

          <input type="hidden" name="action" value="update">
          <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?= wp_create_nonce('update-options'); ?>">
          <input type="hidden" name="_wp_http_referer" value="/wp/wp-admin/options-general.php?page=db-init-options&updated=true">

          <table class="form-table" role="presentation">
            <tbody>
              <tr>
                <th scope="row">Hide pages</th>
                <td> 

                  <fieldset>
                    <label for="db_manage_admin_pages">
                      <input name="db_manage_admin_pages" type="checkbox" <?php checked( '1', get_option( 'db_manage_admin_pages' ) ); ?> id="db_manage_admin_pages" value="1">
                      Enabled
                    </label>
                  </fieldset>

                </td>

                <?php if(get_option('db_manage_admin_pages')) { ?>
                <td>
                  <fieldset>
                    <input type="text" name="db_manage_admin_pages_email" id="db_manage_admin_pages_email" value="<?= isset($_POST['db_manage_admin_pages_email']) ? $_POST['db_manage_admin_pages_email'] : get_option('db_manage_admin_pages_email'); ?>" />
                  </fieldset>
                </td>
                  <?php } ?>
              </tr>

              <tr>
                <th scope="row">Hide dashboard widgets</th>
                <td> 

                  <fieldset>
                    <label for="db_hide_dashboard_widgets">
                      <input name="db_hide_dashboard_widgets" type="checkbox" <?php checked( '1', get_option( 'db_hide_dashboard_widgets' ) ); ?> id="db_hide_dashboard_widgets" value="1">
                      Enabled
                    </label>
                  </fieldset>

                </td>
              </tr>

              <tr>
                <th scope="row">Disable emojis</th>
                <td> 

                  <fieldset>
                    <label for="db_disable_emojis">
                      <input name="db_disable_emojis" type="checkbox" <?php checked( '1', get_option( 'db_disable_emojis' ) ); ?> id="db_disable_emojis" value="1">
                      Enabled
                    </label>
                  </fieldset>

                </td>
              </tr>

              <tr>
                <th scope="row">Hide wp update</th>
                <td> 

                  <fieldset>
                    <label for="db_hide_update">
                      <input name="db_hide_update" type="checkbox" <?php checked( '1', get_option( 'db_hide_update' ) ); ?> id="db_hide_update" value="1">
                      Enabled
                    </label>
                  </fieldset>

                </td>
              </tr>

            </tbody>
          </table>

          <h2 class="title">Login logo</h2>
          <p><label for="db_custom_logo_url">Add URL of the logo eg. <i>/app/uploads/2020/01/logo.png</i></label></p>

          <table class="form-table" role="presentation">
            <tbody>
              <tr>
                <th scope="row"><label for="db_custom_logo_url">Logo URL</label></th>
                <td><input name="db_custom_logo_url" type="text" id="db_custom_logo_url" value="<?= isset($_POST['db_custom_logo_url']) ? $_POST['db_custom_logo_url'] : get_option('db_custom_logo_url'); ?>" class="regular-text"></td>
              </tr>
            </tbody>
          </table>

          <h2 class="title">Admin footer text</h2>
          <p><label for="db_footer_text">Change text shown in admin footer</label></p>

          <table class="form-table" role="presentation">
            <tbody>
              <tr>
                <textarea name="db_footer_text" id="db_footer_text" class="large-text code" rows="3"><?= isset($_POST['db_footer_text']) ? $_POST['db_footer_text'] : get_option('db_footer_text'); ?></textarea>
              </tr>
            </tbody>
          </table>

          <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>

        </form>
      </div>
      <?php } ?>

      
      <?php 
      /**
       * Tab 'Sage snippets'
       */
      if($active_tab == 'sage-snippets') { ?>
        <div class="tab-content">
          <div class="tab-content">
            <p>Oh no, no snippets yet :(</p>
          </div>
        </div>
      <?php } ?>

      <?php 
      /**
      * Tab 'Woocommerce snippets'
       */
      if($active_tab == 'woocommerce-snippets') { ?>
        <div class="tab-content">
          <p>Oh no, no snippets yet :(</p>
        </div>
      <?php } ?>

      <?php if($active_tab == 'about') { ?>
        <div class="tab-content">
          <h1>About</h1>
          <p>DB Init plugin is a collection of snippets used across projects in Don & Branco. Feel free to add your own and take a look at the documentation for all this plugin has to offer.</p>
          <a target="_blank" href="https://www.donbranco.fi/">Don & Branco</a> | 
          <a target="_blank" href="https://www.github.com/">GitHub</a> |
          <a target="_blank" href="https://www.roots.io/">Roots.io</a>
        <div class="tab-content">
      <?php } ?>
        </div>
      </div>

      <script>
      (function($) {
        $('input[name="db_manage_admin_pages"]').on('change', function() {
          if($(this).is(':checked')) {
            $('#manage_admin_pages_email').show();
          }

          if(!$(this).is(':checked')) {
            $('#manage_admin_pages_email').hide();
          }
        });
      })(jQuery);
      </script>

      <?php
    $html .= ob_get_clean();

    echo $html;
}
?>