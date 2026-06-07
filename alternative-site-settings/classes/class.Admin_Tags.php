<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ALTSS_Admin_Tags Class.
 */
final class ALTSS_Admin_Tags {
	/**
	 * ALTSS settings  array.
	 *
	 * @var array
	 */
	protected static $settings = [];

	public static function init(){
        self::$settings = get_option( "altss_settings_options" );
		add_action( 'init', [ __CLASS__, 'admin_tags' ], 30 );
	}

	public static function admin_tags(){
        $allowed_types = self::$settings['eba_post_types'] ?? [];

        //For compatibility with version 1.3.0
        if( empty( $allowed_types && ! empty( self::$settings['admin_tags_enable'] ) ) ) { 
            $allowed_types['post'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
            $allowed_types['news'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
            $allowed_types['promotions'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
            $allowed_types['books'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
            $allowed_types['docs'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
            $allowed_types['videos'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
        } //For compatibility with version 1.3.0

        foreach( $allowed_types as $type => $data ) {
            if( empty( $data['adm_tags_enable'] ) ) {
                continue;
            }
            register_taxonomy( "adm_{$type}_tag", $type, [
                'hierarchical'      => false,
                'label'             => esc_html__( 'Admin tags' , "alternative-site-settings" ),
                'labels'            => array(
                    'name'              => esc_html__( 'Admin tags' , "alternative-site-settings" ) . '( ' . strtoupper( $type ) . ' )',
                    'singular_name'     => esc_html__( 'Admin tag' , "alternative-site-settings" ),
                    'search_items'      => esc_html__( 'Search tags' , "alternative-site-settings" ),
                    'all_items'         => esc_html__( 'All Admin tags' , "alternative-site-settings" ),
                    'edit_item'         => esc_html__( 'Edit Admin tag' , "alternative-site-settings" ),
                    'update_item'       => esc_html__( 'Update Admin tag' , "alternative-site-settings" ),
                    'add_new_item'      => esc_html__( 'Add Admin tag' , "alternative-site-settings" ),
                    'new_item_name'     => esc_html__( 'New Admin tag' , "alternative-site-settings" ),
                    'menu_name'         => esc_html__( 'Admin tags' , "alternative-site-settings" ),
                    ),
                'query_var'         => "adm_{$type}_tag",
                'show_ui'           => true,
                'publicly_queryable'=> false,
                'rewrite'           => false,
                'show_in_rest'      => true,
            ]);
        }
	}
}