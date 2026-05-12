<?php

/**
* Uninstall Alternative Site Settings.
*
* Remove:
* - altss_cform_sendings table
* - altss_cform_sendings_fields table
* - altss_reviews table
* - Alternative Site Settings settings/options
*
*/

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $altss_uninstall_data_items;

$altss_uninstall_data_enable = 'true' === get_option( 'altss_uninstall_data_enable' );
$altss_uninstall_data_items = get_option( 'altss_uninstall_data_items' );

if (
    ! $altss_uninstall_data_enable ||
    empty( $altss_uninstall_data_items ) ||
    is_plugin_active( 'altss/altss.php' )
) {
    return;
}

function altss_is_removable_option( $option ) {
    global $altss_uninstall_data_items;
    $ctype_settings_options = [ 'altss_settings_options_custom_recs', 'altss_settings_options_custom_recs_settings' ];

    if ( $option === 'altss_settings_options' && empty( $altss_uninstall_data_items[ 'main_settings' ] ) ) {
        return false;
    } elseif ( in_array( $option, $ctype_settings_options ) && empty( $altss_uninstall_data_items[ 'ctype_settings' ] ) ) {
        return false;
    } elseif ( str_contains( $option, 'altss_settings_options_embedded_text_' ) && empty( $altss_uninstall_data_items[ 'text_blocks' ] ) ) {
        return false;
    } elseif ( $option === 'altss_settings_options_cookie_banner_settings' && empty( $altss_uninstall_data_items[ 'cookie_banner' ] ) ) {
        return false;
    } elseif ( str_contains( $option, 'altss_settings_cforms_' ) && empty( $altss_uninstall_data_items[ 'cforms' ] ) ) {
        return false;
    } else {
        return true;
    }
}

function altss__delete_custom_options( $db_prefix = 'wp_' ) {
    global $wpdb, $altss_uninstall_data_items;

    // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery
    $all_options = $wpdb->get_results( "SELECT option_name FROM {$db_prefix}options WHERE option_name LIKE 'altss_%'" );

    foreach ( $all_options as $option ) {
        if ( ! altss_is_removable_option( $option->option_name ) ) {
            continue;
        }
        delete_option( $option->option_name );
    }
}

function altss__drop_custom_tables( $db_prefix = 'wp_' ) {
    global $wpdb, $altss_uninstall_data_items;

    if ( ! empty( $altss_uninstall_data_items[ 'cforms' ] ) ) {
        $wpdb->query( 'DROP TABLE IF EXISTS ' . $db_prefix . 'altss_cform_sendings' );
        $wpdb->query( 'DROP TABLE IF EXISTS ' . $db_prefix . 'altss_cform_sendings_fields' );
    }

    if ( ! empty( $altss_uninstall_data_items[ 'reviews' ] ) ) {
        $wpdb->query( 'DROP TABLE IF EXISTS ' . $db_prefix . 'altss_reviews table' );
    }
}

function altss__delete_custom_posts() {
    global $wpdb, $altss_uninstall_data_items;

    include dirname( realpath( __FILE__ ) ) . '/includes/data-vars/custom-type-vars.php';
    $post_types = [];
    $taxonomies = [];
    foreach ( $CUSTOM_TYPES as $key => $rec_data ) {
        if ( empty( $altss_uninstall_data_items[ 'custom_type_' . $key ] ) ) {
            continue;
        }
        $post_types[] = $key;
    }

    if ( ! empty( $post_types ) ) {

        foreach ( $post_types as $type ) {
            $taxonomies[] = "{$type}_cat";
            $taxonomies[] = "{$type}_tag";
            $taxonomies[] = "adm_{$type}_tag";
        }

        $args = [
            'fields'         => 'ids',
            'post_type'      => $post_types,
            'post_status'    => 'any',
            'posts_per_page' => -1,
        ];
        $post_ids = get_posts( $args );

        foreach ( $post_ids as $post_id ) {
            wp_delete_post( $post_id, true );
            wp_cache_delete( $post_id );
        }
    }

    if ( ! empty( $altss_uninstall_data_items[ 'admin_post_tags' ] ) ) {
        $taxonomies[] = 'adm_post_tag';
    }

    if ( ! empty( $taxonomies ) ) {
        $placeholders = implode( ', ', array_fill( 0, count( $taxonomies ), '%s' ) );

        $wpdb->query( $wpdb->prepare(
            "DELETE tr FROM {$wpdb->term_relationships} tr
            INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            WHERE tt.taxonomy IN ({$placeholders})",
            $taxonomies
        ) );

        $term_ids = $wpdb->get_col( $wpdb->prepare(
            "SELECT term_id FROM {$wpdb->term_taxonomy} WHERE taxonomy IN ({$placeholders})",
            $taxonomies
        ) );

        if ( ! empty( $term_ids ) ) {
            $term_ids_placeholders = implode( ', ', array_fill( 0, count( $term_ids ), '%d' ) );

            $wpdb->query( $wpdb->prepare(
                "DELETE FROM {$wpdb->termmeta} WHERE term_id IN ({$term_ids_placeholders})",
                $term_ids
            ) );

            $wpdb->query( $wpdb->prepare(
                "DELETE FROM {$wpdb->term_taxonomy} WHERE taxonomy IN ({$placeholders})",
                $taxonomies
            ) );

            $wpdb->query( $wpdb->prepare(
                "DELETE FROM {$wpdb->terms} WHERE term_id IN ({$term_ids_placeholders})",
                $term_ids
            ) );
        }
    }
}

if ( function_exists( 'is_multisite' ) && is_multisite() ) {
    global $wpdb;
    $sites = get_sites();
    foreach ( $sites as $site ) {
        $blog_id_for_switch = $site->blog_id;
        $db_prefix          = $wpdb->get_blog_prefix( $blog_id_for_switch );
        switch_to_blog( $blog_id_for_switch );
        altss__delete_custom_posts();
        restore_current_blog();
        altss__delete_custom_options( $db_prefix );
        altss__drop_custom_tables( $db_prefix );
    }
} else {
    global $wpdb;
    altss__delete_custom_options( $wpdb->prefix );
    altss__drop_custom_tables( $wpdb->prefix );
    altss__delete_custom_posts();
}
