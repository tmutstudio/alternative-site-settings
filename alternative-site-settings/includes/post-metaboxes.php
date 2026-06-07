<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action('rest_api_init', function() {
    global $post;
    if( ! empty( $post ) ) {
        $type = $post->post_type;
        register_post_meta( $type, '_seo_meta_title', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'auth_callback' => '__return_true'
        ]);
        
        register_post_meta( $type, '_seo_meta_description', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'auth_callback' => '__return_true'
        ]);

        register_post_meta( $type, '_seo_meta_og_image', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'auth_callback' => '__return_true'
        ]);
    }


} );


add_action('add_meta_boxes', 'altss_extra_seo_metabox', 1);

function altss_extra_seo_metabox() {
    global $altss_settings_options, $post, $wp_meta_keys;
    $type = $post->post_type;
    switch ( $type ) {
        case 'page':
            $meta_title = __( "Page title text", "alternative-site-settings" );
            break;
        case 'post':
            $meta_title = __( "Post title text", "alternative-site-settings" );
            break;
    }
    if( empty( $altss_settings_options['seo_meta_enabled'] ) ) {
        return;
    }
    if ( function_exists( 'use_block_editor_for_post' ) && use_block_editor_for_post( $post ) ) {
        wp_enqueue_script(
            'altss-ge-metaboxes',
            ALTSITESET_URL . '/admin/js/ge-metaboxes.js',
            [
                'wp-plugins',
                'wp-edit-post', 
                'wp-element',
                'wp-components',
                'wp-data',
                'wp-block-editor',
                'wp-i18n'
            ],
            ALTSITESET__VERSION
        );
        wp_localize_script( 'altss-ge-metaboxes', 'geScriptData',
            [
                'i18n_panel_title' => esc_html__( 'Data for SEO promotion', 'alternative-site-settings' ),
                'i18n_title_label' => $meta_title,
                'i18n_desc_label' => esc_html__( 'Article description', 'alternative-site-settings' ),
                'i18n_ogimage_label' => esc_html__( 'og:image', 'alternative-site-settings' ),
                'i18n_ogimage_res_label' => esc_html__( 'Optimal resolution 600x315 pixels', 'alternative-site-settings' ),
                'i18n_replace_image_label' => esc_html__( 'Replace image', 'alternative-site-settings' ),
                'i18n_select_image_label' => esc_html__( 'Select an image', 'alternative-site-settings' ),
                'i18n_delete_image_label' => esc_html__( 'Delete', 'alternative-site-settings' ),
            ]
        );

        return;
    }
    
    add_filter( 'is_protected_meta', function( $protected, $meta_key ){
        $hide_meta_keys = array( 'footnotes' );
        if( in_array( $meta_key, $hide_meta_keys ) ){
            return true;
        }

        return $protected;
    }, 10, 2 );


	add_meta_box(
		'seo_meta_box',
		__( "Data for SEO promotion", "alternative-site-settings" ),
		'altss_seo_meta_box', 
		[ 
			'page', 
			'post', 
			'news',
			'promotions',
			'books',
			'docs', 
			'videos', 
		],
		'normal',
        'high',
        [
		'__back_compat_meta_box' => false,
	    ]
	);
 
}

function altss_seo_meta_box( $post ){
    $type = $post->post_type;
    switch ( $type ) {
        case 'page':
            $meta_title = __( "Page title text", "alternative-site-settings" );
            break;
        case 'post':
            $meta_title = __( "Post title text", "alternative-site-settings" );
            break;
    }

    $title_value = get_post_meta( $post->ID, '_seo_meta_title', true );
    $title_value_depr = get_post_meta( $post->ID, 'seo_meta_title', true );
    $description_value = get_post_meta( $post->ID, '_seo_meta_description', true );
    $description_value_depr = get_post_meta( $post->ID, 'seo_meta_description', true );
    $og_image_value = get_post_meta( $post->ID, '_seo_meta_og_image', true );
    $og_image_value_depr = get_post_meta( $post->ID, 'seo_meta_og_image', true );

    $title_val = empty( $title_value_depr ) ? $title_value ?? '' : $title_value_depr;
    $description_val = empty( $description_value_depr ) ? $description_value ?? '' : $description_value_depr;
    $og_image_val = empty( $og_image_value_depr ) ? $og_image_value ?? '' : $og_image_value_depr;

?>
    <div class="seo-meta-box-container">
	<p><?php echo esc_html( $meta_title ); ?> (meta tag title):
		<input type="text" name="_seo_meta_title" style="width:100%;" value="<?php echo esc_html( $title_val ); ?>" />
	</p>
	<p><?php esc_html_e( "Article description", "alternative-site-settings" ); ?> (meta tag description):
		<textarea name="_seo_meta_description" style="width:100%;height:100px;"><?php echo esc_textarea( $description_val ); ?></textarea>
	</p>
    <p><?php esc_html_e( 'og:image', 'alternative-site-settings' ); ?><br />
       <?php esc_html_e( 'Optimal resolution 600x315 pixels', 'alternative-site-settings' ); ?><br />
        <?php 
            altss_include_uploadscript();
            altss_image_uploader_field( '_seo_meta_og_image', esc_url( $og_image_val ) );
        ?>
    </p>
    </div>

	<input type="hidden" name="seo_meta_box_nonce" value="<?php echo esc_attr( wp_create_nonce(__FILE__) ); ?>" />
	<?php
}

add_action( 'save_post', 'altss_seo_meta_box_update', 0 );

function altss_seo_meta_box_update( $post_id ){
	if (
		! wp_verify_nonce( sanitize_text_field( wp_unslash( @$_POST['seo_meta_box_nonce'] ) ), __FILE__ )
		|| wp_is_post_autosave( $post_id )
		|| wp_is_post_revision( $post_id )
	)
		return false;

	$meta_title = sanitize_text_field( $_POST['_seo_meta__title'] );
	$meta_description = sanitize_textarea_field ( $_POST['_seo_meta__description'] );
	$meta_og_image = sanitize_url ( $_POST['_seo_meta__og_image'] );
	
    if( empty( $meta_title ) ){
			delete_post_meta( $post_id, '_seo_meta__title' ); 
	}
    else {
        update_post_meta( $post_id, '_seo_meta__title', $meta_title );
    }

    if( empty( $meta_description ) ){
			delete_post_meta( $post_id, '_seo_meta__description' ); 
	}
    else {
        update_post_meta( $post_id, '_seo_meta__description', $meta_description );
    }

    if( empty( $meta_og_image ) ){
			delete_post_meta( $post_id, '_seo_meta__og_image' ); 
	}
    else {
        update_post_meta( $post_id, '_seo_meta__og_image', $meta_og_image );
    }

	

	return $post_id;
}


