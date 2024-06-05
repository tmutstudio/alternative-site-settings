<?php
add_action( 'admin_menu', 'reorder_admin_menu' );
function reorder_admin_menu() {
    global $menu;
    $tmp_menu = [];
    $new_menu = [];
    $custom_items = [];
    foreach( $menu as $v ){
        if( preg_match( "/\?post_type=news|\?post_type=promotions|\?post_type=books|\?post_type=docs|\?post_type=videos/", $v[2] )){
            $custom_items[] = $v;
            continue;
        }
        $tmp_menu[] = $v;
    }
    foreach( $tmp_menu as $val ){
        if( preg_match( "/\?post_type=page/", $val[2] )){
            $new_menu[] = $val;
            foreach( $custom_items as $item ){
                $new_menu[] = $item;
            }
            continue;
        }
        $new_menu[] = $val;
    }
    $menu = $new_menu;
}

add_action( 'admin_menu', 's_settings_menu_page' );
function s_settings_menu_page() {
    global $WPSS_ICON_B64;
    add_menu_page(
            esc_html__( "Site settings", "altss" ),
            'Alt Site Settings',
            'manage_options',
            'sitesetadmmenu',
            's_settings_start_page_html',
            'data:image/svg+xml;base64, ' . $WPSS_ICON_B64,
            14
            );
}


add_action( 'admin_menu', 's_settings_submenu_page' );
function s_settings_submenu_page(){

        $user_admin = current_user_can( 'manage_options' ) ? true : false;
            

            add_submenu_page(
                            'sitesetadmmenu',
                            esc_html__( "Site settings", "altss" ),
                            esc_html__( "Site settings", "altss" ),
                            'edit_private_posts',
                            'sitesetadmmenu',
                            's_settings_start_page_html',
                            1
                            );
    
            add_submenu_page(
                            'sitesetadmmenu',
                            esc_html__( "Contact forms", "altss" ),
                            esc_html__( "Contact forms", "altss" ),
                            'edit_private_posts',
                            'cforms_settings_page',
                            'cforms_settings_page_html',
                            2
                            );
            add_submenu_page(
                            'sitesetadmmenu',
                            esc_html__( "Reviews", "altss" ),
                            esc_html__( "Reviews", "altss" ),
                            'edit_private_posts',
                            'reviews_page',
                            'reviews_page_html',
                            3
                            );

            add_submenu_page(
                            'sitesetadmmenu',
                            esc_html__( "Special Settings", "altss" ),
                            esc_html__( "Special Settings", "altss" ),
                            'manage_options',
                            'special_settings_page',
                            'special_settings_page_html',
                            4
                            );
    
    
}
