<form id="regForm" action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
    <input type="hidden" name="action" value="imbachat_interactive_submit">

    <!-- One "tab" for each step in the form: -->
    <div class="imba_tab">
        <div class="img_holder">
            <img width="200" src="<?php echo IMBACHAT_ADMIN_DIR.'/assets/images/get_started/Step_1.png' ?>">
        </div>
        <h3 class="tab_title"><?php _e("Welcome to the ImbaChat!", "imbachat") ?></h3>
        <p class="text_center">
           <?php _e("Hello, Welcome to the ImbaChat setting wizard. Click the «Start» button below to proceed.", "imbachat")?>
        </p>
    </div>

    <div class="imba_tab">
        <div class="img_holder">
            <img width="200" src="<?php echo IMBACHAT_ADMIN_DIR.'/assets/images/get_started/step_2.jpg' ?>">
        </div>
        <h3 class="tab_title">
            <?php _e("Users connection setting", "imbachat")?>
        </h3>
        <p class="text_center">
            <?php _e("First, you need to set up the connection between users to let them chat.
            For that, you should use shortcodes.", "imbachat")?>

        </p>
        <button type="button" class="imba_collapsible"><?php _e("Short codes", "imbachat")?></button>
        <div class="imba_collapse_content">
            <ul>
                <li>[ic_open_dialog] - <?php _e("Start chatting with user", "imbachat")?></li>
                <li>[ic_create_group] - <?php _e("Create public group", "imbachat")?></li>
                <li>[ic_join_group] - <?php _e("Join to group", "imbachat")?></li>
                <li>[ic_open_chat] - <?php _e("Open chat", "imbachat")?></li>
                <li>[ic_close_chat] - <?php _e("Close chat", "imbachat")?></li>
                <li>[ic_wise_chat] - <?php _e("Placeholder for chat on website page", "imbachat")?></li>
            </ul>
            <a href="https://imbachat.com/en/blog/post/wordpress-shortcodes"><?php _e("How to install shortcodes", "imbachat")?></a>
        </div>
    </div>

    <div class="imba_tab">
        <div class="img_holder">
            <img width="200" src="<?php echo IMBACHAT_ADMIN_DIR.'/assets/images/get_started/step_3.jpg' ?>">
        </div>
        <h3 class="tab_title"><?php _e("Language")?></h3>
        <div>
            <p class="text_center">
                <?php _e("You can choose a ready interface language from three ones: English, Russian, and Italian.
                If you need to customize the interface in another language, you can change each phrase here.", "imbachat")?>
            </p>
        </div>
        <div class="custom-select">
            <select name="language">
                <option value="null"><?php _e("Select language:", "imbachat")?></option>
                <option selected value="en-US"><?php _e("English", "imbachat")?></option>
                <option value="ru-RUS"><?php _e("Russian", "imbachat")?></option>
                <option value="it-IT"><?php _e("Italian", "imbachat")?></option>
            </select>
        </div>
    </div>

    <div class="imba_tab">
        <div class="img_holder">
            <img width="200" src="<?php echo IMBACHAT_ADMIN_DIR.'/assets/images/get_started/step_4.jpg' ?>">
        </div>
        <h3 class="tab_title"><?php _e("Style customization", "imbachat")?></h3>
        <p>
            Open <a href="https://imbachat.com/visitor/login-user?token=<?php echo esc_attr(get_option('IMCH_secret_key')) ?>">Admin Panel</a>
            There you can see the Widget settings. Open Style Settings and change the widget appearance as you want.
            <a href="https://imbachat.com/en/blog/post/how-customize-widget">How to customize widget appearance.</a>
        </p>
    </div>

    <div class="imba_tab">
        <div class="img_holder">
            <img width="200" src="<?php echo IMBACHAT_ADMIN_DIR.'/assets/images/get_started/step_5.jpg' ?>">
        </div>
        <h3 class="tab_title"><?php _e("Chat moderation")?></h3>
        <p> <?php _e("As a chat administrator, you can moderate the chat.", "imbachat")?>
            <?php
            if ($db_link)
            {
                ?>
                <a href="<?php echo esc_url( $db_link ); ?>"><?php _e("Here is the chat moderation admin panel.", "imbachat")?></a>
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
            <img alt="За стеклом" src="<?php echo IMBACHAT_IC_PLUGIN_URL.'/assets/images/check-mark.svg' ?>" >
        </div>
        <h3 class="tab_title"><?php _e("6. Now all done!", "imbachat")?></h3>
        <p class="text_center"><?php _e("ImbaChat plugin has been all set up. Enjoy the chat!", "imbachat")?></p>
    </div>

    <div style="overflow:auto;display: contents" class="btn_container">
        <div class="buttons_holder">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="imba_btn"><?php _e("Previous", "imbachat")?></button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)" class="imba_btn"><?php _e("Next", "imbachat")?></button>
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
