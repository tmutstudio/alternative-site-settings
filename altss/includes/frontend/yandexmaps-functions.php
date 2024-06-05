<?php

function altss_YandexMapAPI_script($noFooter = false) {  
    global $post;
    $maplocale = get_locale();
    if (strlen($maplocale)<5) $maplocale = "en_US";

    if ($noFooter) {
        return 'https://api-maps.yandex.ru/2.1/?lang='.esc_html($maplocale);
    }
    else {
        if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'altss_yamap') ) {
            // Register the script like this for a plugin:  
            wp_register_script( 'YandexMapAPI', 'https://api-maps.yandex.ru/2.1/?lang='.esc_html($maplocale), [], 2.1, true );  

            // For either a plugin or a theme, you can then enqueue the script:  
            wp_enqueue_script( 'YandexMapAPI' ); 
        }    
    }
     
}


function altss_yaplacemark_func($atts) {
	$atts = shortcode_atts( array(
		'coordinates' => '',
		'name' => '',
		'color' => 'blue',
		'url' => '',
		'icon' => 'islands#dotIcon',
	), $atts );

	global $yaplacemark_count, $maps_count;
	$yaplacemark_count++;
	$yahint="";
	$yacontent="";
	$yaicon=trim(esc_html($atts["icon"]));


	if (strstr($yaicon, "Stretchy")<>FALSE) {
		$yahint="";
		$yacontent=sanitize_text_field($atts["name"]);
		}
	else {
			if (($yaicon==="islands#blueIcon")or($yaicon==="islands#blueCircleIcon")) {
				$yahint=esc_html($atts["name"]);
				$yacontent=esc_html(mb_substr($yahint, 0, 1));
			}
			else {
				$yahint=esc_html($atts["name"]);
				$yacontent="";
			}
	}
	
	
	$yaplacemark='
		YaMapsWP.myMap'.esc_attr($maps_count).'.places.placemark'.$yaplacemark_count.' = {icon: "'.esc_js($atts["icon"]).'", name: "'.esc_js($atts["name"]).'", color: "'.esc_js($atts["color"]).'", coord: "'.esc_js($atts["coordinates"]).'", url: "'.esc_url($atts["url"]).'",};
		myMap'.esc_attr($maps_count).'placemark'.$yaplacemark_count.' = new ymaps.Placemark(['.$atts["coordinates"].'], {
                                hintContent: "'.esc_js($yahint).'",
                                iconContent: "'.esc_js($yacontent).'",


                              
                            }, {';
    $iconurl = strripos($atts["icon"], 'http');
    if (is_int($iconurl)) {
    	$yaplacemark.='                        
                            	iconLayout: "default#image",
        						iconImageHref: "'.esc_js($atts["icon"]).'"
                            });  
		';

    }
    else {
    	$yaplacemark.='                        
                            	preset: "'.esc_js($atts["icon"]).'", 
                            	iconColor: "'.esc_js($atts["color"]).'",
                            });  
		';
    }
    
	$atts["url"]=trim(esc_js($atts["url"]));
	if (($atts["url"]<>"")and($atts["url"]<>"0")) {
		$marklink=$atts["url"];
		settype($marklink, "integer");
		if ($marklink<>0) {
			$marklink=get_the_permalink(esc_js($atts["url"]));
			$yaplacemark.='YaMapsWP.myMap'.esc_attr($maps_count).'.places["placemark'.$yaplacemark_count.'"].url="'.$marklink.'"';
		}
		else {
			$marklink=$atts["url"];
		}
		$yaplacemark.=' 
				YMlisteners.myMap'.esc_attr($maps_count).'['.$yaplacemark_count.'] = myMap'.esc_attr($maps_count).'placemark'.$yaplacemark_count.'.events.group().add("click", function(e) {yamapsonclick("'.esc_url($marklink).'")});

		';
	}
	return $yaplacemark;
}



function altss_yamap_func($atts){
	global $yaplacemark_count, $maps_count, $count_content,  $yamap_onpage;

	$placearr = '';
    if( !empty( $atts['coordinates'] ) && empty( $atts['center'] ) ){
        $atts['center'] = $atts['coordinates'];
    }
    elseif( !empty( $atts['center'] ) && empty( $atts['coordinates'] ) ){
        $atts['coordinates'] = $atts['center'];
    }
    elseif( empty( $atts['center'] ) && empty( $atts['coordinates'] ) ){
        $atts['coordinates'] = $atts['center'] = '55.755864, 37.617698';
    }
	$atts = shortcode_atts( array(
		'center' => '55.755864, 37.617698',
		'zoom' => '12',
		'type' => 'yandex#map',
		'height' => '22rem',
		'controls' => "typeSelector;zoomControl;routeEditor;rulerControl;trafficControl;fullscreenControl;geolocationControl",
		'scrollzoom' => '1',
		'mobiledrag' => '1',
		'container' => '',
		'coordinates' => '',
		'name' => '',
		'color' => 'blue',
		'url' => '',
		'icon' => 'islands#dotIcon',
	), $atts );



    $p_attr = [
            'coordinates' => $atts['coordinates'],
            'name'  => $atts['name'],
            'color' => $atts['color'],
            'url'   => $atts['url'],
            'icon'  => $atts['icon'],
        ];

    if( ! isset( $maps_count ) ) $maps_count = 0;
    else $maps_count++;
    
	$yaplacemark_count=0;
	$yacontrol_count=0;
	$yamap_onpage=true;

	$yamactrl=str_replace(';', '", "', esc_js($atts["controls"]));

	if (trim($yamactrl)<>"") $yamactrl='"'.$yamactrl.'"';

    $yamap='
    <script>
        if (typeof(YaMapsWP) === "undefined") {
            var YaMapsWP = {}, YMlisteners = {};
            var YaMapsScript = document.createElement("script");	
            var YaMapsScriptCounter = [];					
        }
        var myMap'.esc_attr($maps_count).';			
    </script>';

	$placemarkscode=str_replace("&nbsp;", "", wp_strip_all_tags(altss_yaplacemark_func($p_attr)));

	$atts["container"]=trim($atts["container"]);
	if ($atts["container"]<>"") {
		$mapcontainter=esc_html($atts["container"]);
		$mapcontainter=str_replace("#", "", $mapcontainter);
	}
	else {
		$mapcontainter='yamap'.$maps_count;
	}	
	
	$suppressMapOpenBlock='false';

    $yamap.='
						<script type="text/javascript">										
						document.addEventListener("DOMContentLoaded", function() { 
						   if (document.getElementById("YandexMapAPI-js") == null ) {
					   			YaMapsScriptCounter.push(function() {ymaps.ready(init)});
						   		if (document.getElementById("YandexMapAPI-alt-js") == null ) { 
						   			function AltApiLoad(src){

									  YaMapsScript.id = "YandexMapAPI-alt-js";
									  YaMapsScript.src = src;
									  YaMapsScript.async = false;
									  document.head.appendChild(YaMapsScript);

									}

									AltApiLoad("'.altss_YandexMapAPI_script(true).'");

									window.onload = function() {
										YaMapsScriptCounter.forEach(function(entryFunc) {
										    entryFunc();
										});
									}
						   		}

						   		

						   } 
						   else {
						   		ymaps.ready(init); 
						   }
						   
	                 		
							YMlisteners.myMap'.esc_attr($maps_count).' = {};
							YaMapsWP.myMap'.esc_attr($maps_count).' = {center: "'.esc_js($atts["center"]).'", zoom: "'.esc_js($atts["zoom"]).'", type: "'.esc_js($atts["type"]).'", controls: "'.esc_js($atts["controls"]).'", places: {}};

	                 		var yamapsonclick = function (url) {
								location.href=url;
	                 		}                        

	                        function init () {
	                            myMap'.esc_attr($maps_count).' = new ymaps.Map("'.$mapcontainter.'", {
	                                    center: ['.sanitize_text_field($atts["center"]).'],
	                                    zoom: '.sanitize_text_field($atts["zoom"]).',
	                                    type: "'.sanitize_text_field($atts["type"]).'",
	                                    controls: ['.sanitize_text_field($yamactrl).'] ,
	                                    
	                                },
	                                {
	                                	suppressMapOpenBlock: '.esc_js($suppressMapOpenBlock).'
	                                }); 

								'.do_shortcode($placemarkscode);							
								
								for ($i = 1; $i <= $yaplacemark_count; $i++) {
									$placearr.='.add(myMap'.esc_attr($maps_count).'placemark'.$i.')';
								}
	                            $yamap.='myMap'.esc_attr($maps_count).'.geoObjects'.$placearr.';';
	                            if ($atts["scrollzoom"]=="0") $yamap.="myMap".$maps_count.".behaviors.disable('scrollZoom');";
	                            if ($atts["mobiledrag"]=="0") {
	                            	$yamap.="
	                            	if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
	                            		myMap".$maps_count.".behaviors.disable('drag');	
									}";
	                            }
	                            $yamap.='

	                        }
                        }, false);
                    </script>
                    
    ';
    if ($atts["container"]=="") $yamap.='<div id="'.esc_attr($mapcontainter).'"  style="position: relative; height: '.esc_attr($atts["height"]).'; margin-bottom: 0 !important;"></div>';

    return $yamap; 
}

function altss_yamap_shortcode(){
    global $settings_options;
    if( isset( $settings_options['geo_map']['platform'] ) ){
        $o = $settings_options['geo_map'];
        return altss_yamap_func( 
            [
                'center' => !empty( @$o['center'] ) ? $o['center'] : '55.755864, 37.617698',
                'controls' => "typeSelector;zoomControl;routeEditor;rulerControl;trafficControl;fullscreenControl;geolocationControl",
                'zoom' => !empty( @$o['zoom_map_option'] ) ? $o['zoom_map_option'] : '12',
                'type' => "yandex#map",
                'height' => '420px',
                'coordinates' => !empty( @$o['coordinates'] ) ? $o['coordinates'] : '55.755864, 37.617698',
                'color' => "#ff0505",
                'name' => @$o['placemark_name'],
            ]);
    }
}

add_shortcode("altss_geo_map", "altss_yamap_shortcode");


function altss_yamap_shortcode_custom( $atts ){
    return altss_yamap_func( $atts );
}

add_shortcode("altss_geo_map_custom", "altss_yamap_shortcode_custom");


function altss_the_map() {
    global $settings_options;
    if( isset( $settings_options['geo_map']['platform'] ) ){
        $o = $settings_options['geo_map'];
        echo altss_yamap_func( 
            [
                'center' => @$o['center'],
                'controls' => "typeSelector;zoomControl;routeEditor;rulerControl;trafficControl;fullscreenControl;geolocationControl",
                'zoom' => !empty( @$o['zoom_map_option'] ) ? $o['zoom_map_option'] : '12',
                'type' => "yandex#map",
                'height' => '420px',
                'coordinates' => @$o['coordinates'],
                'color' => "#ff0505",
                'name' => @$o['placemark_name'], 
            ]);
    }
}



