<?php
?>
<div class="imba_container">
    <div class="imba_item">
        <div class="imba_input_group">
            <label><?php _e("Choose the which field will displayed as username", "imbachat") ?></label>
            <label class="custom-select" for="user_field">
                <select id="user_field" name="options" data-qa="user_field">
                    <option value="">
                        <?php _e("Select an option", "imbachat") ?>
                    </option>
                    <?php
                    foreach ($fields as $k=>$field)
                    {
                        ?>
                        <option value="<?php echo esc_attr( $k ); ?>" <?php echo esc_attr( get_option('im_user_field') ) == esc_attr( $k ) ? 'selected' : '' ?>>
                            <?php echo esc_html($k).' = '.esc_html($field); ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </label>
        </div>
    </div>
    <div class="imba_item">
        <div class="imba_input_group">
            <label><?php _e("Choose the type of search", "imbachat") ?></label>
            <label class="custom-select" for="search_type">
                <select id="search_type" name="options" data-qa="search_type">
                    <option value="">
                        <?php _e("Select an option", "imbachat") ?>
                    </option>
                    <option value="1" <?php echo esc_attr( get_option('im_user_search_type') ) == '1' ? 'selected' : '' ?>>
                        <?php _e("Partial Match", "imbachat") ?>
                    </option>
                    <option value="2" <?php echo esc_attr( get_option('im_user_search_type') ) == '2' ? 'selected' : '' ?>>
                        <?php _e("Full Match", "imbachat") ?>
                    </option>
                    <option value="3" <?php echo esc_attr( get_option('im_user_search_type') ) == '3' ? 'selected' : '' ?>>
                        <?php _e("Partial match, but from the beginning", "imbachat") ?>
                    </option>
                </select>
            </label>
        </div>
    </div>
</div>
<div class="imba_container">
    <div class="imba_item">
        <button type="button" class="imba_btn" onclick="save_users_settings()" data-qa="user_settings_ajax"><?php _e("Save Settings", "imbachat") ?></button>
    </div>
</div>

<?php
        wp_register_style( 'admin-users-settings-script', '',);
        wp_enqueue_style( 'admin-users-settings-script' );
        wp_add_inline_style( 'admin-users-settings-script', "
        function save_users_settings(){
            let user_field = jQuery(\"#user_field\").val();
            let search_type = jQuery(\"#search_type\").val();
            jQuery.ajax({
                url: '<?php echo admin_url(\"admin-ajax.php\")?>',
                type: 'POST',
                data: {
                    action: 'imbachat_save_users_settings',
                    param: {
                        search_type: search_type,
                        user_field: user_field
                    }
                },
                success: function (response) {
                    let data = JSON.parse(response);
                    console.log(data)
                    if (data.status)
                    {
                        generateMessage('success', 'users_settings_success');
                    }
                }
            })
        }
        ");
    ?>