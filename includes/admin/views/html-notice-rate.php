<?php
/**
 * Rate admin notice
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>

<div class="notice notice-info user-registration-review-notice" id="imba_rating">
    <p>Your feedback is very important to us.</p>
    <div class="imbachat_logo_container">
        <img src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/imbachat_logo.jpg' ?>">
    </div>
    <div>
        <p>Please rate us!</p>
        <div class="imba_flex">
            <div class="imba_rate">
                <input type="radio" id="star5" name="imba_rate" value="5" />
                <label for="star5" title="text">5 stars</label>
                <input type="radio" id="star4" name="imba_rate" value="4" />
                <label for="star4" title="text">4 stars</label>
                <input type="radio" id="star3" name="imba_rate" value="3" />
                <label for="star3" title="text">3 stars</label>
                <input type="radio" id="star2" name="imba_rate" value="2" />
                <label for="star2" title="text">2 stars</label>
                <input type="radio" id="star1" name="imba_rate" value="1" />
                <label for="star1" title="text">1 star</label>
            </div>
            <div class="imba_rate_extra">
                <input placeholder="what problems did you encounter with while using chat?" type="text">
                <a class="button button-primary" href="#" data-imba_rating="0" onclick="sendRate(this)">Rate Us</a>
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
        $.post('<?=admin_url( 'admin-ajax.php' )?>', data, function (response) {
            if (rating >= 4 )
                window.open('https://wordpress.org/support/plugin/imbachat-widget/reviews/#postform')
        })
        $("#imba_rating").remove();
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
