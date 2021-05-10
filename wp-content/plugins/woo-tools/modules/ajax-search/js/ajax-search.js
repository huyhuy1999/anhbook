jQuery(document).ready(function($) {
    var search_cache = {};
    $('.tfwctool-auto-ajaxsearch-input').autocomplete({
        minChars: 3,
        delay: 500,
        source: function(req, res) {
            // console.log(req.term);
            $('.search-label .process-bar').show();
            var term = req.term;
            var cat  = $('.header-middle form.search-form.nestore-search-form').find('#product_cats').val();
            // console.log(cat);
            if (term in search_cache) {
                res(search_cache[term]);
                return;
            }

            $.ajax({
                    url: TFWC_TOOL.ajax_url,
                    type: 'POST',
                    dataType: 'json',
                    data: { action: 'tfwctool_search_auto_ajax', search_key: term, search_cat:cat },
                })
                .done(function(data) {
                    search_cache[term] = data.data;
                    res(data.data);
                })
                .fail(function() {
                    // console.log("error");
                })
                .always(function() {
                    $('.search-label .process-bar').hide();
                });
        },
        select: function(event, ui) {
            window.location.href = ui.item.url;
        },
        position: { my : "left+10px top+2px"}
    });
});