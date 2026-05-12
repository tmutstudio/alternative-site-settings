<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ALTSS_Admin_Tags Class.
 */
final class ALTSS_Admin_Tags {
	/**
	 * Custom Recs Data array.
	 *
	 * @var array
	 */
	protected static $custom_recs = [];

	public static function init(){
        self::$custom_recs = get_option( "altss_settings_options_custom_recs" );
        self::$custom_recs = is_array( self::$custom_recs ) ? self::$custom_recs : [];
		add_action( 'init', [ __CLASS__, 'admin_tags' ], 30 );
	}

	public static function admin_tags(){
        $types = ['post'];
        foreach( self::$custom_recs as $key => $v ) {
            $types[] = $key;
        }
        foreach( $types as $type ) {
            register_taxonomy( "adm_{$type}_tag", $type, [
                'hierarchical'          => false,
                'label'                 => esc_html__( 'Admin tags' , "alternative-site-settings" ),
                'labels'                => array(
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
                'query_var'             => "adm_{$type}_tag",
                'show_ui'               => true,
                'publicly_queryable' => false,
                'rewrite' => false,
            ]);
        }
	}
}