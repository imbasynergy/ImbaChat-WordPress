<?php
?>
<div class="imba_container">
    <div class="imba_item">
        <div class="imba_input_group">
            <label>Choose the which field will displayed as username</label>
            <label class="custom-select" for="user_field">
                <select id="user_field" name="options">
                    <option value="">
                        Select an option
                    </option>
                    <?php
                    foreach ($fields as $k=>$field)
                    {
                    ?>
                        <option value="<?=$k?>" <?= get_option('im_user_field') == $k ? 'selected' : '' ?>>
                            <?=$k.' = '.$field?>
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
            <label>Choose the type of search</label>
            <label class="custom-select" for="search_type">
                <select id="search_type" name="options">
                    <option value="">
                        Select an option
                    </option>
                    <option value="1" <?= get_option('im_user_search_type') == '1' ? 'selected' : '' ?>>
                        Partial Match
                    </option>
                    <option value="2" <?= get_option('im_user_search_type') == '2' ? 'selected' : '' ?>>
                        Full Match
                    </option>
                    <option value="3" <?= get_option('im_user_search_type') == '3' ? 'selected' : '' ?>>
                        Partial match, but from the beginning
                    </option>
                </select>
            </label>
        </div>
    </div>
</div>
<div class="imba_container">
    <div class="imba_item">
        <button type="button" class="imba_btn" onclick="save_users_settings()">Save Settings</button>
    </div>
</div>

<script>
    function save_users_settings(){
        let user_field = jQuery("#user_field").val();
        let search_type = jQuery("#search_type").val();
        jQuery.ajax({
            url: '<?php echo admin_url("admin-ajax.php")?>',
            type: 'POST',
            data: {
                action: 'save_users_settings',
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
</script>