<?php
/**
 * Rate admin notice
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>

<div class="notice notice-info user-registration-review-notice" id="imba_rating">
    <p><?php _e("Your feedback is very important to us.", "imbachat") ?></p>
    <div class="imbachat_logo_container">
        <img src="<?php echo IMBACHAT_ADMIN_DIR.'/assets/images/imbachat_logo.jpg'; ?>">
    </div>
    <div>
        <p><?php _e("Please rate us!", "imbachat") ?></p>
        <div class="imba_flex">
            <div class="imba_rate">
                <input type="radio" id="star5" name="imba_rate" value="5" />
                <label for="star5" title="text"><?php _e("5 stars", "imbachat") ?></label>
                <input type="radio" id="star4" name="imba_rate" value="4" />
                <label for="star4" title="text"><?php _e("4 stars", "imbachat") ?></label>
                <input type="radio" id="star3" name="imba_rate" value="3" />
                <label for="star3" title="text"><?php _e("3 stars", "imbachat") ?></label>
                <input type="radio" id="star2" name="imba_rate" value="2" />
                <label for="star2" title="text"><?php _e("2 stars", "imbachat") ?></label>
                <input type="radio" id="star1" name="imba_rate" value="1" />
                <label for="star1" title="text"><?php _e("1 star", "imbachat") ?></label>
            </div>
            <div class="imba_rate_extra">
                <input placeholder="what problems did you encounter with while using chat?" type="text">
                <a class="button button-primary" href="#" data-imba_rating="0" onclick="sendRate(this)"><?php _e("Rate Us", "imbachat") ?></a>
            </div>
        </div>
    </div>
</div>
<script>
    const sendRate = (el) => {
        let rating = el.getAttribute('data-imba_rating') || 0;
        let extra_block = document.querySelector('div[class~="imba_rate_extra"]');
        let reason = extra_block.querySelector('input').value;
        let data = {
            action: 'imbachat_send_rate',
            rating: rating,
            reason: reason
        }
        jQuery.post('<?php echo admin_url( 'admin-ajax.php' ); ?>', data, function (response) {
            if (rating >= 4 )
                window.open('https://wordpress.org/support/plugin/imbachat-widget/reviews/#postform')
        })
        jQuery("#imba_rating").remove();
    }
    document.addEventListener('DOMContentLoaded', () => {
        let rate_notice_block = jQuery('#imba_rating');
        let inputs = rate_notice_block.find('input[name="imba_rate"]');
        inputs.each((index, item) => {
            item.addEventListener('change', (event) => {
                document.querySelector('div[class~="imba_rate_extra"] a').setAttribute('data-imba_rating', event.target.value)
                document.querySelector('div[class~="imba_rate_extra"]').classList.add('show')
                if (event.target.value <= 3){
                    document.querySelector('div[class~="imba_rate_extra"] input').style.display = 'inline-block';
                } else
                {
                    document.querySelector('div[class~="imba_rate_extra"] input').style.display = 'none';
                }
            })
        })
    })
</script>
