<?php

add_action('bp_after_members_loop', function (){

});

add_action('bp_member_header_actions', function (){
    if ( is_user_logged_in() ) {
        $user_id = bp_displayed_user_id();
        if ($user_id != get_current_user_id())
            echo do_shortcode('[ic_open_dialog id="'.$user_id.'" class="ic_bp_button" name="Message"]');
    }
});


add_action('bp_directory_members_item', function (){
    if ( is_user_logged_in() ) {
        $user_id = bp_get_member_user_id();
        if ($user_id != get_current_user_id())
            echo do_shortcode('[ic_open_dialog id="'.$user_id.'" class="ic_bp_button" name="Message"]');
    }
});
add_action('bp_group_header_actions', function (){
    $group = groups_get_group(bp_get_group_id());
    $pipe = $group->status.'_'.$group->id;
    $user_id = get_current_user_id();

    if (groups_is_user_member($user_id, $group->id) || $group->status == 'public')
    {
        require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
        $button = array(
            'id'                => 'Join_Group_Chat',
            'component'         => 'groups',
            'must_be_logged_in' => true,
            'block_self'        => false,
            'wrapper_class'     => 'group-button ' . $group->status,
            'wrapper_id'        => 'groupbutton-' . $group->id,
            'parent_element'    => 'div',
            'button_element'    => 'button',
            'button_attr'       => [
                'onClick' => 'ic_join_group("'.$pipe.'", "'.$group->name.'")'
            ],
//        'link_href'         => wp_nonce_url( trailingslashit( bp_get_group_permalink( $group ) . 'leave-group' ), 'groups_leave_group' ),
            'link_text'         => __( 'Join Group Chat', 'buddypress' ),
            'link_class'        => 'group-button',
        );
        bp_button($button);
    }
});