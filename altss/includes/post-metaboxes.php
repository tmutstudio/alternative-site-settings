<?php

add_action('add_meta_boxes', 'altss_extra_desc_metabox', 1);

function altss_extra_desc_metabox() {
	add_meta_box(
		'meta_description',
		__( "Description tag field", "altss" ),
		'altss_extra_desc_field', 
		[ 
			'page', 
			'post', 
			'news',
			'actions',
			'books',
			'docs', 
			'videos' 
		],
		'normal', 
		'high'
	);
}

function altss_extra_desc_field( $post ){
	?>
    <div style="margin: 0; padding: 20px; background-color: #e4f0f3;">
	<p><?php esc_html_e( "Article description", "altss" ); ?> (description):
		<textarea type="text" name="meta_description" style="width:100%;height:100px;"><?php echo esc_textarea( get_post_meta($post->ID, 'meta_description', 1) ); ?></textarea>
	</p>
    </div>

	<input type="hidden" name="meta_description_nonce" value="<?php echo esc_attr( wp_create_nonce(__FILE__) ); ?>" />
	<?php
}

add_action( 'save_post', 'altss_extra_desc_metabox_update', 0 );

function altss_extra_desc_metabox_update( $post_id ){
	if (
		! wp_verify_nonce( @$_POST['meta_description_nonce'], __FILE__ )
		|| wp_is_post_autosave( $post_id )
		|| wp_is_post_revision( $post_id )
	)
		return false;

	$_POST['meta_description'] = sanitize_textarea_field ( $_POST['meta_description'] );
	if( empty( $_POST['meta_description'] ) ){
			delete_post_meta( $post_id, 'meta_description' ); 
		}

	update_post_meta( $post_id, 'meta_description', $_POST['meta_description'] );

	return $post_id;
}


add_filter( 'document_title', 'altss_modify_document_title' );

function altss_modify_document_title( $title ) {
	if (is_front_page()) {
		$s_settings_options = get_option("s_settings_options");
		return '' != @$s_settings_options['home_title'] ? @$s_settings_options['home_title'] : $title;
	}
	else{
		return $title;
	}
}


add_action("wp_head", "add_wp_head_meta_tags", 1);
 
function add_wp_head_meta_tags() {
	global $post;
    $s_settings_options = get_option( "s_settings_options" );
	$ogtitle = wp_get_document_title();
	$ogurl = get_self_link();
	$ogtype = 'article';
	$ogimg = @$s_settings_options['meta_ogimage'];
    
	if( is_singular() && !is_front_page() ) {
        if(has_post_thumbnail($post->ID)) {
            $ogimg = wp_get_attachment_image_url( get_post_thumbnail_id( $post->ID ), 'large' );
        }
		$meta_description = get_post_meta( $post->ID, 'meta_description', true );
		$post_excerpt = wp_strip_all_tags( apply_filters( 'get_the_excerpt', $post->post_excerpt, $post ), true );
		$desc_value = $ogdesc = esc_attr( $meta_description ?: wp_strip_all_tags( $post_excerpt ) );
	}
    elseif( is_archive() ){
        $desc_value = $ogdesc = esc_attr( wp_strip_all_tags( get_the_archive_title()  . ' | ' . term_description() ) );
    }
    else{
        $desc_value = $ogdesc = esc_attr( @$s_settings_options['home_desc'] );
		$ogtype = 'website';
    }

    echo '<meta name="description" value="' . esc_attr( $desc_value ) . '" />
<meta property="og:url" content="' . esc_url( @$ogurl ) . '" />
<meta property="og:type" content="' . esc_attr( @$ogtype ) . '" />
<meta property="og:title" content="' . esc_attr( @$ogtitle ) . '" />
<meta property="og:description" content="' . esc_attr( $ogdesc ) . '" />
<meta property="og:image" content="' . esc_url( $ogimg ) . '" />
	';
}