<?php
  //
  namespace DB;
  
  function register_cpt($name, $singular, $opts) {

    $a = array(
      'name' => $name,
      'singular' => $singular,
      $opts
    );

    $prefix = strtolower($name);
    $reg_function = 'register_cpt_'.$prefix;

    add_action('init', function() use ($a) {

      $opts = $a[0];

      $namespace = $opts['namespace'];

      $labels = array(
        'name'                  => _x( $a['name'], $namespace ),
        'singular_name'         => _x( $a['singular'], $namespace ),
        'menu_name'             => __( $a['name'], $namespace ),
        'name_admin_bar'        => __( $a['name'], $namespace ),
        'archives'              => __( 'Arkisto', $namespace ),
        'attributes'            => __( 'Attribuutit', $namespace ),
        'parent_item_colon'     => __( 'Parent Item', $namespace ),
        'all_items'             => __( 'Kaikki '. (strtolower($a['name'])), $namespace ),
        'add_new_item'          => __( 'Lisää uusi '. (strtolower($a['singular'])), $namespace ),
        'add_new'               => __( 'Lisää uusi '. (strtolower($a['singular'])), $namespace ),
        'new_item'              => __( 'Uusi', $namespace ),
        'edit_item'             => __( 'Muokkaa', $namespace ),
        'update_item'           => __( 'Päivitä', $namespace ),
        'view_item'             => __( 'Näytä', $namespace ),
        'view_items'            => __( 'Näytä', $namespace ),
        'search_items'          => __( 'Etsi', $namespace ),
        'not_found'             => __( 'Ei löytynyt', $namespace ),
        'not_found_in_trash'    => __( 'Ei löytynyt roskakorista', $namespace ),
        'featured_image'        => __( 'Kuva nosto', $namespace ),
        'set_featured_image'    => __( 'Aseta kuva nosto', $namespace ),
        'remove_featured_image' => __( 'Poista kuva nosto', $namespace ),
        'use_featured_image'    => __( 'Käytä kuva nostona', $namespace ),
        'insert_into_item'      => __( 'Lisää', $namespace ),
        'uploaded_to_this_item' => __( 'Lisätty tähän ryhmäon', $namespace ),
        'items_list'            => __( $a['name']. ' lista', $namespace ),
        'items_list_navigation' => __( $a['name']. ' lista navigaatio', $namespace ),
        'filter_items_list'     => __( $a['name']. ' lista filter', $namespace )
      );
  
      $args = array(
        'label'                 => __( $a['name'], $namespace ),
        'description'           => __( $a['name'] .'Info', $namespace ),
        'labels'                => $labels,
        // 'rewrite'               => array( 'slug' => 'tapahtuma' ),
        // 'taxonomies'            => array('team'),
        'supports'              => array('thumbnail', 'title', 'comments'),
        'menu_icon'             => $opts['icon'] ? $opts['icon'] : 'dashicons-text-page',
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => $opts['menu_position'] ? $opts['menu_position'] : 1,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => $opts['publicly_queryable'] ? $opts['publicly_queryable'] : true,
        'query_var'             => strtolower($a['name']),
        // 'capabilities'          => $capabilities,
      );
  
      register_post_type('cpt_'.(strtolower($a['name'])), $args);

    });
}

?>