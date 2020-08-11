<?php

function ic_open_dialog_with( $atts, $content = null, $code = '' ) {

    if ( is_feed() ) {
        return '[ic_open_dialog]';
    }

    if ( 'ic_open_dialog' == $code ) {
        $atts = shortcode_atts(
            array(
                'id' => 0,
                'class' => ''
            ),
            $atts, 'ic'
        );

        $id = (int) $atts['id'];
        $className = $atts['class'];
    }
    require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
    return '<button class="'.$className.'" onclick="open_dialog('.$id.')">Chat</button>';
}

function ic_close_chat( $atts, $content = null, $code = '' ) {

    if ( is_feed() ) {
        return '[ic_close_chat]';
    }

    require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
    return '<button onclick="closeChat()">Close imbaChat</button>';
}

function ic_open_chat( $atts, $content = null, $code = '' ) {

    if ( is_feed() ) {
        return '[ic_open_chat]';
    }

    require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
    return '<button onclick="showChat()">Open ImbaChat</button>';
}
