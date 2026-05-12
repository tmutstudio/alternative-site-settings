<?php
defined( 'ABSPATH' ) || exit;

$FORM_FIELDS = [
    'email' => [
        'type' => 'email',
        'label' => esc_html__( "Email address", "alternative-site-settings" ),
        'placeholder' => esc_html__( "Enter your email address", "alternative-site-settings" )
    ],
    'phone' => [
        'type' => 'text',
        'label' =>__( "Phone number", "alternative-site-settings" ),
        'placeholder' => esc_html__( "Enter your phone number", "alternative-site-settings" )
    ],
    'fname' => [
        'type' => 'text',
        'label' => esc_html__( "First Name", "alternative-site-settings" ),
        'placeholder' => esc_html__( "Enter your First Name", "alternative-site-settings" )
    ],
    'sname' => [
        'type' => 'text',
        'label' => esc_html__( "Last Name", "alternative-site-settings" ),
        'placeholder' => esc_html__( "Enter your Last Name", "alternative-site-settings" )
    ],
    'city' => [
        'type' => 'text',
        'label' => esc_html__( "City", "alternative-site-settings" ),
        'placeholder' => esc_html__( "Enter your city", "alternative-site-settings" )
    ],
    'website' => [
        'type' => 'url',
        'label' => esc_html__( "Website URL", "alternative-site-settings" ),
        'placeholder' => esc_html__( "Enter your Website URL", "alternative-site-settings" )
    ],
    'message' => [
        'type' => 'textarea',
        'label' => esc_html__( "Message text", "alternative-site-settings" ),
        'placeholder' => esc_html__( "Enter the text of your message", "alternative-site-settings" )
    ],
];
?>