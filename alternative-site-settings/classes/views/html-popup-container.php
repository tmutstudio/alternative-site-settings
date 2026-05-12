<?php
/**
 * Catalog settings popup container template.
 *
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="popup-show-bg" id="popup_show_bg">
    <div class="popup-container">
        <div class="popup__close">
            <button type="button" class="popup-close-button" aria-label="<?php esc_attr_e( "Close dialog", "transport-service-catalog" ); ?>">
                <svg role="presentation" class="popup__close-icon" width="23px" height="23px" viewBox="0 0 23 23"
                    version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke="none" stroke-width="1" fill="#fff" fill-rule="evenodd">
                        <rect
                            transform="translate(11.313708, 11.313708) rotate(-45.000000) translate(-11.313708, -11.313708)"
                            x="10.3137085" y="-3.6862915" width="2" height="30"></rect>
                        <rect
                            transform="translate(11.313708, 11.313708) rotate(-315.000000) translate(-11.313708, -11.313708)"
                            x="10.3137085" y="-3.6862915" width="2" height="30"></rect>
                    </g>
                </svg>
            </button>
        </div>
        <div id="popup-form-wrapper">
        </div>
    </div>
</div>
