<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ALTSS_Post_List_Table_Ext Class.
 */
final class ALTSS_Post_List_Table_Ext {
	/**
	 * EXTRABA Settings array.
	 *
	 * @var array
	 */
	protected static $settings = [];

	/**
	 * Allowed types  array.
	 *
	 * @var array
	 */
	protected static $allowed_types = [];


	/**
	 * Current post type.
	 *
	 * @var string
	 */
	protected static $current_type = '';

	public static function init(){
        global $altss_settings_options;
        self::$settings = $altss_settings_options;
        $all_types = $altss_settings_options['eba_post_types'] ?? [];

        foreach( $all_types as $type => $set ) {
            if( ! empty( $set['enable'] ) ) self::$allowed_types[$type] = $set;
        }

        //For compatibility with version 1.3.0
        if( empty( self::$allowed_types && ! empty( self::$settings['admin_tags_enable'] ) ) ) { 
            self::$allowed_types['post'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
            self::$allowed_types['news'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
            self::$allowed_types['promotions'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
            self::$allowed_types['books'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
            self::$allowed_types['docs'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
            self::$allowed_types['videos'] = [ 'enable' => 1, 'adm_tags_enable' => 1 ];
        } //For compatibility with version 1.3.0
        
		add_action( 'current_screen', [ __CLASS__, 'hooks' ], 30 );
		//add_action( 'load-edit.php', [ __CLASS__, 'hooks' ], 30 );
	}

	public static function hooks(){
        global $typenow;
        self::$current_type = $typenow;
        if( ! key_exists( $typenow, self::$allowed_types )  ) return;

        self::enqueue_scripts();

        add_action( 'bulk_actions-edit-' . $typenow, [ __CLASS__, 'define_bulk_actions' ], 30 );
        add_action( 'restrict_manage_posts', [ __CLASS__, 'render_filters' ] );
        add_action( 'manage_' . $typenow . '_posts_custom_column', [ __CLASS__, 'render_columns' ], 10, 2 );
        add_action( 'admin_head', [ __CLASS__, 'header_includes' ], 10 );
        add_action( 'admin_footer', [ __CLASS__, 'footer_includes' ], 10 );
        add_filter( 'handle_bulk_actions-edit-' . $typenow, [ __CLASS__, 'handle_bulk_actions' ], 30, 3 );
        add_filter( 'manage_' . $typenow . '_posts_columns', [ __CLASS__, 'manage_columns' ], 30, 3 );
	}


	public static function enqueue_scripts(){
        $i18n_adding_tags = 'page' === self::$current_type ? __( 'Adding Admin tags', 'alternative-site-settings' ) : __( 'Adding tags', 'alternative-site-settings' );
        $i18n_detaching_tags = 'page' === self::$current_type ? __( 'Detaching Admin tags', 'alternative-site-settings' ) : __( 'Detaching tags', 'alternative-site-settings' );
        wp_enqueue_script( 'altss_quick-edit-bulk-tags', ALTSITESET_URL . '/admin/js/quick-edit-bulk-tags.js', array( 'jquery' ), ALTSITESET__VERSION, true );
        $params = array(
            'i18n_apply'                    => __( 'Apply' ),
            'i18n_to_cats_mark_categories'  => __( 'Please check the required categories to add to your posts', 'alternative-site-settings' ),
            'i18n_from_cats_mark_categories'=> __( 'Please check the required categories to unlink from posts', 'alternative-site-settings' ),
            'i18n_err_category_list'        => __( 'Something went wrong while creating the category list!', 'alternative-site-settings' ),
            'i18n_adding_tags'              => $i18n_adding_tags,
            'i18n_detaching_tags'           => $i18n_detaching_tags,
            'i18n_to_cats'                  => __( 'Place in categories', 'alternative-site-settings' ),
            'i18n_from_cats'                => __( 'Remove from categories', 'alternative-site-settings' ),
            'post_type'                     => self::$current_type,
            'adm_tags_enable'               => ! empty( self::$allowed_types[self::$current_type]['adm_tags_enable'] ),
            'ajax_url'                      => admin_url( 'admin-ajax.php' ),
            'bulk_cat_nonce'                => wp_create_nonce( 'get_categories_list' ),
            'images_dir_url'                => ALTSITESET_URL .  '/admin/images',
        );

        wp_localize_script( 'altss_quick-edit-bulk-tags', 'altss_quick_edit_bt', $params );
    }


	public static function header_includes(){
        echo '<style>
                .ui-autocomplete {
                    padding: 0;
                    margin: 0;
                    list-style: none;
                    position: absolute;
                    z-index: 10000;
                    border: 1px solid #4f94d4;
                    box-shadow: 0 1px 2px rgba(79,148,212,.8);
                    background-color: #fff;
                }
            </style>';

    }



	public static function footer_includes(){
        $type = self::$current_type;
        $adm_tag = 'adm_' . $type . '_tag';
        $public_tag = $type . '_tag';
        $cat_type = 'post' === $type ? 'category' : $type . '_cat';
        include ALTSITESET_CLASSES_DIR . '/views/html-popup-container.php';
        include ALTSITESET_CLASSES_DIR . '/views/html-tag-cat-bulk-action-extra-area.php';
    }






	/**
	 * Define bulk actions.
	 *
	 * @param array $actions Existing actions.
	 * @return array
	 */
	public static function define_bulk_actions( $actions ) {
        $post_type = self::$current_type;
		$actions       = array();
		$post_type_obj = get_post_type_object( $post_type );
        $is_trash = isset( $_REQUEST['post_status'] ) && 'trash' === $_REQUEST['post_status'];
        $is_pending = isset( $_REQUEST['post_status'] ) && 'pending' === $_REQUEST['post_status'];
        $is_draft = isset( $_REQUEST['post_status'] ) && 'draft' === $_REQUEST['post_status'];
        $is_publish = isset( $_REQUEST['post_status'] ) && 'publish' === $_REQUEST['post_status'];

		if ( current_user_can( $post_type_obj->cap->edit_posts ) ) {
			if ( $is_trash ) {
				$actions['untrash'] = __( 'Restore' );
			} else {
				$actions['edit'] = __( 'Edit' );
				if ( ! $is_publish ) $actions['publish'] = __( 'Publish' );
				if ( ! $is_pending ) $actions['pending'] = __( 'Pending Review' );
				if ( ! $is_draft ) $actions['draft'] = __( 'Draft' );
                $actions['add_tags'] = __( 'Add tags', 'alternative-site-settings' );
                $actions['detach_tags'] = __( 'Detach tags', 'alternative-site-settings' );
                if( 'page' !== $post_type ) {
                    $actions['to_cats'] = __( 'Place in categories', 'alternative-site-settings' );
                    $actions['from_cats'] = __( 'Remove from categories', 'alternative-site-settings' );
                }
			}
		}

		if ( current_user_can( $post_type_obj->cap->delete_posts ) ) {
			if ( $is_trash || ! EMPTY_TRASH_DAYS ) {
				$actions['delete'] = __( 'Delete permanently' );
			} else {
				$actions['trash'] = __( 'Move to Trash' );
			}
		}
		return $actions;
	}

	/**
	 * Handle bulk actions.
	 *
	 * @param  string $redirect_to URL to redirect to.
	 * @param  string $action      Action name.
	 * @param  array  $ids         List of ids.
	 * @return string
	 */
	public static function handle_bulk_actions( $redirect_to, $action, $ids ) {

        $results = [];

        foreach( $ids as $post_id ){
            switch ( $action ) {
                case 'pending':
                    wp_update_post( [
			            'ID' => absint( $post_id ),
			            'post_status' => 'pending'
		                ] );
                    break;
                
                case 'publish':
                    wp_update_post( [
			            'ID' => absint( $post_id ),
			            'post_status' => 'publish'
		                ] );
                    break;
                
                case 'draft':
                    wp_update_post( [
			            'ID' => absint( $post_id ),
			            'post_status' => 'draft'
		                ] );
                    break;
                
                case 'add_tags':
                case 'to_cats':
                case 'detach_tags':
                case 'from_cats':
                    if( 'add_tags' === $action || 'detach_tags' === $action ){
                        $tags_cats = sanitize_text_field( $_REQUEST['tag_names']);
                        $term_type = sanitize_key( $_REQUEST['tag_type']);
                    }
                    else {
                        $tags_cats = sanitize_text_field( $_REQUEST['bulk_cat_ids']);
                        $term_type = sanitize_key( $_REQUEST['cat_type']);
                    }

                    $params = [ 
                        'fields' => 'ids',
                        'taxonomy' =>$term_type
                        ];


                    if( 'add_tags' === $action || 'to_cats' === $action ){
                        wp_set_post_terms( absint( $post_id ), $tags_cats, $term_type, true );
                    }
                    else {
                        if( 'from_cats' === $action ) {
                            $params['include'] = $tags_cats;
                        }
                        else {
                            if ( ! is_array( $tags_cats ) ) {
                                $tags_cats = explode( ',', trim( $tags_cats, " \n\t\r\0\x0B," ) );
                            }
                            $params['name'] = $tags_cats;
                        }
                        $terms = get_terms( $params );

                        wp_remove_object_terms( absint( $post_id ), $terms, $term_type );
                    }
                    
                    break;               
                
            }
        }

		return esc_url_raw( $redirect_to );
	}

	/**
	 * Render any custom filters and search inputs for the list table.
	 */
	public static function render_filters() {
		$filters =  array(
				'cat' => array( __CLASS__, 'render_custom_cat_filter' ),
				'adm_post_tag' => array( __CLASS__, 'render_adm_posts_tag_filter' ),
				'post_tag' => array( __CLASS__, 'render_posts_tag_filter' ),
			);

		ob_start();
		foreach ( $filters as $filter_callback ) {
			call_user_func( $filter_callback );
		}
		$output = ob_get_clean();

        $kses_params = [
            'select' => array(
                'name' => true,
                'id' => true,
                'class' => true,
                'multiple' => true,
                'size' => true,
                'disabled' => true,
                'required' => true,
            ),
            'option' => array(
                'value' => true,
                'selected' => true,
                'disabled' => true,
                'class' => true,
            ),
        ];


		echo wp_kses( $output, $kses_params );
	}




	/**
	 * Render the Custom type Category filter for the list table.
	 *
	 * 
	 */
	protected static function render_custom_cat_filter() {
        $type = self::$current_type;
        if( in_array( $type, [ 'page', 'post', 'product' ] )  ) return;

        $current_cat_slug = isset( $_GET[$type . '_cat'] ) ? sanitize_text_field( wp_unslash( $_GET[$type . '_cat'] ) ) : false; // WPCS: input var ok, CSRF ok.
        wp_dropdown_categories(
            array(
                'show_option_all'       => esc_html__( 'Filter by Category', 'alternative-site-settings' ),
                'show_option_none'      => esc_html__( 'No Category', 'alternative-site-settings' ),
                'hide_empty'            => 0,
                'orderby'               => 'name',
                'taxonomy'              => $type . '_cat',
                'name'                  => $type . '_cat',
                'id'                    => 'dropdown_cat',
                'value_field'           => 'slug',
                'selected'              => $current_cat_slug,
                'option_none_value'     => '',
            )
        );
	}

	/**
	 * Render the Admin post tag filter for the list table.
	 *
	 * 
	 */
	protected static function render_adm_posts_tag_filter() {
        $type = self::$current_type;
        if( empty( self::$allowed_types[$type]['adm_tags_enable'] ) ) return;
        $current_tag_slug = isset( $_GET['adm_' . $type . '_tag'] ) ? sanitize_text_field( wp_unslash( $_GET['adm_' . $type . '_tag'] ) ) : false; // WPCS: input var ok, CSRF ok.
        wp_dropdown_categories(
            array(
                'show_option_all'       => esc_html__( 'Filter by Admin tag', 'alternative-site-settings' ),
                'show_option_none'      => esc_html__( 'Abmin: No tags', 'alternative-site-settings' ),
                'hide_empty'            => 0,
                'orderby'               => 'name',
                'taxonomy'              => 'adm_' . $type . '_tag',
                'name'                  => 'adm_' . $type . '_tag',
                'id'                    => 'dropdown_adm_post_tag',
                'value_field'           => 'slug',
                'selected'              => $current_tag_slug,
                'option_none_value'     => '',
            )
        );
	}

	/**
	 * Render the Public post tag filter for the list table.
	 *
	 * 
	 */
	protected static function render_posts_tag_filter() {
        $type = self::$current_type;
        if( in_array( $type, [ 'page', 'product' ] )  ) return;
        $tag_key = 'post' === $type ? 'tag' : $type . '_tag';
		$tags_count = (int) wp_count_terms( $type . '_tag' );
        $current_tag_slug = isset( $_GET[$tag_key] ) ? sanitize_text_field( wp_unslash( $_GET[$tag_key] ) ) : false; // WPCS: input var ok, CSRF ok.

		if ( $tags_count <= 500 ) {
			wp_dropdown_categories(
				array(
					'show_option_all'       => esc_html__( 'Filter by Public tag', 'alternative-site-settings' ),
					'show_option_none'      => esc_html__( 'Public: No tags', 'alternative-site-settings' ),
					'hide_empty'            => 0,
					'orderby'               => 'name',
                    'taxonomy'              => $type . '_tag',
                    'name'                  => $tag_key,
                    'id'                    => 'dropdown_post_tag',
                    'value_field'           => 'slug',
                    'selected'              => $current_tag_slug,
                    'option_none_value'     => '',
				)
			);
		} else {
			$current_tag      = $current_tag_slug ? get_term_by( 'slug', $current_tag_slug, 'post_tag' ) : false;
			?>
			<select class="wc-category-search" name="tag" data-placeholder="<?php esc_attr_e( 'Filter by tag', 'alternative-site-settings' ); ?>" data-allow_clear="true">
				<?php if ( $current_tag_slug && $current_tag ) : ?>
					<option value="<?php echo esc_attr( $current_tag_slug ); ?>" selected="selected"><?php echo esc_html( htmlspecialchars( wp_kses_post( $current_tag->name ) ) ); ?></option>
				<?php endif; ?>
			</select>
			<?php
		}
	}



	/**
	 * Manage columns for List Table.
	 *
	 * @param  array  $columns         List of columns.
	 * @return array
	 */
	public static function manage_columns( $columns ) {
        $post_type = self::$current_type;
        $tags_col_name = esc_attr__( 'Tags', 'alternative-site-settings' );
        unset( $columns['tags'] );
        if( in_array( $post_type, [ 'post', 'product' ] ) ) {
            $tags_col_name = esc_attr__( 'Tags' );
        }
        else if( in_array( $post_type, [ 'page', 'product' ] ) ) {
            $tags_col_name = esc_attr__( 'Admin tags', 'alternative-site-settings' );
        }
        $new_columns = [];
        
        foreach( $columns as $key => $val ){
            if( 'product_tag' === $key ||'comments' === $key || 'date' === $key ) {
                $new_columns[$post_type . '_tags'] = $tags_col_name;
            }
            if( 'product_tag' !== $key ) {
                $new_columns[$key] = $val;
            }
        }
        
        return $new_columns;

    }
    

	/**
	 * Render individual columns.
	 *
	 * @param string $column Column ID to render.
	 * @param int    $post_id Post ID being shown.
	 */
	public static function render_columns( $column, $post_id ) {
        $type = self::$current_type;
		if ( $column ===  $type . '_tags' ) {
			self::{"render_tags_column"}();
		}
	}

	/**
	 * Render column: tag.
	 */
	protected static function render_tags_column() {
		global $post;
        if( ! in_array( $post->post_type, [ 'page' ] ) ) {
            $tag_key = 'post' === $post->post_type ? 'tag' : $post->post_type . '_tag';
            $terms = get_the_terms( $post->ID, $post->post_type . '_tag' );
            $public_tags_name = in_array( $post->post_type, [ 'post', 'product' ] ) ? __( 'Tags' ) : __( 'Public tags', 'alternative-site-settings');
            echo '<div>';
            if( ! empty( self::$allowed_types[$post->post_type]['adm_tags_enable'] ) ) {
                echo '<span class="">' . esc_html( $public_tags_name ) . ': </span>';
            }
            if ( ! $terms ) {
                echo '<span class="na">&ndash;</span>';
            } else {
                $termlist = array();
                foreach ( $terms as $term ) {
                    $termlist[] = '<a href="' . esc_url( admin_url( 'edit.php?' . $tag_key . '=' . $term->slug . '&post_type=' . $post->post_type ) ) . ' ">' . esc_html( $term->name ) . '</a>';
                }

                echo wp_kses_post( implode( ', ', $termlist ) );
            }
            echo "</div>\n";
        }

        if( empty( self::$allowed_types[$post->post_type]['adm_tags_enable'] ) ) return;

		$adm_terms = get_the_terms( $post->ID, 'adm_' . $post->post_type . '_tag' );
        if( ! in_array( $post->post_type, [ 'page' ] ) ) echo '<div><span class="">' . esc_html__( 'Admin tags', 'alternative-site-settings') . ': </span>';
        else echo '<div>';
		if ( ! $adm_terms ) {
			echo '<span class="na">&ndash;</span>';
		} else {
			$adm_termlist = array();
			foreach ( $adm_terms as $term ) {
				$adm_termlist[] = '<a href="' . esc_url( admin_url( 'edit.php?adm_' . $post->post_type . '_tag=' . $term->slug . '&post_type=' . $post->post_type ) ) . ' ">' . esc_html( $term->name ) . '</a>';
			}

			echo wp_kses_post( implode( ', ', $adm_termlist ) );
		}
        echo "</div>\n";
	}

	/**
	 * Render Categories list with checkboxes for ajax.
	 */
	public static function render_categories() {
        check_ajax_referer( 'get_categories_list', 'security' );
        $post_type = sanitize_text_field( $_POST['post_type'] ?? '' );
        $taxonomy = $post_type === 'post' ? 'category' : $post_type . '_cat';

        echo "<ul class=\"root\">\n";
        self::render_cat_list( 0, $taxonomy );
        echo "</ul>\n";
    
        die();
    }   
    
    protected static function render_cat_list( $parent, $taxonomy ) {
        $terms = get_terms( [
            'taxonomy' => $taxonomy,
            'parent' => $parent,
            'hide_empty' => 0,
        ] );
        foreach ( $terms as $cat) {
            echo ( 0 == $parent ? '<li class="root-cat">' : "<li>") . "\n";
            echo '<label data-title="' . esc_attr( $cat->name ) . '" data-slug="' . esc_attr( $cat->slug ) . '" data-parent="' . esc_attr( $cat->parent ) . '">' . "\n";
            echo '<input type="checkbox" id="cat__' . esc_attr( $cat->term_id ) . '" name="cat[]" value="' . esc_attr( $cat->term_id ) . '" />' . "\n";
            echo "- " . esc_html( $cat->name ) . "</label>\n<ul>\n";
            self::render_cat_list( $cat->term_id, $taxonomy );
            echo "</ul>\n</li>\n";
        }

    }


}