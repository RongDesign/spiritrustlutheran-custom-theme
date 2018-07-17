(function() {
    tinymce.PluginManager.add('spiritrust_mce_button', function(editor, url) {
        editor.addButton('spiritrust_mce_button', {
            text: 'Shortcodes',
            icon: false,
            type: 'menubutton',
            menu: [
                {
                    text: 'Button',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Button Shortcode',
                            body: [{
                                    type  : 'textbox',
                                    name  : 'href',
                                    label : 'Link',
                                    value : 'http://'
                                },
                                {
                                    type  : 'textbox',
                                    name  : 'text',
                                    label : 'Link Text',
                                    value : 'Read More'
                                },
                                {
                                    type  : 'listbox',
                                    name  : 'color',
                                    label : 'Button Color',
                                    values: [
                                        { text: 'Blue', value: 'blue' },
                                        { text: 'Dark Blue', value: 'darkblue' },
                                        { text: 'Green (Default)', value: 'green' },
                                        { text: 'Teal', value: 'teal' }
                                    ],
                                    value : 'green'
                                },
                                {
                                    type  : 'checkbox',
                                    name  : 'inline',
                                    label : 'Inline'
                                },
                                {
                                    type  : 'checkbox',
                                    name  : 'blankwindow',
                                    label : 'Open In Blank Window'
                                }
                            ],
                            onsubmit: function (e) {
                                editor.insertContent('[button text="' + e.data.text + '" color="' + e.data.color + '" href="' + e.data.href + '" blankwindow="' + e.data.blankwindow + '" inline="' + e.data.inline + '"]');
                            }
                        });
                    }
                },
                {
                    text: 'Blackbaud Form',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Blackbaud Shortcode',
                            body: [
                                {
                                    type : 'textbox',
                                    name : 'id',
                                    label: 'Blackbaud Form ID',
                                    value: ''
                                }
                            ],
                            onsubmit: function (e) {
                                editor.insertContent('[blackbaud id="' + e.data.id + '"]');
                            }
                        });
                    }
                },
                {
                    text: 'Video Modal Link',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Video Modal Link Shortcode',
                            body: [
                                {
                                    type : 'textbox',
                                    name : 'id',
                                    label: 'YouTube ID',
                                    value: ''
                                },
                                {
                                    type : 'textbox',
                                    name : 'title',
                                    label: 'Modal Title',
                                    value: ''
                                },
                                {
                                    type : 'textbox',
                                    name : 'text',
                                    label: 'Link Text',
                                    value: 'Watch Video'
                                }
                            ],
                            onsubmit: function (e) {
                                editor.insertContent('[videomodallink id="' + e.data.id + '" title="' + e.data.title + '" text="' + e.data.text + '"]');
                            }
                        });
                    }
                }
            ]
        });
    });
})();
