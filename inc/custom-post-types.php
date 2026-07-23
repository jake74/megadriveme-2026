<?php
// Register Custom Post Types

// register megadrive post type

add_action( 'init', 'register_cpt_megadrive' );

function register_cpt_megadrive() {

    $labels = array( 
        'name' => _x( 'Games', 'mega-drive' ),
        'singular_name' => _x( 'Mega Drive Game', 'mega-drive' ),
        'add_new' => _x( 'Add New Game', 'mega-drive' ),
        'add_new_item' => _x( 'Add New Mega Drive Game', 'mega-drive' ),
        'edit_item' => _x( 'Edit Game', 'mega-drive' ),
        'new_item' => _x( 'New Game', 'mega-drive' ),
        'view_item' => _x( 'View Game', 'mega-drive' ),
        'search_items' => _x( 'Search Games', 'mega-drive' ),
        'not_found' => _x( 'No games found', 'mega-drive' ),
        'not_found_in_trash' => _x( 'No games found in Trash', 'mega-drive' ),
        'parent_item_colon' => _x( 'Letter:', 'mega-drive' ),
        'menu_name' => _x( 'Mega Drive', 'mega-drive' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Mega Drive games',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'comments', 'revisions' ),
        'taxonomies' => array( 'category', 'post_tag', 'page-category', 'Optional' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon'   => 'dashicons-games',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'mega-drive', $args );
}

// register mega CD post type

add_action( 'init', 'register_cpt_megacd' );

function register_cpt_megacd() {

    $labels = array( 
        'name' => _x( 'Games', 'mega-cd' ),
        'singular_name' => _x( 'Mega CD Game', 'mega-cd' ),
        'add_new' => _x( 'Add New Game', 'mega-cd' ),
        'add_new_item' => _x( 'Add New Mega CD Game', 'mega-cd' ),
        'edit_item' => _x( 'Edit Game', 'mega-cd' ),
        'new_item' => _x( 'New Game', 'mega-cd' ),
        'view_item' => _x( 'View Game', 'mega-cd' ),
        'search_items' => _x( 'Search Games', 'mega-cd' ),
        'not_found' => _x( 'No games found', 'mega-cd' ),
        'not_found_in_trash' => _x( 'No games found in Trash', 'mega-cd' ),
        'parent_item_colon' => _x( 'Letter:', 'mega-cd' ),
        'menu_name' => _x( 'Mega CD', 'mega-cd' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Mega CD games',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'comments', 'revisions' ),
        'taxonomies' => array( 'category', 'post_tag', 'page-category', 'Optional' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 6,
        'menu_icon'   => 'dashicons-games',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'mega-cd', $args );
}

// register 32x post type

add_action( 'init', 'register_cpt_32x' );

function register_cpt_32x() {

    $labels = array( 
        'name' => _x( 'Games', '32x' ),
        'singular_name' => _x( '32X Game', '32x' ),
        'add_new' => _x( 'Add New Game', '32x' ),
        'add_new_item' => _x( 'Add New 32X Game', '32x' ),
        'edit_item' => _x( 'Edit Game', '32x' ),
        'new_item' => _x( 'New Game', '32x' ),
        'view_item' => _x( 'View Game', '32x' ),
        'search_items' => _x( 'Search Games', '32x' ),
        'not_found' => _x( 'No games found', '32x' ),
        'not_found_in_trash' => _x( 'No games found in Trash', '32x' ),
        'parent_item_colon' => _x( 'Letter:', '32x' ),
        'menu_name' => _x( '32X', '32x' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => '32X games',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'comments', 'revisions' ),
        'taxonomies' => array( 'category', 'post_tag', 'page-category', 'Optional' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 7,
        'menu_icon'   => 'dashicons-games',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( '32x', $args );
}

// register 32x post type

add_action( 'init', 'register_cpt_hardware' );

function register_cpt_hardware() {

    $labels = array( 
        'name' => _x( 'Hardware', 'hardware' ),
        'singular_name' => _x( 'Item', 'hardware' ),
        'add_new' => _x( 'Add New Hardware', 'hardware' ),
        'add_new_item' => _x( 'Add Hardware', 'hardware' ),
        'edit_item' => _x( 'Edit Hardware', 'hardware' ),
        'new_item' => _x( 'New Hardware', 'hardware' ),
        'view_item' => _x( 'View Hardware', 'hardware' ),
        'search_items' => _x( 'Search Hardware', 'hardware' ),
        'not_found' => _x( 'No hardware found', 'hardware' ),
        'not_found_in_trash' => _x( 'No hardware found in Trash', 'hardware' ),
        'parent_item_colon' => _x( 'Letter:', 'hardware' ),
        'menu_name' => _x( 'Hardware', 'hardware' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Hardware',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'comments', 'revisions' ),
        'taxonomies' => array( 'category', 'post_tag', 'page-category', 'Optional' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 8,
        'menu_icon'   => 'dashicons-desktop',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'hardware', $args );
}