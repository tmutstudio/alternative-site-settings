

jQuery(document).ready(function($) {
    $( 'input[name="altss_settings_options[map_display_type]"]' ).click(function(){
        if( 'shortcode' === $(this).val() ){
            $( '.map-shortcode-field' ).show();
            $( '.map-static-image' ).hide();
        }
        else {
            $( '.map-shortcode-field' ).hide();
            $( '.map-static-image' ).show();
        }
    });
});
