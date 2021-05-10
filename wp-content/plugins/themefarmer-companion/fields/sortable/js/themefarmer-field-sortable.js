wp.customize.controlConstructor['themefarmer-sortable'] = wp.customize.Control.extend({

    // When we're finished loading continue processing
    ready: function() {

        'use strict';

        var control = this;
        control.initThemeFarmerControl();
    },

    initThemeFarmerControl: function() {

        'use strict';

        var control = this;

        // Set the sortable container.
        control.sortableContainer = control.container.find( 'ul.themefarmer-sortable' ).first();
        // console.log(control.sortableContainer);
        // Init sortable.
        control.sortableContainer.sortable({
            axis: 'y',
            items: '> li',
            stop: function() {
                control.updateValue();
            }
        }).disableSelection().find( 'li' ).each( function() {

            // Enable/disable options when we click on the eye of Thundera.
            jQuery( this ).find( 'i.visibility' ).click( function() {
                jQuery( this ).toggleClass( 'dashicons-visibility-faint' ).parents( 'li:eq(0)' ).toggleClass( 'invisible' );
            });
        }).click( function() {

            // Update value on click.
            control.updateValue();
        });
    },

    /**
     * Updates the sorting list
     */
    updateValue: function() {

        'use strict';

        var control = this,
            newValue = [];

        this.sortableContainer.find( 'li' ).each( function() {
            if ( ! jQuery( this ).is( '.invisible' ) ) {
                newValue.push( jQuery( this ).data( 'value' ) );
            }
        });
        control.setting.set( newValue );
    }
});
/*jQuery(document).ready(function($) {
    // var saved_data_input   = control_settings.saved_data_input;
    jQuery(".themefarmer-sortable").sortable({
        axis: 'y',
        items: '> li',
        update: function(event, ui) {
            update_tf_shotable($(this));
        }
    }).disableSelection();
    
    $(document).on('click', '.themefarmer-sortable-item .dashicons-visibility', function(event) {
        var s_item = $(this).parent();
        var parent = $(this).parent().parent();
        console.log(s_item);
        if (s_item.hasClass('invisible')) {
            s_item.removeClass('invisible');
        } else {
            s_item.addClass('invisible');
        }

        update_tf_shotable(parent);
    });

    var update_tf_shotable = function(obj) {
        //var data = JSON.stringify(obj.sortable( 'toArray' , { attribute : "data-value" }));
        // jQuery( saved_data_input ).trigger( 'change' );
        var data = [];
        obj.children('li').each(function() {
            if (!$(this).hasClass('invisible')) {
                data.push($(this).data('value'));
            }
        });


        obj.children('.themefarmer-sortable-data').val(JSON.stringify(data));
        obj.children('.themefarmer-sortable-data').trigger('change');
    }

});*/