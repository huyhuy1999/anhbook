(function($) {
	var api = wp.customize;
    wp.customize.bind('ready', function() { // Ready?
        var cobj = tf_comp_controls;
        // console.log(tf_comp_controls);
        var is_theme_init = cobj.is_theme_init;
        if (is_theme_init) {
            setTimeout(function() {
                var sections = wp.customize.panel('themefarmer_fontpage_panel').sections();
                $.each(sections, function(index, section) {
                    var controls = section.controls();
                    $.each(controls, function(index, control) {
                        var cval = control.setting.get();
                        control.setting.set('');
                        control.setting.set(cval);
                    });
                });
            }, 2000);
        }
    });

})(jQuery);