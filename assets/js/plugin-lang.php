<?php

$strings = 'tinyMCE.addI18n({' . _WP_Editors::$mce_locale . ':{
    stag:{
        insert: "' . esc_js( __( 'Insert Stag Shortcode', 'stag' ) ) . '",
        button: "' . esc_js( __( 'Buttons', 'stag' ) ) . '",
        columns: "' . esc_js( __( 'Columns', 'stag' ) ) . '",
        tabs: "' . esc_js( __( 'Tabs', 'stag' ) ) . '",
        toggle: "' . esc_js( __( 'Toggle', 'stag' ) ) . '",
        dropcap: "' . esc_js( __( 'Dropcap', 'stag' ) ) . '",
        icon: "' . esc_js( __( 'Font Icon', 'stag' ) ) . '",

        media_elements: "' . esc_js( __( 'Media Elements', 'stag' ) ) . '",
        widget_area: "' . esc_js( __( 'Widget Area', 'stag' ) ) . '",
        image: "' . esc_js( __( 'Image', 'stag' ) ) . '",
        video: "' . esc_js( __( 'Video', 'stag' ) ) . '",
        map: "' . esc_js( __( 'Google Map', 'stag' ) ) . '",
    }
}})';
