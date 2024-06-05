<?php
add_action( 'admin_head', 'reviews_admin_header' );
function reviews_admin_header() {
	$page = altss_current_page();
	if( 'reviews_page' != $page ) return;
	echo '<style type="text/css">';
	echo '.wp-list-table .column-review_id { width: 5%; }';
	echo '.wp-list-table .column-review_text { width: 40%; }';
	echo '.wp-list-table .column-review_author_name { width: 15%; }';
	echo '.wp-list-table .column-review_create_date { width: 15%;}';
	echo '.wp-list-table .column-review_rating { width: 15%;}';
	echo '.wp-list-table .column-review_status { width: 10%;}';
	echo 'span.public span:hover { color: #059494 !important; text-decoration: underline; cursor: pointer; }';
	echo 'span.delete span { color: darkred; }';
	echo 'span.delete span:hover { color: red !important; text-decoration: underline; cursor: pointer; }';
	echo 'span.trash span { color: #985137; }';
	echo 'span.trash span:hover { color: darkred !important; text-decoration: underline; cursor: pointer; }';
	echo 'span.restore span:hover { color: #059494 !important; text-decoration: underline; cursor: pointer; }';
	echo 'span.respond a:hover, span.edit a:hover, span.delete a:hover { text-decoration: underline !important; }';
	echo '</style>';
}
 

if ( 'reviews_page' === altss_current_page() && !isset( $_GET['action'] ) ){
	add_action( "current_screen", 'reviews_page_add_options' );
}
function reviews_page_add_options() {
	$option = 'per_page';
	$args = array(
			'label' => esc_html__( "Reviews per page", "altss" ),
			'default' => 10,
			'option' => 'reviews_per_page'
	);
	add_screen_option( $option, $args );
}

function reviews_render_list_table(){
	$reviewsListTable = New Altsitesettings_Reviews_List_Table();
	$reviewsListTable->prepare_items();
    $reviewsListTable->views();
    echo '<form id="reviews-filter" method="post">';
    $reviewsListTable->search_box( esc_html__( "Search by text", "altss" ), 'search_id' );
    $reviewsListTable->display(); 
    echo '</form>'; 
}





function reviews_page_html() {
	global $wpdb, $hookname_reviews_page;
	$prefix = $wpdb->prefix;
	$action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] )  : 'start';
	$review_id = isset( $_GET['review_id'] ) ? intval( $_GET['review_id'] )  : 0;
        
    if( isset( $_POST['provider'] ) && !isset( $_POST['sub-search'] ) ){
        $args = [];
        foreach( $_POST['provider'] as $v ){
            $args['act'] = $_POST['action'];
            $args['id'] = intval( $v );
            if( 'show' === $args['act'] || 'hide' === $args['act']){
                altss_review_public__ajax_callback( $args );
            }
            else if( 'trash' === $args['act'] || 'restore' === $args['act']){
                altss_review_trash_restore( $args );
            }
            
        }
    }

    ?>
    <div class="altss-setting-page-wrapper">
	<h2 class="altss-admin-page-head"><?php esc_html_e( "REVIEWS", "altss" ); ?></h2>
	
    <br><br>
 	<div id="welcome-panel" class="altss-welcome-panel">
		<div class="">
          <?php
            switch ($action)://///////////// REVIEWS DATA ACTION SWITCH
                case "delete":///////////////////// DELETE ACTION
                ?>
                <?php
                break;/////// END DELETE ACTION
                case "respond":///////////////////// RESPOND ACTION
                case "respond2":///////////////////// RESPOND ACTION
                $thadm_admrevs_session = get_transient( 'thadm_admrevs_session' ) ?: [] ;
                if( isset( $_GET['mess'] ) && $_GET['mess'] === 'update' ){
                    altss_js_post_sucsess_mess( esc_html__( "Information updated!", "altss" ),
                    admin_url( "admin.php?page=reviews_page&review_id={$review_id}&action=respond2" ) );
                }

                if( $action === 'respond' ){
                    $back_to_list_link = $thadm_admrevs_session['back_to_list_link'] = wp_get_referer();
                    set_transient( 'thadm_admrevs_session', $thadm_admrevs_session );
                }
                else if( $action === 'respond2' ){
                    $back_to_list_link = $thadm_admrevs_session['back_to_list_link'];
                }
                
                $review_data = $wpdb->get_row( "SELECT * FROM {$prefix}altss_reviews WHERE review_id='{$review_id}'" );
                ?>
            <a href="<?php echo esc_url( $back_to_list_link ); ?>" class="altss-icon altss-adm-icon-allproducts"><?php esc_html_e( "Back to the list of reviews", "altss" ); ?></a>
            <h1><?php esc_html_e( "Reply to review", "altss" ); ?></h1>
            <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
                <input type="hidden" name="action" value="review-response-update" />
                <input type="hidden" name="review_id" value="<?php echo esc_attr( $review_id ); ?>" />
                <div class="altss-review-text-over">
                    <div class="altss-review-author-items-over">
                        <div class="altss-review-author-item-left"><?php esc_html_e( "Author's name", "altss" ); ?>:</div>
                        <div class="altss-review-author-item-right"><?php echo esc_html( $review_data->review_author_name );?></div>
                    </div>
                    <div class="altss-review-author-items-over">
                        <div class="altss-review-author-item-left"><?php esc_html_e( "Author's city", "altss" ); ?>:</div>
                        <div class="altss-review-author-item-right"><?php echo esc_html( $review_data->review_author_location );?></div>
                    </div>
                    <div class="altss-review-author-items-over">
                        <div class="altss-review-author-item-left"><?php esc_html_e( "Author's email", "altss" ); ?>:</div>
                        <div class="altss-review-author-item-right"><?php echo esc_html( $review_data->review_author_email );?></div>
                    </div>
                    <div class="altss-review-author-items-over">
                        <div class="altss-review-author-item-left"><?php esc_html_e( "Author's IP", "altss" ); ?>:</div>
                        <div class="altss-review-author-item-right"><?php echo esc_html( $review_data->review_author_ip );?></div>
                    </div>
                    <div class="altss-review-author-items-over">
                        <div class="altss-review-author-item-left"><?php esc_html_e( "RATING", "altss" ); ?>:</div>
                        <div class="altss-review-author-item-right">
                            
                            <?php 
                            $rating_stars = '';
                            for( $i = 1; $i < 6; $i++ ){
                                $class = $review_data->review_rating < $i ? 'altss-star-full' : 'altss-star-empty';
                                $rating_stars .= '<span class="altss-star ' . $class . '"></span>';
                            }
                            echo $rating_stars;
                            ?>
                        </div>
                    </div>
                    <div><?php esc_html_e( "Review text", "altss" ); ?>:</div>
                    <div class="altss-review-text"><?php echo esc_html( $review_data->review_text );?></div>
                </div>
                <div class="altss-review-respond-over">
                    <div class="altss-review-respond">
                        <?php altss_add_editior_field( 'review_response_text', $review_data->review_response_text, 10, 'minimal' );?>
                    </div>
                </div>
			<?php 
			submit_button();
			?>
            </form>
                <?php
                break;//////// END EDIT ACTION
                case "edit":///////////////////// EDIT ACTION
                ?>
                <?php
                break;//////// END EDIT ACTION
                case "start":///////////////////// START ACTION
                delete_transient( 'thadm_admrevs_session' );
                wp_enqueue_script('reviews-script', ALTSITESET_URL . '/admin/js/reviews-script.js', [], ALTSITESET__VERSION, true);
                wp_set_script_translations( 'reviews-script', 'altss', ALTSITESET_LANG_DIR . '/js' );
                ?>
                <?php reviews_render_list_table();?>
                <?php
                break;//////// END EDIT ACTION
            endswitch;/////////////// END REVIEWS DATA SWITCH
          ?>          
		</div>
        </div>
    </div>
<div id="ajax_message" style="display: none"></div>
<div id="tooltip" style="display: none;"></div>
   <?php
}
