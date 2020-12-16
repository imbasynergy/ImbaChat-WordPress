<?php

function ic_open_dialog_with( $atts, $content = null, $code = '' ) {

    if ( is_feed() ) {
        return '[ic_open_dialog]';
    }
    if ( 'ic_open_dialog' == $code ) {
        $atts = shortcode_atts(
            array(
                'id' => 0,
                'class' => '',
                'name' => ''
            ),
            $atts, 'ic'
        );

        $id = (int) $atts['id'];
        $className = $atts['class'];
        $btnName = $atts['name'];
    }
    require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
    echo "<script>jQuery('.ic_bp_button').html(gettext('imbachat','wp_chat_with_user'))</script>";
    return '<button type="button" class="'.$className.'" onclick="open_dialog('.$id.')"><img
  src="'.IC_PLUGIN_URL.'/assets/images/message.svg"
  alt="За стеклом" style="padding-right: 15px">'.$btnName.'</button>';
}

function ic_close_chat( $atts, $content = null, $code = '' ) {

    if ( is_feed() ) {
        return '[ic_close_chat]';
    }

    require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
    return '<button type="button" onclick="closeChat()">Close imbaChat</button>';
}

function ic_open_chat( $atts, $content = null, $code = '' ) {

    if ( is_feed() ) {
        return '[ic_open_chat]';
    }

    require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
    return '<button type="button" onclick="showChat()">Open ImbaChat</button>';
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
            <button type="button" class="'.$classNameB.'" onclick="ic_create_dialog(this)">'.$btnName.'</button>
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
                'name' => ''
            ),
            $atts, 'ic'
        );
        $classNameB = $atts['classb'];
        $btnName = $atts['buttonname'];
    }
    require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
    return '<button type="button" class="'.$classNameB.'" onclick="ic_join_group(`'.$atts['pipe'].'`, `'.$atts['name'].'`)">'.$btnName.'</button>';
}

function ic_wise_chat($atts, $content = null, $code = '') {
    if ( is_feed() ) {
        return '[ic_wise_chat]';
    }

    if ( 'ic_wise_chat' == $code ) {
        $atts = shortcode_atts(
            array(
                'width' => '',
                'height' => '',
                'name' => ''
            ),
            $atts, 'ic'
        );
        $width = $atts['width'];
        $height = $atts['height'];
        $name = $atts['name'];
    }
    $json_data = IMCH_getJsSettingsString();
    $json_data = json_decode($json_data, true);
    $json_data['holder_ex'] = 1;
    $json_data['holder_ph'] = 'test';
    $json_data = json_encode($json_data);
    wp_add_inline_style('imbachat.css', '#'.$name.'{
        color: red;
    }');
    return '<style>
    @media (max-width: 768px) {
        .'.$name.'{
            width: 0 !important;
            height: 0 !important;
        }
    }
    </style>
    <div id="'.$name.'" class="'.$name.'" style="width: '.$width.'px;height: '.$height.'px">

</div>';
}
