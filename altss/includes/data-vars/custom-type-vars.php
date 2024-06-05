<?php
$CUSTOM_TYPES = [
    'news' => [
        'label'             => esc_html__( 'News' , "altss" ),
		'labels'            => array(
                'name'              => esc_html__( 'News' , "altss" ),
                'singular_name'     => esc_html__( 'news' , "altss" ),
                'menu_name'         => esc_html__( 'News' , "altss" ),
                'all_items'         => esc_html__( 'All news' , "altss" ),
                'add_new'           => esc_html__( 'Add news' , "altss" ),
                'add_new_item'      => esc_html__( 'Add news' , "altss" ),
                'edit'              => esc_html__( 'Edit' , "altss" ),
                'edit_item'         => esc_html__( 'Edit news' , "altss" ),
                'new_item'          => esc_html__( 'New news' , "altss" ),
		    ),
		'description'       => '',
		'has_archive'       => 'news',
		'taxonomies'        => array( 'news_cat' ),
		'menu_icon'         => 'dashicons-feedback',
		'menu_position'         => 4,
		'cat_slug'          => 'news_cat', 
		'cat_label'         => esc_html__( 'News categories' , "altss" ), 
		'cat_labels'        => array(
                'name'              => esc_html__( 'News categories' , "altss" ),
                'singular_name'     => esc_html__( 'News category' , "altss" ),
                'search_items'      => esc_html__( 'Search News Category' , "altss" ),
                'all_items'         => esc_html__( 'All News Categories' , "altss" ),
                'parent_item'       => esc_html__( 'Parent news category' , "altss" ),
                'parent_item_colon' => esc_html__( 'Parent news category' , "altss" ) . ':',
                'edit_item'         => esc_html__( 'Edit news category' , "altss" ),
                'update_item'       => esc_html__( 'Update news category' , "altss" ),
                'add_new_item'      => esc_html__( 'Add news category' , "altss" ),
                'new_item_name'     => esc_html__( 'New news category' , "altss" ),
                'menu_name'         => esc_html__( 'News categories' , "altss" ),
            ),
		'cat_description'    => esc_html__( 'Categories for news' , "altss" ), 
		'tag_slug'           => 'news_tag', 
		'rewrite_slug'       => 'news', 
    ],


    'promotions' => [
        'label'             => esc_html__( 'Promotions' , "altss" ),
		'labels'            => array(
                'name'              => esc_html__( 'Promotions' , "altss" ),
                'singular_name'     => esc_html__( 'Promotion' , "altss" ),
                'menu_name'         => esc_html__( 'Promotions' , "altss" ),
                'all_items'         => esc_html__( 'All promotions' , "altss" ),
                'add_new'           => esc_html__( 'Add promotion' , "altss" ),
                'add_new_item'      => esc_html__( 'Add promotion' , "altss" ),
                'edit'              => esc_html__( 'Edit' , "altss" ),
                'edit_item'         => esc_html__( 'Edit promotion' , "altss" ),
                'new_item'          => esc_html__( 'New promotion' , "altss" ),
		    ),
		'description'       => '',
		'has_archive'       => 'promotions',
		'taxonomies'        => array( 'promotions_cat' ),
		'menu_icon'         => 'dashicons-megaphone',
		'menu_position'         => 5,
		'cat_slug'          => 'promotions_cat', 
		'cat_label'         => esc_html__( 'Promotion categories' , "altss" ), 
		'cat_labels'        => array(
                'name'              => esc_html__( 'Promotion categories' , "altss" ),
                'singular_name'     => esc_html__( 'Promotion category' , "altss" ),
                'search_items'      => esc_html__( 'Search Promotion Category' , "altss" ),
                'all_items'         => esc_html__( 'All promotion categories' , "altss" ),
                'parent_item'       => esc_html__( 'Parent promotion category' , "altss" ),
                'parent_item_colon' => esc_html__( 'Parent promotion category' , "altss" ) . ':',
                'edit_item'         => esc_html__( 'Edit promotion category' , "altss" ),
                'update_item'       => esc_html__( 'Update promotion category' , "altss" ),
                'add_new_item'      => esc_html__( 'Add promotion category' , "altss" ),
                'new_item_name'     => esc_html__( 'New promotion category' , "altss" ),
                'menu_name'         => esc_html__( 'Promotion categories' , "altss" ),
            ),
		'cat_description'    => esc_html__( 'Categories for promotions' , "altss" ), 
		'tag_slug'           => 'promotions_tag', 
		'rewrite_slug'       => 'promotions', 
    ],

    'books' => [
        'label'             =>  esc_html__( 'Books' , "altss" ),
		'labels'            => array(
                'name'              => esc_html__( 'Books' , "altss" ),
                'singular_name'     => esc_html__( 'Book' , "altss" ),
                'menu_name'         => esc_html__( 'Books' , "altss" ),
                'all_items'         => esc_html__( 'All books' , "altss" ),
                'add_new'           => esc_html__( 'Add book' , "altss" ),
                'add_new_item'      => esc_html__( 'Add new book' , "altss" ),
                'edit'              => esc_html__( 'Edit' , "altss" ),
                'edit_item'         => esc_html__( 'Edit book' , "altss" ),
                'new_item'          => esc_html__( 'New book' , "altss" ),
		    ),
		'description'       => '',
		'has_archive'       => 'books',
		'taxonomies'        => array( 'books_cat' ),
		'menu_icon'         => 'dashicons-book',
		'menu_position'     => 6,
		'cat_slug'          => 'books_cat', 
		'cat_label'         => esc_html__( 'Books categories' , "altss" ), 
		'cat_labels'        => array(
                'name'              => esc_html__( 'Books categories' , "altss" ),
                'singular_name'     => esc_html__( 'Books category' , "altss" ),
                'search_items'      => esc_html__( 'Search books category' , "altss" ),
                'all_items'         => esc_html__( 'All books categories' , "altss" ),
                'parent_item'       => esc_html__( 'Parent books category' , "altss" ),
                'parent_item_colon' => esc_html__( 'Parent books category:' , "altss" ),
                'edit_item'         => esc_html__( 'Edit books category' , "altss" ),
                'update_item'       => esc_html__( 'Update books category' , "altss" ),
                'add_new_item'      => esc_html__( 'Add books category' , "altss" ),
                'new_item_name'     => esc_html__( 'New books category' , "altss" ),
                'menu_name'         => esc_html__( 'Books categories' , "altss" ),
            ),
		'cat_description'    => esc_html__( 'Categories for books' , "altss" ), 
		'tag_slug'           => 'books_tag', 
		'rewrite_slug'       => 'books', 
    ],

    'docs' => [
        'label'             => esc_html__( 'Documents' , "altss" ),
		'labels'            => array(
                'name'              => esc_html__( 'Documents' , "altss" ),
                'singular_name'     => esc_html__( 'Document' , "altss" ),
                'menu_name'         => esc_html__( 'Documents' , "altss" ),
                'all_items'         => esc_html__( 'All documents' , "altss" ),
                'add_new'           => esc_html__( 'Add document' , "altss" ),
                'add_new_item'      => esc_html__( 'Add new document' , "altss" ),
                'edit'              => esc_html__( 'Edit' , "altss" ),
                'edit_item'         => esc_html__( 'Edit document' , "altss" ),
                'new_item'          => esc_html__( 'New document' , "altss" ),
		    ),
		'description'       => '',
		'has_archive'       => 'docs',
		'taxonomies'        => array( 'docs_cat' ),
		'menu_icon'         => 'dashicons-book-alt',
		'menu_position'         => 7,
		'cat_slug'          => 'docs_cat', 
		'cat_label'         => esc_html__( 'Documents categories' , "altss" ), 
		'cat_labels'        => array(
                'name'              => esc_html__( 'Documents categories' , "altss" ),
                'singular_name'     => esc_html__( 'Documents category' , "altss" ),
                'search_items'      => esc_html__( 'Search documents category' , "altss" ),
                'all_items'         => esc_html__( 'All documents categories' , "altss" ),
                'parent_item'       => esc_html__( 'Parent documents category' , "altss" ),
                'parent_item_colon' => esc_html__( 'Parent documents category:' , "altss" ),
                'edit_item'         => esc_html__( 'Edit documents category' , "altss" ),
                'update_item'       => esc_html__( 'Update documents category' , "altss" ),
                'add_new_item'      => esc_html__( 'Add documents category' , "altss" ),
                'new_item_name'     => esc_html__( 'New documents category' , "altss" ),
                'menu_name'         => esc_html__( 'Documents categories' , "altss" ),
            ),
		'cat_description'    => esc_html__( 'Categories for documents' , "altss" ), 
		'tag_slug'           => 'docs_tag', 
		'rewrite_slug'       => 'docs', 
    ],

    'videos' => [
        'label'             => esc_html__( 'Videos' , "altss" ),
		'labels'            => array(
                'name'              => esc_html__( 'Videos' , "altss" ),
                'singular_name'     => esc_html__( 'Video' , "altss" ),
                'menu_name'         => esc_html__( 'Videos' , "altss" ),
                'all_items'         => esc_html__( 'All videos' , "altss" ),
                'add_new'           => esc_html__( 'Add video' , "altss" ),
                'add_new_item'      => esc_html__( 'Add new video' , "altss" ),
                'edit'              => esc_html__( 'Edit' , "altss" ),
                'edit_item'         => esc_html__( 'Edit video' , "altss" ),
                'new_item'          => esc_html__( 'New video' , "altss" ),
		    ),
		'description'       => '',
		'has_archive'       => 'videos',
		'taxonomies'        => array( 'video_cat' ),
		'menu_icon'         => 'dashicons-playlist-video',
		'menu_position'         => 8,
		'cat_slug'          => 'video_cat', 
		'cat_label'         => esc_html__( 'Videos categories' , "altss" ), 
		'cat_labels'        => array(
                'name'              => esc_html__( 'Videos categories' , "altss" ),
                'singular_name'     => esc_html__( 'Videos category' , "altss" ),
                'search_items'      => esc_html__( 'Search videos category' , "altss" ),
                'all_items'         => esc_html__( 'All videos categories' , "altss" ),
                'parent_item'       => esc_html__( 'Parent videos category' , "altss" ),
                'parent_item_colon' => esc_html__( 'Parent videos category:' , "altss" ),
                'edit_item'         => esc_html__( 'Edit videos category' , "altss" ),
                'update_item'       => esc_html__( 'Update videos category' , "altss" ),
                'add_new_item'      => esc_html__( 'Add videos category' , "altss" ),
                'new_item_name'     => esc_html__( 'New videos category' , "altss" ),
                'menu_name'         => esc_html__( 'Videos categories' , "altss" ),
            ),
		'cat_description'    => esc_html__( 'Categories for vdeos' , "altss" ), 
		'tag_slug'           => 'video_tag', 
		'rewrite_slug'       => 'videos', 
    ],
];
?>