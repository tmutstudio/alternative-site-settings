<?php
if ( ! defined( 'ABSPATH' ) ) exit;

settings_fields('altss_settings_cforms_options_' . $tab);
$additional_settings = get_option( 'altss_settings_cforms_additional_settings' ); 
?>

                    <div class="site-settings-template-wrapp">
                        <div class="site-settings-options-gr-wrap">
                            <p class="site-settings-options-gr-title"><?php esc_html_e( "Selecting fields for storing messages in the site database", "altss" ); ?>:</p>
                            <p style="color: red;">
                                <?php esc_html_e( "Due to strict personal data laws in many countries, contact information fields from submitted forms are NOT saved in the website database by default!", "altss" ); ?>
                            </p>
                            <p style="color: red;">
                                <?php esc_html_e( "You can select the required fields yourself, but remember that the website owner is fully responsible for the processing and security of personal data!", "altss" ); ?>
                            </p>
                            <p>
                                <?php esc_html_e( "If you do not select any fields, then only the form name, submission date, IP and User Agent of the sender and, of course, the unique ID will be written to the database.", "altss" ); ?>
                            </p>
                            <div class="cf-field-onoff-items-over">
                                <?php foreach ($FORM_FIELDS as $key => $val) { 
                                    $fieldsSettings = get_option("altss_settings_cforms_options_field_{$key}");
                                    ?>
                                <dl class="cf-field-onoff-item">
                                    <dt><?php esc_html_e( "Field", "altss" ); ?>: <strong><?php echo esc_attr( ! empty( $fieldsSettings['label'] ) ? $fieldsSettings['label'] : $val['label']);?></strong></dt>
                                    <dd>
                                        <?php altss_add_onoff_switch( 'altss_settings_cforms_additional_settings[allowed_fields][' . $key . ']', 1, $additional_settings['allowed_fields'][$key] ?? '', __( "By checking the box, you assume responsibility for the safety and confidentiality of the data in this field!", "altss" ) ); ?>
                                    </dd>    
                                </dl>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                            submit_button();
                        ?>
                    </div>
        