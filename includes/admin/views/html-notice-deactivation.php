<?php
/**
 * Deactivation admin notice
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$reason_deactivation_url = 'https://wpeverest.com/deactivation/user-registration/';
global $status, $page, $s;

$deactivate_url = wp_nonce_url( 'plugins.php?action=deactivate&amp;plugin=' . IC_PLUGIN_BASENAME . '&amp;plugin_status=' . $status . '&amp;paged=' . $page . '&amp;s=' . $s, 'deactivate-plugin_' . IC_PLUGIN_BASENAME );
?>

<div class="im-modal" id="im-deactivate-modal">
    <div class="im-quiz-wrapper">
        <div class="im-quiz-container">
            <h2>Why do you want deactivate our plugin?</h2>
            <ul class="im-quiz">
                <!-- ngRepeat: answer in currentQuestion.answers -->
                <li class="im-quest-item" data-im_reason="The plugin is not what I expected">
                    The plugin is not what I expected
                </li>
                <li class="im-quest-item" data-im_reason="Chat is too slow/has a lot of bugs">
                    Chat is too slow/has a lot of bugs
                </li>
                <li class="im-quest-item" data-im_reason="It is not clear how to use the chat">
                    It is not clear how to use the chat
                </li>
                <li class="im-quest-item" data-im_reason="I don't need chat anymore">
                    I don't need chat anymore
                </li>
                <li class="im-quest-item" data-im_reason="other">
                    Other
                    <div class="im-other-reason">
                        <input maxlength="100">
                    </div>
                </li>
            </ul>
            <div class="im-quiz-buttons">
                <form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
                    <input type="hidden" name="action" value="imbachat_deactivation_reason">
                    <input type="hidden" name="deactivation_url" value="<?= $deactivate_url ?>">
                    <input type="hidden" name="IM_deactivation_reason" value="deactivation_reason">
                    <button type="submit">Send & Deactivate</button>
                </form>
                <a href="<?=$deactivate_url?>">Deactivate</a>
                <a href="#" onclick="window.location.reload()">Cancel</a>
            </div>
        </div>
    </div>
</div>