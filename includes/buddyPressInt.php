<?php

add_action('bp_after_members_loop', function (){

});

add_action('bp_member_header_actions', function (){
    $user_id = bp_displayed_user_id();
    if ($user_id != get_current_user_id())
        echo do_shortcode('[ic_open_dialog id="'.$user_id.'" class="generic-button"]');
});