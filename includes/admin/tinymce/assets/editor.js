(function () {

    console.log(location.pathname);

    // Button functionality
    tinymce.PluginManager.add('shorty', function (editor, url) {
        editor.addButton('shorty', {
            icon: 'dashicon dashicons-clipboard',
            tooltip: 'Shorty',
            onclick: function () {
                fetchData().done(function(data) {
                    editor.windowManager.open({
                        title: 'Shorty',
                        body: [{
                            type: 'listbox',
                            name: 'shortcode',
                            label: 'Select shortcode',
                            values: data
                        },],
                        onsubmit: function (e) {
                            editor.insertContent(
                                '[' + e.data.shortcode + ']'
                            );
                        }
                    });
                });
            }
        });
    });

    var dataPromise;

    // Get available shortcodes
    function fetchData() {
        if (!dataPromise) {
            var data = {'action': 'shorty_get_shortcodes'};

            dataPromise = jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                dataType: 'json'
            });
        }

        return dataPromise;
    }

})();