<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', function() {
    
    register_setting( 'altss_uninstall_options', 'altss_uninstall_data_enable', 'altss_text_field_clean' );
    register_setting( 'altss_uninstall_options', 'altss_uninstall_data_items', 'altss_text_field_clean' );
} );

function altss_special_settings_page_html(){

    wp_enqueue_style( 'custom_controls_css', ALTSITESET_URL . '/admin/css/custom_controls.css', [], ALTSITESET__VERSION);
    wp_enqueue_script('specialized-settings-script', ALTSITESET_URL . '/admin/js/specialized-settings-script.js', [], ALTSITESET__VERSION, true);

    $altss_uninstall_enable = get_option( "altss_uninstall_data_enable", 'false' );
    $altss_uninstall_items = get_option( "altss_uninstall_data_items" );

    //For compatibility with version 1.3.0
    if( empty( $altss_uninstall_items['admin_tags']['post'] ) && ! empty( $altss_uninstall_items['admin_post_tags'] )) {
        $altss_uninstall_items['admin_tags']['post'] = 1;
    }//For compatibility with version 1.3.0

    include ALTSITESET_INCLUDES_DIR.'/data-vars/custom-type-vars.php';

    $POST_TYPES = [
        'page' => 'page',
        'post' => 'post',
        ];
    $gpt_args = [
        'public'   => true,
        '_builtin' => false
        ];
    $POST_TYPES = array_merge( $POST_TYPES, get_post_types( $gpt_args, 'names' ) );


    ?>
<div class="site-settings-page-wrapper">
    <h2 class="site-settings-admin-page-head"><?php esc_html_e( "Specialized settings and tools page", "alternative-site-settings" ); ?></h2> 

    <div id="welcome-panel" class="thadm-welcome-panel">    
        <div class="site-settings-template-wrapp">
            <div class="site-settings-options-gr-wrap">
                <dl class="site-settings-specialized-dl">
                    <dt><span><?php esc_html_e( "Clearing revisions in the posts table", "alternative-site-settings" ); ?></span></dt>
                    <dd>
        <?php 
            if( isset( $_POST['revisions_clear'] )){
                if( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'rrr55rds' ) && "kfujr674urf7" === $_POST['revisions_clear'] && altss_post_revisions_clear() ){
                    echo "<p style='color: green;'>" . esc_html__( "Post table revisions have been cleared!", "alternative-site-settings" ) . "</p>";
                }
                else{
                    echo "<p style='color: darkred;'>" . esc_html__( "The request returned a null result.", "alternative-site-settings" ) . "</p>";
                }
            }
        ?>
                        <form method="POST">
                            <?php wp_nonce_field("rrr55rds", "nonce"); ?>
                            <input type="hidden" name="revisions_clear" value="kfujr674urf7"  />
                            <div class="site-settings-template-item-wrapp">
                                <input type="submit" class="button" value="<?php esc_html_e( "Clear post revisions", "alternative-site-settings" ); ?>" />
                            </div>
                        </form>
                    </dd>
                </dl>
                <form action="options.php" method="POST">
                    <?php settings_fields( 'altss_uninstall_options' ); ?>
                    <dl class="site-settings-specialized-dl">
                        <dt><span><?php esc_html_e( "Removing the plugin", "alternative-site-settings" ); ?></span></dt>
                        <dd>
                            <p style="margin-bottom: 20px;">
                                <?php esc_html_e( "When you remove this plugin, what do you want to do with the settings, data, and custom posts you create using this plugin?", "alternative-site-settings" ); ?>
                            </p>
                            <div class="altss-customize-control-radio">
                                <label><input type="radio" name="altss_uninstall_data_enable" value="false"<?php checked( $altss_uninstall_enable, "false" ); ?>> <span><?php esc_html_e( 'Save all data', 'alternative-site-settings' ); ?></span></label>
                                <label><input type="radio" class="darkred-radio" name="altss_uninstall_data_enable" value="true"<?php checked( $altss_uninstall_enable, "true" ); ?>> <span><?php esc_html_e( 'Selective data deletion', 'alternative-site-settings' ); ?></span></label>
                            </div>
                            <dl id="data-items-area" <?php echo ( 'true' !== $altss_uninstall_enable ? 'style="display: none;"' : "" ); ?>>
                                <dd style="border-left: 2px solid #ddd; padding-left: 10px;">
                                    <?php 
                                    altss_add_onoff_switch( 'altss_uninstall_data_items[main_settings]', 1, $altss_uninstall_items['main_settings'] ?? '', __( "Delete all Main settings", "alternative-site-settings" ), '', 'darkred-oos' );
                                    altss_add_onoff_switch( 'altss_uninstall_data_items[ctype_settings]', 1, $altss_uninstall_items['ctype_settings'] ?? '', __( "Delete all Custom type posts settings", "alternative-site-settings" ), '', 'darkred-oos' );
                                    altss_add_onoff_switch( 'altss_uninstall_data_items[text_blocks]', 1, $altss_uninstall_items['text_blocks'] ?? '', __( "Delete all text block data", "alternative-site-settings" ), '', 'darkred-oos' );
                                    altss_add_onoff_switch( 'altss_uninstall_data_items[cookie_banner]', 1, $altss_uninstall_items['cookie_banner'] ?? '', __( "Delete all Cookie Banner settings", "alternative-site-settings" ), '', 'darkred-oos' );
                                    echo "\n<br>\n";
                                    altss_add_onoff_switch( 'altss_uninstall_data_items[cforms]', 1, $altss_uninstall_items['cforms'] ?? '', __( "Delete all contact form data and settings", "alternative-site-settings" ), '', 'darkred-oos' );
                                    altss_add_onoff_switch( 'altss_uninstall_data_items[reviews]', 1, $altss_uninstall_items['reviews'] ?? '', __( "Delete all data containing reviews left", "alternative-site-settings" ), '', 'darkred-oos' );
                                    echo "\n<br>\n";
                                    foreach ( $POST_TYPES as $type => $data ) {
                                        if( key_exists( $type, $CUSTOM_TYPES ) ) continue;
                                        $post_type_obj = get_post_type_object( $type );
                                        $type_mark = ' ( ' . $post_type_obj->labels->name . ' )';
                                        altss_add_onoff_switch( 'altss_uninstall_data_items[admin_tags][' . $type . ']', 1, $altss_uninstall_items['admin_tags'][$type] ?? '', __( "Delete Admin Tags for a post type", "alternative-site-settings" ) . ' «' . $type . $type_mark . '»', '', 'darkred-oos' );
                                    } 
                                    echo "\n<br>\n";
                                    foreach ( $CUSTOM_TYPES as $key => $rec_data ) {
                                        altss_add_onoff_switch( 'altss_uninstall_data_items[custom_type_' . $key . ']', 1, $altss_uninstall_items['custom_type_' . $key] ?? '', __( "Delete all custom posts of type", "alternative-site-settings" ) . ' «' . $rec_data['label'] . '»', '', 'darkred-oos' );
                                    } 
                                    ?>
                                </dd>
                            </dl>
                        </dd>
                    </dl>
            <?php
                submit_button();
            ?>
                </form>
            </div>
        </div>
    </div>
</div>
    <?php
}