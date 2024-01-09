/*!
 * Theme Function
 *
 * Js custom theme
 */

(function ($) {
    "use strict";

    // submit location
    function submitLocation() {
        $('.service-finder-form').on('submit', function (e) {
            e.preventDefault();
            $('.service-finder-result-yes, .service-finder-result-no').hide();
            var postcode = $('.service-finder-input').val(),
                data_postcodes = $(this).attr('data-postcodes'),
                postcodes = JSON.parse(data_postcodes);
            if (postcode.length > 0) {
                if (postcode in postcodes) {
                    $('.service-finder-result-yes').fadeIn();
                } else {
                    $('.service-finder-result-no').fadeIn();
                }
            }
        });
        $('.service-finder-input').on('input', function () {
            $('.service-finder-result-yes, .service-finder-result-no').hide();
        });
    }

    $(document).ready(function () {
        submitLocation();
    });

    // accordion function 
    jQuery(document).ready(function ($) {
        if ($('.elementor-accordion').length > 0) {
            $('.elementor-accordion').each(function () {
                if ($(this).find(' .elementor-accordion-item').length <= 1) {
                    $(this).addClass('no-accordion')
                }
            });
        }
    })

    // slider image before after
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.querySelector('.list-image-container');
        const titleBefore = document.querySelector('.title_before');
        const titleAfter = document.querySelector('.title_after');

        document.querySelector('.slider').addEventListener('input', function (e) {
            container.style.setProperty('--position', `${e.target.value}%`);
            // Check if the slider is close to the titles and hide them
            if (e.target.value < 10) {
                titleBefore.classList.add('hidden');
            } else {
                titleBefore.classList.remove('hidden');
            }
            if (e.target.value > 90) {
                titleAfter.classList.add('hidden');
            } else {
                titleAfter.classList.remove('hidden');
            }
        });
    });

})(jQuery);