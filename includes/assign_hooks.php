<?php
add_action('dynamic_sidebar_before', function (){
    if (get_the_author())
    {
        $user_id = get_the_author_meta( 'ID' );
        echo do_shortcode('[ic_open_dialog id="'.$user_id.'" class="" name="Chat with author"]');
    }
});

?>