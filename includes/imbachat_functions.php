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

function ic_create_group_with($atts, $content = null, $code = '') {
    if ( is_feed() ) {
        return '[ic_create_group]';
    }

    if ( 'ic_create_group' == $code ) {
        $atts = shortcode_atts(
            array(
                'users' => [],
                'classi' => '',
                'classb' => '',
                'buttonname' => ''
            ),
            $atts, 'ic'
        );
        $classNameI = $atts['classi'];
        $classNameB = $atts['classb'];
        $btnName = $atts['buttonname'];
    }
    require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
    return '<div id="ic_create_group_cont">
            <input class="'.$classNameI.'" placeholder="Название группы" type="text" id="ic_group_title">
            <input class="'.$classNameI.'" placeholder="Pipe" type="text" id="ic_group_pipe">
            <button class="'.$classNameB.'" onclick="ic_create_dialog(this)">'.$btnName.'</button>
    </div>';
}

function ic_join_group($atts, $content = null, $code = '') {
    if ( is_feed() ) {
        return '[ic_join_group]';
    }

    if ( 'ic_join_group' == $code ) {
        $atts = shortcode_atts(
            array(
                'users' => [],
                'classb' => '',
                'buttonname' => '',
                'pipe' => '',
                'id' => '',
            ),
            $atts, 'ic'
        );
        $classNameB = $atts['classb'];
        $btnName = $atts['buttonname'];
    }
    require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
    return '<button class="'.$classNameB.'" onclick="ic_join_group(`'.$atts['pipe'].'`)">'.$btnName.'</button></div>';
}
