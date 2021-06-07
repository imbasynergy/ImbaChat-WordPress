/* global im_plugins_params */
jQuery(function ($) {
    $(document.body).on(
        "click",
        'tr[data-plugin="imbachat-widget/ImbaChatWidget.php"] span.deactivate a',
        function (e) {
            // e.preventDefault();
            //
            // var data = {
            //     action: "imbachat_deactivation_notice",
            //     security: im_plugins_params.deactivation_nonce,
            // };
            //
            // $.post(im_plugins_params.ajax_url, data, function (response) {
            //     $(
            //         'tr[data-plugin="imbachat-widget/ImbaChatWidget.php"] span.deactivate a'
            //     ).addClass("hasNotice");
            //
            //     if ($('tr[id="imbachat-license-row"]').length !== 0) {
            //         $('tr[id="imbachat-license-row"]')
            //             .addClass(
            //                 "update imbachat-deactivation-notice"
            //             )
            //     } else {
            //         $(
            //             'tr[data-plugin="imbachat-widget/ImbaChatWidget.php"]'
            //         )
            //             .addClass(
            //                 "update imbachat-deactivation-notice"
            //             )
            //     }
            //     $('body').after(response);
            //     let modal = document.getElementById('im-deactivate-modal')
            //     modal.style.display = 'block';
            //     let reasons = Array.from(document.querySelectorAll('ul[class="im-quiz"] li'));
            //     let event_added = false;
            //     reasons.forEach((item) => {
            //         item.addEventListener('click', (e) => {
            //             let active = document.querySelector('ul[class="im-quiz"] li[class~="active"]');
            //             if (active)
            //                 active.classList.remove('active')
            //             item.classList.add('active');
            //             let form = item.closest('div[class="im-quiz-container"]').querySelector('form');
            //             if (item.getAttribute('data-im_reason') == 'other'){
            //                 item.querySelector('div').classList.remove('slide-up');
            //                 item.querySelector('div').classList.add('slide-down');
            //                 let input = item.querySelector('input');
            //                 input.value = '';
            //                 form.querySelector('input[name="IM_deactivation_reason"]').value = 'other';
            //                 if (!event_added)
            //                 {
            //                     event_added = true;
            //                     input.addEventListener('input', (e) => {
            //                         form.querySelector('input[name="IM_deactivation_reason"]').value = e.target.value;
            //                     })
            //                 }
            //             } else {
            //                 let other_el = item.closest('ul').querySelector('li[data-im_reason="other"]').querySelector('div')
            //                 other_el.classList.add('slide-up');
            //                 other_el.classList.remove('slide-down');
            //                 form.querySelector('input[name="IM_deactivation_reason"]').value = item.getAttribute('data-im_reason')
            //             }
            //         })
            //     })
            // }).fail(function (xhr) {
            //     window.console.log(xhr.responseText);
            // });
        }
    );
});
