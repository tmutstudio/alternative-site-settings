

jQuery(document).ready(function($) {
    $( 'input[name="s_settings_options[geo_map][platform]"]' ).click(function(){
        if( 'googlemaps' === $(this).val() ){
            $( '.placemark-name' ).hide();
        }
        else {
            $( '.placemark-name' ).show();
        }
    });
});
