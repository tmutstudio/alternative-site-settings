<?php
                        settings_fields( 's_settings_options' );
                        altss_include_uploadscript();
                        $s_settings_options = get_option( "s_settings_options" );

                        ?>
                        <div class="site-settings-tab-header-div"><?php esc_html_e( "Main site settings:", "altss" ); ?></div>
                        <div class="site-settings-options-gr-wrap">
                            <p class="site-settings-options-gr-title"><?php esc_html_e( "Info for the HEADER section:", "altss" ); ?></p>
                            <dl>
                                <dt><p><?php echo esc_html__( "Site Title" ); ?>:</p></dt>
                                <dd>
                                    <p>
                                        <input type="text" name="blogname" size="45" value="<?php echo esc_attr( get_option( "blogname" ) ); ?>">
                                    </p>
                                </dd>
                                <dt><p><?php echo esc_html__( "Tagline" ); ?>:</p></dt>
                                <dd>
                                    <p>
                                        <textarea name="blogdescription" size="45" rows="1"><?php echo esc_textarea( get_option( "blogdescription" ) ); ?></textarea>
                                    </p>
                                </dd>
                                <dt><p><?php esc_html_e( "Alternative Site Title:", "altss" ); ?></p></dt>
                                <dd>
                                    <p>
                                        <input type="text" name="s_settings_options[alt_blogname]" size="45" value="<?php echo esc_attr( @$s_settings_options['alt_blogname'] ); ?>">
                                    </p>
                                </dd>
                                <dt><p><?php esc_html_e( "Additional field for the HEADER section:", "altss" ); ?></p></dt>
                                <dd>
                                    <p>
                                        <input type="text" name="s_settings_options[opt_header_text]" size="45" value="<?php echo esc_attr( @$s_settings_options['opt_header_text'] ); ?>">
                                    </p>
                                </dd>
                                <dt><p><?php esc_html_e( "Additional text for HEADER", "altss" ); ?>:</p></dt>
                                <dd style="max-width: 500px">
                                        <?php altss_add_editior_field( "s_settings_options[opt_header_textarea]", esc_textarea( @$s_settings_options['opt_header_textarea'] ), 4, 'novisual'); ?>
                                </dd>
                                <dt><p><?php esc_html_e( "Button name for HEADER on the home page", "altss" ); ?>:</p></dt>
                                <dd>
                                    <p>
                                        <input type="text" name="s_settings_options[header_btn_text]" size="45" value="<?php echo esc_attr( @$s_settings_options['header_btn_text'] ); ?>">
                                    </p>
                                </dd>
                                <dt><p><?php esc_html_e( "Form for a button in the HEADER on the home page", "altss" ); ?>:</p></dt>
                                <dd>
                                    <select name="s_settings_options[header_form_id]">
                                        <option value="0"><?php esc_html_e( "Select form", "altss" ); ?></option>
                                    <?php foreach ( $form_title_ar as $key => $value ) {
                                        ?>
                                        <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $key, @$s_settings_options['header_form_id'] ); ?>><?php echo esc_html__( "form", "altss" ) . ": # " . esc_attr( $key ) . " - «" . esc_html( $value ) . "»"; ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </dd>
                            </dl>
                            <p class="section-hint">
                                <?php echo wp_kses( __( "To display additional fields in the “HEADER” section of the frontend, use the <strong>altss_header_option_field( 'opt_header_text' )</strong> or <strong>altss_header_option_field( 'alt_blogname' )</strong> function.", "altss" ),
                                [ 'strong' => [] ] ); ?>
                            </p>
                        </div>
                        <div class="site-settings-options-gr-wrap">
                            <p class="site-settings-options-gr-title"><?php esc_html_e( "Additionally:", "altss" ); ?></p>
                            <dl>
                                <dt><p><?php esc_html_e( "Blog Title", "altss" ); ?>:</p></dt>
                                <dd>
                                    <p>
                                        <input type="text" name="s_settings_options[blog_title]" size="45" value="<?php echo esc_attr( @$s_settings_options['blog_title'] ); ?>">
                                    </p>
                                </dd>
                                <dt><p><?php esc_html_e( "Additional text for FOOTER", "altss" ); ?>:</p></dt>
                                <dd style="max-width: 500px">
                                        <?php altss_add_editior_field( "s_settings_options[footer_textarea]", esc_textarea( @$s_settings_options['footer_textarea'] ), 4, 'novisual'); ?>
                                </dd>
                                <dt><p><?php esc_html_e( "Text for the button in the footer of the site", "altss" ); ?>:</p></dt>
                                <dd>
                                    <p>
                                        <input type="text" name="s_settings_options[footer_btn_text]" size="45" value="<?php echo esc_attr( @$s_settings_options['footer_btn_text'] ); ?>">
                                    </p>
                                </dd>
                                <dt><p><?php esc_html_e( "Form for a button in the FOOTER of the site", "altss" ); ?>:</p></dt>
                                <dd>
                                    <select name="s_settings_options[footer_form_id]">
                                        <option value="0"><?php esc_html_e( "Select form", "altss" ); ?></option>
                                    <?php foreach ( $form_title_ar as $key => $value ) {
                                        ?>
                                        <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $key, @$s_settings_options['footer_form_id'] ); ?>><?php echo esc_html__( "form", "altss" ) . ": # " . esc_attr( $key ) . " - «" . esc_attr( $value ) . "»"; ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </dd>
                            </dl>
                        </div>
                        <?php
                            submit_button();
                        ?>
                            <div class="site-settings-options-gr-wrap">
                            <p class="site-settings-options-gr-title"><?php esc_html_e( "Contact details", "altss" ); ?>:</p>
                            <dl>
                                <dt><p><?php esc_html_e( "Contact block title:", "altss" ); ?></p></dt>
                                <dd>
                                    <input name="s_settings_options[contacts][contacts_title]" type="text" value="<?php echo esc_attr( @$s_settings_options['contacts']['contacts_title'] ); ?>">
                                </dd>
                                <dt><p><?php esc_html_e( "Address", "altss" ); ?>:</p></dt>
                                <dd style="max-width: 500px">
                                    <?php altss_add_editior_field( "s_settings_options[contacts][contacts_location]", esc_textarea( @$s_settings_options['contacts']['contacts_location'] ), 5, 'novisual'  ); ?>
                                </dd>
                                <dt><p><?php esc_html_e( 'Phone number in the site header:', 'altss' ); ?></p></dt>
                                <dd>
                                    <p>
                                        <input type="text" name="s_settings_options[header_phone]" size="45" value="<?php echo esc_attr( @$s_settings_options['header_phone'] ); ?>">
                                    </p>
                                </dd>
                                <dt><p><?php esc_html_e( 'Phone number in the site footer:', 'altss' ); ?></p></dt>
                                <dd>
                                    <p class="section-hint"><?php esc_html_e( 'Perhaps several separated by «;»', 'altss' ); ?><br><?php esc_html_e( "If left blank, the phone number will be substituted for the site header.", "altss" ); ?></p>
                                    <input type="text" name="s_settings_options[footer_phone]" size="45" value="<?php echo esc_attr( @$s_settings_options['footer_phone'] ); ?>">
                                </dd>
                                <dt><p><?php esc_html_e( 'Phone number for contact block:', 'altss' ); ?></p></dt>
                                <dd>
                                    <p class="section-hint"><?php esc_html_e( 'Perhaps several separated by «;»', 'altss' ); ?><br><?php esc_html_e( "If left blank, the phone number will be substituted for the site header.", "altss" ); ?></p>
                                    <input name="s_settings_options[contacts][contacts_phone]" type="text" value="<?php echo esc_attr( @$s_settings_options['contacts']['contacts_phone'] ); ?>">
                                </dd>
                                <dt><p>Whatsapp:</p></dt>
                                <dd>
                                    <p class="section-hint"><?php esc_html_e( 'Perhaps several separated by «;»', 'altss' ); ?></p>
                                    <input name="s_settings_options[contacts][contacts_whatsapp]" type="text" value="<?php echo esc_attr( @$s_settings_options['contacts']['contacts_whatsapp'] ); ?>">
                                </dd>
                                <dt><p>Telegram:</p></dt>
                                <dd>
                                    <p class="section-hint"><?php esc_html_e( 'Perhaps several separated by «;»', 'altss' ); ?></p>
                                    <input name="s_settings_options[contacts][contacts_telegram]" type="text" value="<?php echo esc_attr( @$s_settings_options['contacts']['contacts_telegram'] ); ?>">
                                </dd>
                                <dt><p>Emali:</p></dt>
                                <dd>
                                    <input name="s_settings_options[contacts][contacts_email]" type="text" value="<?php echo esc_attr( @$s_settings_options['contacts']['contacts_email'] ); ?>">
                                </dd>
                            </dl>
                            </div>
                        <div class="site-settings-options-gr-wrap">
                            <p class="site-settings-options-gr-title"><?php esc_html_e( 'Data for displaying the map', 'altss' ); ?>:</p>
                            <dl>
                                <dt><p><?php esc_html_e( 'Maps Platform', 'altss' ); ?>:</p></dt>
                                <dd>
                                    <div class="customize-control-radio">
                                        <label><input type="radio" name="s_settings_options[geo_map][platform]" value="googlemaps"<?php checked( @$s_settings_options['geo_map']['platform'], "googlemaps" ); ?>> <span><?php esc_html_e( 'Google Maps', 'altss' ); ?></span></label>
                                        <label><input type="radio" name="s_settings_options[geo_map][platform]" value="yandexmaps"<?php checked( @$s_settings_options['geo_map']['platform'], "yandexmaps" ); ?>> <span><?php esc_html_e( 'Yandex Maps', 'altss' ); ?></span></label>
                                    </div>
                                </dd>
                                <dt><p><?php esc_html_e( 'Location coordinates (Location Pin)', 'altss' ); ?>:</p></dt>
                                <dd>
                                    <p>
                                        <input name="s_settings_options[geo_map][coordinates]" type="text" value="<?php echo esc_attr( @$s_settings_options['geo_map']['coordinates'] ); ?>" style="width: 200px">
                                    </p>
                                </dd>
                                <dt><p><?php esc_html_e( 'Center of the map (usually coincides with the coordinates of the marker)', 'altss' ); ?>:</p></dt>
                                <dd>
                                    <input name="s_settings_options[geo_map][center]" type="text" value="<?php echo esc_attr( @$s_settings_options['geo_map']['center'] ); ?>" style="width: 200px">
                                </dd>
                                <dt class="placemark-name" <?php echo ( 'googlemaps' === @$s_settings_options['geo_map']['platform'] ? 'style="display: none;"' : "" ); ?>><p><?php esc_html_e( 'Place marker name', 'altss' ); ?>:</p></dt>
                                <dd class="placemark-name" <?php echo ( 'googlemaps' === @$s_settings_options['geo_map']['platform'] ? 'style="display: none;"' : "" ); ?>>
                                    <input name="s_settings_options[geo_map][placemark_name]" type="text" value="<?php echo esc_attr( @$s_settings_options['geo_map']['placemark_name'] ); ?>" class="code2">
                                </dd>
                                <dt><p><?php esc_html_e( 'Zoom', 'altss' ); ?>:</p></dt>
                                <dd>
                                    <input name="s_settings_options[geo_map][zoom_map_option]" type="number" size="2" min="10" max="30" value="<?php echo esc_attr( @$s_settings_options['geo_map']['zoom_map_option'] ); ?>" class="code2">
                                </dd>
                            </dl>
                        </div>
                        <?php
                            submit_button();
                        ?>
                        <div class="site-settings-options-gr-wrap">
                            <p class="site-settings-options-gr-title"><?php esc_html_e( 'Meta & SEO', 'altss' ); ?>:</p>
                            <?php
                            ?>
                            <dl>
                                <dt><p><?php esc_html_e( 'Meta Tag «Title» for the home page', 'altss' ); ?>:</p></dt>
                                <dd>
                                    <p>
                                        <input type="text" name="s_settings_options[home_title]" size="45" value="<?php echo esc_attr( @$s_settings_options['home_title'] ); ?>">
                                    </p>
                                </dd>
                                <dt><p><?php esc_html_e( 'Meta Tag «Description» for the home page', 'altss' ); ?>:</p></dt>
                                <dd>
                                    <p>
                                        <textarea name="s_settings_options[home_desc]" rows="3" cols="110"><?php echo esc_textarea( @$s_settings_options['home_desc'] ); ?></textarea>
                                    </p>
                                </dd>
                                <dt><?php esc_html_e( 'og:image', 'altss' ); ?></dt>
                                <dd>
                                    <p><?php esc_html_e( 'Optimal resolution 600x315 pixels', 'altss' ); ?></p>
                                    <?php 
                                        altss_image_uploader_field( 's_settings_options[meta_ogimage]', esc_url( @$s_settings_options['meta_ogimage'] ) );
                                    ?>
                                </dd>
                            </dl>
                        </div>
                        <div class="site-settings-options-gr-wrap">
                            <p class="site-settings-options-gr-title"><?php esc_html_e( 'Copyright in the footer', 'altss' ); ?>:</p>
                            <?php
                            $copyright_info = get_option( 'copyright_info' );
                            ?>
                            <dl>
                                    <dd>
                                        <p>
                                            <input name="copyright_info[start_year]" type="number" size="4" min="1990" max="2099" value="<?php echo esc_attr( @$copyright_info['start_year'] ); ?>"> - 
                                            <label><?php esc_html_e( 'Year, start of activity', 'altss' ); ?></label>
                                        </p>
                                        <p>
                                            <input name="copyright_info[holder_text]" type="text" value="<?php echo esc_attr( @$copyright_info['holder_text'] ); ?>"> - 
                                            <label><?php esc_html_e( 'Copyright holder name', 'altss' ); ?></label>
                                        </p>
                                        <p>
                                            <input name="copyright_info[optional_text]" type="text" value="<?php echo esc_attr( @$copyright_info['optional_text'] ); ?>"> - 
                                            <label><?php esc_html_e( 'Additional text (if necessary)', 'altss' ); ?></label>
                                        </p>
                                    </dd>
                            </dl>
                        </div>
                        <?php
                            submit_button();
                        ?>
    