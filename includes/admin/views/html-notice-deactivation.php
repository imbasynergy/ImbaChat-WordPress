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
            <h2><?php _('Why do you want deactivate our plugin?', "imbachat") ?></h2>
            <ul class="im-quiz">
                <!-- ngRepeat: answer in currentQuestion.answers -->
                <li class="im-quest-item" data-im_reason="The plugin is not what I expected" data-qa="deactivation_reason_1">
                    <?php _("The plugin is not what I expected", "imbachat") ?>
                </li>
                <li class="im-quest-item" data-im_reason="Chat is too slow/has a lot of bugs" data-qa="deactivation_reason_2">
                     <?php _("Chat is too slow/has a lot of bugs", "imbachat") ?>
                </li>
                <li class="im-quest-item" data-im_reason="It is not clear how to use the chat" data-qa="deactivation_reason_3">
                     <?php _("It is not clear how to use the chat", "imbachat") ?>
                </li>
                <li class="im-quest-item" data-im_reason="I don't need chat anymore" data-qa="deactivation_reason_4">
                     <?php _("I don't need chat anymore", "imbachat") ?>
                </li>
                <li class="im-quest-item" data-im_reason="other" data-qa="deactivation_reason_other">
                     <?php _("Other", "imbachat") ?>
                    <div class="im-other-reason">
                        <input maxlength="100" data-qa="deactivation_reason_other_extra">
                    </div>
                </li>
            </ul>
            <div class="im-quiz-buttons">
                <form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
                    <input type="hidden" name="action" value="imbachat_deactivation_reason">
                    <input type="hidden" name="deactivation_url" value="<?= $deactivate_url ?>">
                    <input type="hidden" name="IM_deactivation_reason" value="deactivation_reason">
                    <button type="submit" data-qa="send_and_deactivate" class="imbachat_warning"><?php _("Send & Deactivate", "imbachat") ?></button>
                </form>
                <a href="<?=$deactivate_url?>" data-qa="deactivate_button"><?php _("Deactivate", "imbachat") ?></a>
                <a href="#" onclick="document.getElementById('im-deactivate-modal').style.display = 'none'" data-qa="deactivation_cancel" class="imbachat_danger"><?php _("Cancel", "imbachat") ?></a>
            </div>
        </div>
    </div>
</div>