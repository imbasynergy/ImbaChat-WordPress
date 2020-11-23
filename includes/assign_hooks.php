<?php
function chat_before_content( $content ) {
    if (is_single() && get_post_type() == 'post')
    {
        $user_id = get_the_author_meta( 'ID' );
        if ($user_id > 0)
        {
            $content_with_button = do_shortcode('[ic_open_dialog id="'.$user_id.'" class="" name="Chat with author"]').$content;
            return $content_with_button;
        } else
            return $content;
    }
    return $content;
}
add_filter( 'the_content', 'chat_before_content' );
?>