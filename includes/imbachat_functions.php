<?php

use \Firebase\JWT\JWT;
function imbachat_open_dialog_with( $atts, $content = null, $code = '' ) {

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
        if($id==0 || $id==null) $id  =  get_the_author_meta("ID");
        $className = $atts['class'];
        $filter = apply_filters('imbachat_open_dialog_filter', false, get_current_user_id(), $id);
        if (!$filter || $filter['status'] == 'default') {
            $btnName = $atts['name'];
            $current_user = wp_get_current_user();
            $payload = [
                'user_id' => $id,
                'initiator' => $current_user->ID,
                'status' => 0,
                'exp' => (int)date('U')+3600*7,
            ];
            $jwt = JWT::encode($payload, get_option('IMCH_secret_key'));
        } elseif ($filter['status'] == 'need_access'){
            $btnName = 'Message';
            $current_user = wp_get_current_user();
            $payload = [
                'user_id' => $id,
                'initiator' => $current_user->ID,
                'status' => 1,
                'exp' => (int)date('U')+3600*7,
            ];
            $jwt = JWT::encode($payload, get_option('IMCH_secret_key'));
        } else {
            return false;
        }
    }
    $text_btn = __($btnName, "imbachat");
    return '<button type="button" class="'.$className.'" onclick="open_dialog('.$id.', `'.$jwt.'`, this)">'.$text_btn.'</button>';
}

function imbachat_close_chat( $atts, $content = null, $code = '' ) {

    if ( is_feed() ) {
        return '[ic_close_chat]';
    }

    $text_btn = __("Close ImbaChat", "imbachat");
    return '<button type="button" onclick="closeChat()">'.$text_btn.'</button>';
}

function imbachat_open_chat( $atts, $content = null, $code = '' ) {

    if ( is_feed() ) {
        return '[ic_open_chat]';
    }
    $text_btn = __("Open ImbaChat", "imbachat");
    return '<button type="button" onclick="showChat()">'.$text_btn.'</button>';
}

function imbachat_create_group_with($atts, $content = null, $code = '') {
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
        if($btnName=='') $btnName='Create Group';
    }
    $group_name_imbachat=(translate("Group name", "imbachat")=="")? "Group name" : translate("Group name", "imbachat");
    $pipe_imbachat=(translate("Pipe", "imbachat")=="") ? "Pipe" : translate("Pipe", "imbachat");
    if ($btnName=="") $btnName=(translate('Create Group', "imbachat")=="") ? 'Create Group' : translate('Create Group', "imbachat");
    return '<div id="ic_create_group_cont">
            <input class="'.$classNameI.'" placeholder="'.$group_name_imbachat.'" type="text" id="ic_group_title">
            <input class="'.$classNameI.'" placeholder="'.$pipe_imbachat.'" type="text" id="ic_group_pipe">
            <button type="button" class="'.$classNameB.'" onclick="ic_create_dialog(this)">'.$btnName.'</button>
    </div>';
}

function imbachat_join_group($atts, $content = null, $code = '') {
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
        if($btnName=='') $btnName='Join Group';
    }
    return '<button type="button" class="'.$classNameB.'" onclick="ic_join_group(`'.$atts['pipe'].'`, `'.$atts['name'].'`)">'._e($btnName, "imbachat").'</button>';
}

function imbachat_wise_chat($atts, $content = null, $code = '') {
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
    $json_data = imbachat_getJsSettingsString();
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
