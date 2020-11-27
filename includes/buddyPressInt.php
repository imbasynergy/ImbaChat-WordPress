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

add_action('bp_group_header_meta', function (){
    $group = groups_get_group(bp_get_group_id());
    var_dump();
    $pipe = $group->status.'_'.$group->id;

    echo do_shortcode('[ic_join_group pipe="'.$pipe.'" buttonname="join group" name="'.$group->name.'"]');
});
