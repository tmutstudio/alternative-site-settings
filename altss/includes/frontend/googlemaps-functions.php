<?php

function altss_googlemaps_show( $atts ){
    global $maps_count;

    if( ! isset( $maps_count ) ) $maps_count = 0;
    else $maps_count++;

    if( !empty( $atts['coordinates'] ) && empty( $atts['center'] ) ){
        $atts['center'] = $atts['coordinates'];
    }
    elseif( !empty( $atts['center'] ) && empty( $atts['coordinates'] ) ){
        $atts['coordinates'] = $atts['center'];
    }
    elseif( empty( $atts['center'] ) && empty( $atts['coordinates'] ) ){
        $atts['coordinates'] = $atts['center'] = '40.72079337286899, -73.99891868435327';
    }


    extract( shortcode_atts(array(
        "align" => 'left',
        "height" => '420',
        "coordinates" => '',
        "center" => '',
        "info_window" => 'addr',
        "zoom" => '10',
        "companycode" => '',
        "maptype" => 'm',
        "title" => ''
        ), $atts) );

	$query_string = 'q=' . rawurlencode($coordinates) . '&cid=' . rawurlencode($companycode) . '&t=' . rawurlencode($maptype) . '&center=' . rawurlencode($center). '&saddr=' . rawurlencode($coordinates);
    return '<div id="goggle-map-' . esc_attr( $maps_count ) . '" class="altss-geo-map" style="overflow: hidden;">
        <iframe align="'.esc_html($align).'" width="100%" height="'.esc_html($height).'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
        src="https://maps.google.com/maps?&'.htmlentities($query_string).'&output=embed&z='.esc_html($zoom).'&iwloc='.esc_html($info_window).'&visual_refresh=true">
        </iframe>
    </div>';

}

function altss_googlemaps_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
    "align" => 'left',
    "height" => '380',
    "coordinates" => '',
	"info_window" => 'A',
	"zoom" => '14',
	"companycode" => '',
	"maptype" => 'm'
    ), $atts);

    return altss_googlemaps_show( $atts );
}
add_shortcode("altss_geo_map", "altss_googlemaps_shortcode");

function altss_googlemaps_shortcode_custom($atts, $content = null) {

    return altss_googlemaps_show( $atts );
}
add_shortcode("altss_geo_map_custom", "altss_googlemaps_shortcode_custom");


function altss_the_map() {
    global $settings_options;
    if( isset( $settings_options['geo_map']['platform'] ) ){
        $o = $settings_options['geo_map'];
        echo altss_googlemaps_show( 
            [
                "align" => 'left',
                "height" => '420',
                "coordinates" => @$o['coordinates'],
                "title" => @$o['placemark_name'],
                "info_window" => 'A',
                "zoom" => !empty( @$o['zoom_map_option'] ) ? $o['zoom_map_option'] : '14',
                "companycode" => '',
                "maptype" => 'm'
            ]);
    }
}



	
?>