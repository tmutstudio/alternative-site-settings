<?php
/**
 * Admin View: Quick Edit Service
 *
 * @var string $adm_tag 
 * @var string $public_tag 
 * @var string $cat_type 
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="tag-cat-bulk-action-extra-area-over">
    <div>
        <div class="tag-cat-bulk-action-extra-area">
            <div class="popup__close" style="margin: 0; width: 24px; height: 24px; border-radius: 6px;">
                <button type="button" class="popup-close-button" aria-label="<?php esc_attr_e( "Close dialog", "alternative-site-settings" ); ?>" style="padding: 4px;">
                    <svg role="presentation" class="popup__close-icon" width="16px" height="16px" viewBox="0 0 23 23"
                        version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g stroke="none" stroke-width="1" fill="#fff" fill-rule="evenodd">
                            <rect
                                transform="translate(11.313708, 11.313708) rotate(-45.000000) translate(-11.313708, -11.313708)"
                                x="10.3137085" y="-3.6862915" width="3" height="30"></rect>
                            <rect
                                transform="translate(11.313708, 11.313708) rotate(-315.000000) translate(-11.313708, -11.313708)"
                                x="10.3137085" y="-3.6862915" width="3" height="30"></rect>
                        </g>
                    </svg>
                </button>
            </div>
            <div class="tag-bulk-action-fields-over">
                <p>
                    <label class="">
                        <input type="radio" name="tag_type" class="tag-type" value="<?php echo esc_attr( $adm_tag ); ?>" checked>
                        - <?php esc_html_e( 'Admin tags', 'alternative-site-settings' ); ?>
                    </label>
                </p>
                <p>
                    <label class="">
                        <input type="radio" name="tag_type" class="tag-type" value="<?php echo esc_attr( $public_tag ); ?>">
                        - <?php esc_html_e( 'Public tags', 'alternative-site-settings' ); ?>
                    </label>
                </p>
                <p>
                    <label class="">
                        <?php esc_html_e( 'tags, separated by commas', 'alternative-site-settings' ); ?>:<br />
                        <textarea name="tag_names" class="eba-input-tags"></textarea>
                    </label>
                </p>
            </div>
            <div class="cat-bulk-action-fields-over">
                <div class="cat-bulk-action-area" style="margin: 0;"></div>
                <button id="bulk-action-categories-list" type="button" class="button-link"><?php esc_html_e( 'List of all categories', 'alternative-site-settings' ); ?></button>
                <input type="hidden" id="bulk_cat_ids" name="bulk_cat_ids" value="" />
                <input type="hidden" name="cat_type" value="<?php echo esc_attr( $cat_type ); ?>" />
            </div>
            <div class="cat-bulk-action-btn-over">
                <?php submit_button( esc_html__( 'Apply' ), 'action', 'bulk_action', false, [ 'id' => "doaction3" ] ); ?>
            </div>
        </div>
    </div>
    <div class="square-arrow-far"></div>
    <div class="square-arrow-near"></div>
</div>
