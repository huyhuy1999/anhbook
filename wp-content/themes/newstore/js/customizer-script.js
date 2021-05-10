jQuery(document).ready(function($) {
    'use strict';

    $(document).on('click', '.newstore_go_to_section', function(event) {
        event.preventDefault();
        var id = jQuery(this).attr('href');
        if (typeof(id) != 'undefined') {
            jQuery(id).find('h3').trigger('click');
        }
    });


    $(document).on('click', 'li[id*="accordion-section-themefarmer_home_"]', function(event) {
        var section = $(this).attr('aria-owns');
        section = section.replace(/.*_home_(.*)_section.*/, "$1");
        section = section.replace('_', '-');
        if (section.length) {
            wp.customize.previewer.send('customizer-section-clicked', section);
        }
    });

});