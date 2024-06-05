<?php

add_action( 'admin_init', 's_settings_options_init' );
function s_settings_options_init() {
    
    register_setting( 's_settings_options', 'blogname' );
    register_setting( 's_settings_options', 'blogdescription' );
    register_setting( 's_settings_options', 's_settings_options' );
    register_setting( 's_settings_options', 'copyright_info' );

    register_setting( 's_settings_options_1', 's_settings_options_custom_recs' );
    register_setting( 's_settings_options_1', 's_settings_options_custom_recs_settings' );

    for( $i = 1; $i < 6; $i++ ) {
        register_setting( 's_settings_options_txt', 's_settings_options_embedded_text_' . $i );
    }
}


function s_settings_start_page_html(){
	$action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] )  : 'start';
	$tab = isset( $_GET['tab'] ) ? intval( $_GET['tab'] )  : 0;


    $form_title_ar = [];
    for ($i = 1; $i < ALTSITESET_CFORMS_AMOUNT; $i++) {
        $form_title_ar[$i] = get_option( "s_settings_cforms_options_title_{$i}" );
    }
    
    wp_enqueue_style( 'custom_controls_css', ALTSITESET_URL . '/admin/css/custom_controls.css', [], ALTSITESET__VERSION);
    wp_enqueue_script('settings-script', ALTSITESET_URL . '/admin/js/settings-script.js', [], ALTSITESET__VERSION, true);
    
?>
<div class="site-settings-page-wrapper">
    <h2 class="site-settings-admin-page-head"><?php esc_html_e( "Start page for site settings", "altss" ); ?></h2> 
	
   
    <div id="welcome-panel" class="thadm-welcome-panel">
    <?php
            $tab_title = [
                0 => esc_html__( "Main settings", "altss" ),
                1 => esc_html__( "Custom records", "altss" ),
                2 => esc_html__( "Text blocks", "altss" )
            ];
            altss_navtabs( $tab_title, $tab ); 
            ?>
        
	<div class="">
            
            <div class="site-settings-template-wrapp">
                <form action="options.php" method="POST">
<?php switch ($tab): /////////////// TAB SWITCH
        case 0://////////////////////////////////// TAB 0 SECTION
            include_once ALTSITESET_INCLUDES_DIR.'/sub-includes/start-page-tab-0.php';
            break;
        case 1://////////////////////////////////// TAB 1 SECTION
            include_once ALTSITESET_INCLUDES_DIR.'/sub-includes/start-page-tab-1.php';
		break;
        case 2://////////////////////////////////// TAB 2 SECTION
            include_once ALTSITESET_INCLUDES_DIR.'/sub-includes/start-page-tab-2.php';
            break;
    endswitch;/////////////// END TABS SWITCH

?>
                </form>
            </div>
    
        </div>
    </div>
</div>
<?php
}