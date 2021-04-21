<form id="regForm" action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
    <input type="hidden" name="action" value="interactive_submit">

    <!-- One "tab" for each step in the form: -->
    <div class="imba_tab">
        <div class="img_holder">
            <img width="200" src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/get_started/Step_1.png' ?>">
        </div>
        <h3 class="tab_title"><?php __("1. Welcome to the ImbaChat!", "imbachat") ?></h3>
        <p class="text_center">
           <?php __("Hello, Welcome to the ImbaChat setting wizard. Click the «Start» button below to proceed.", "imbachat")?>
        </p>
    </div>

    <div class="imba_tab">
        <div class="img_holder">
            <img width="200" src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/get_started/step_2.jpg' ?>">
        </div>
        <h3 class="tab_title">
            <?php __("2. Users connection setting", "imbachat")?>
        </h3>
        <p class="text_center">
            <?php __("First, you need to set up the connection between users to let them chat.
            For that, you should use shortcodes.", "imbachat")?>

        </p>
        <button type="button" class="imba_collapsible">Short codes</button>
        <div class="imba_collapse_content">
            <ul>
                <li>[ic_open_dialog] - <?php __("Start chatting with user", "imbachat")?></li>
                <li>[ic_create_group] - <?php __("Create public group", "imbachat")?></li>
                <li>[ic_join_group] - <?php __("Join to group", "imbachat")?></li>
                <li>[ic_open_chat] - <?php __("Open chat", "imbachat")?></li>
                <li>[ic_close_chat] - <?php __("Close chat", "imbachat")?></li>
                <li>[ic_wise_chat] - <?php __("Placeholder for chat on website page", "imbachat")?></li>
            </ul>
            <a href="https://imbachat.com/en/blog/post/wordpress-shortcodes"><?php __("How to install shortcodes", "imbachat")?></a>
        </div>
    </div>

    <div class="imba_tab">
        <div class="img_holder">
            <img width="200" src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/get_started/step_3.jpg' ?>">
        </div>
        <h3 class="tab_title"><?php __("3. Language")?></h3>
        <div>
            <p class="text_center">
                <?php __("You can choose a ready interface language from three ones: English, Russian, and Italian.
                If you need to customize the interface in another language, you can change each phrase here.", "imbachat")?>
            </p>
        </div>
        <div class="custom-select">
            <select name="language">
                <option value="null"><?php __("Select language:", "imbachat")?></option>
                <option selected value="en-US"><?php __("English", "imbachat")?></option>
                <option value="ru-RUS"><?php __("Russian", "imbachat")?></option>
                <option value="it-IT"><?php __("Italian", "imbachat")?></option>
            </select>
        </div>
    </div>

    <div class="imba_tab">
        <div class="img_holder">
            <img width="200" src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/get_started/step_4.jpg' ?>">
        </div>
        <h3 class="tab_title"><?php __("4. Style customization", "imbachat")?></h3>
        <p class="text_center">
            <?php _("Сustomize the style of the widget for your website. You can change the colors of every element.", "imbachat")?>
        </p>
    </div>

    <div class="imba_tab">
        <div class="img_holder">
            <img width="200" src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/get_started/step_5.jpg' ?>">
        </div>
        <h3 class="tab_title"><?php __("5. Chat moderation")?></h3>
        <p> <?php __("As a chat administrator, you can moderate the chat.", "imbachat")?>
            <?php
            if ($db_link)
            {
                ?>
                <a href="<?= $db_link ?>"><?php __("Here is the chat moderation admin panel.", "imbachat")?></a>
                <?php
            }
            ?>
        </p>

    </div>

    <!--<div class="imba_tab">
        <h3 class="tab_title">6. Other functions</h3>
        <div class="imba_row">
            <div class="price-container imba_col">
                <h2 class="text_center">Advanced functions: </h2>
                <ul>
                    <li>Emoji</li>
                    <li>Sharing files</li>
                    <li>Voice chat</li>
                    <li>1 Gb file storage</li>
                </ul>
                <div>
                    <p class="text_center" style="color: #75AC1A;font-size: 16px">Just for 1$ per month.</p>
                </div>
            </div>
            <div class="price-container imba_col">
                <h2 class="text_center">Premium functions: </h2>
                <ul>
                    <li>All Advanced features</li>
                    <li>Video group chat</li>
                    <li>Audio calls</li>
                    <li>10 Gb file storage</li>
                </ul>
                <div>
                    <p style="color: #75AC1A;font-size: 16px" class="text_center">Just for 19$ per month.</p>
                </div>
            </div>
        </div>
    </div>-->

    <div class="imba_tab">
        <div class="img_holder">
            <img alt="За стеклом" src="<?= IC_PLUGIN_URL.'/assets/images/check-mark.svg' ?>" >
        </div>
        <h3 class="tab_title"><?php __("6. Now all done!", "imbachat")?></h3>
        <p class="text_center"><?php __("ImbaChat plugin has been all set up. Enjoy the chat!", "imbachat")?></p>
    </div>

    <div style="overflow:auto;display: contents" class="btn_container">
        <div class="buttons_holder">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="imba_btn"><?php __("Previous", "imbachat")?></button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)" class="imba_btn"><?php __("Next", "imbachat")?></button>
        </div>
    </div>

    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
    </div>

</form>
