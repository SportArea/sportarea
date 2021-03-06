$(document).ready(function () {

    // Full featured editor
    $('.wysiwyg').each(function (index, element) {
        $(element).wysiwyg({
            classes: 'selection',
            // 'selection'|'top'|'top-selection'|'bottom'|'bottom-selection'
            toolbar: 'top-selection',
            buttons: {
                // Fontname plugin
                fontname: {
                    title: 'Font',
                    image: '\uf031', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    popup: function ($popup, $button) {
                        var list_fontnames = {
                            // Name : Font
                            'Arial, Helvetica': 'Arial,Helvetica',
                            'Verdana': 'Verdana,Geneva',
                            'Georgia': 'Georgia',
                            'Courier New': 'Courier New,Courier',
                            'Times New Roman': 'Times New Roman,Times'
                        };
                        var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
                                .attr('unselectable', 'on');
                        $.each(list_fontnames, function (name, font) {
                            var $link = $('<a/>').attr('href', '#')
                                    .css('font-family', font)
                                    .html(name)
                                    .click(function (event) {
                                        $(element).wysiwyg('shell').fontName(font).closePopup();
                                        // prevent link-href-#
                                        event.stopPropagation();
                                        event.preventDefault();
                                        return false;
                                    });
                            $list.append($link);
                        });
                        $popup.append($list);
                    },
                    //showstatic: true,    // wanted on the toolbar
                    showselection: index == 0 ? true : false    // wanted on selection
                },
                // Fontsize plugin
                fontsize: {
                    title: 'Size',
                    image: '\uf034', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    popup: function ($popup, $button) {
                        var list_fontsizes = {
                            // Name : Size
                            'Huge': 7,
                            'Larger': 6,
                            'Large': 5,
                            'Normal': 4,
                            'Small': 3,
                            'Smaller': 2,
                            'Tiny': 1
                        };
                        var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
                                .attr('unselectable', 'on');
                        $.each(list_fontsizes, function (name, size) {
                            var $link = $('<a/>').attr('href', '#')
                                    .css('font-size', (8 + (size * 3)) + 'px')
                                    .html(name)
                                    .click(function (event) {
                                        $(element).wysiwyg('shell').fontSize(size).closePopup();
                                        // prevent link-href-#
                                        event.stopPropagation();
                                        event.preventDefault();
                                        return false;
                                    });
                            $list.append($link);
                        });
                        $popup.append($list);
                    }
                    //showstatic: true,    // wanted on the toolbar
                    //showselection: true    // wanted on selection
                },
                // Header plugin
                header: {
                    title: 'Header',
                    image: '\uf1dc', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    popup: function ($popup, $button) {
                        var list_headers = {
                            // Name : Font
                            'Header 1': '<h1>',
                            'Header 2': '<h2>',
                            'Header 3': '<h3>',
                            'Header 4': '<h4>',
                            'Header 5': '<h5>',
                            'Header 6': '<h6>',
                            'Preformatted': '<pre>'
                        };
                        var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
                                .attr('unselectable', 'on');
                        $.each(list_headers, function (name, format) {
                            var $link = $('<a/>').attr('href', '#')
                                    .css('font-family', format)
                                    .html(name)
                                    .click(function (event) {
                                        $(element).wysiwyg('shell').format(format).closePopup();
                                        // prevent link-href-#
                                        event.stopPropagation();
                                        event.preventDefault();
                                        return false;
                                    });
                            $list.append($link);
                        });
                        $popup.append($list);
                    }
                    //showstatic: true,    // wanted on the toolbar
                    //showselection: false    // wanted on selection
                },
                bold: {
                    title: 'Bold (Ctrl+B)',
                    image: '\uf032', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    hotkey: 'b'
                },
                italic: {
                    title: 'Italic (Ctrl+I)',
                    image: '\uf033', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    hotkey: 'i'
                },
                underline: {
                    title: 'Underline (Ctrl+U)',
                    image: '\uf0cd', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    hotkey: 'u'
                },
                strikethrough: {
                    title: 'Strikethrough (Ctrl+S)',
                    image: '\uf0cc', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    hotkey: 's'
                },
                forecolor: {
                    title: 'Text color',
                    image: '\uf1fc' // <img src="path/to/image.png" width="16" height="16" alt="" />
                },
                highlight: {
                    title: 'Background color',
                    image: '\uf043' // <img src="path/to/image.png" width="16" height="16" alt="" />
                },
                alignleft: {
                    title: 'Left',
                    image: '\uf036', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                aligncenter: {
                    title: 'Center',
                    image: '\uf037', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                alignright: {
                    title: 'Right',
                    image: '\uf038', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                alignjustify: {
                    title: 'Justify',
                    image: '\uf039', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                /*
                subscript: index == 1 ? false : {
                    title: 'Subscript',
                    image: '\uf12c', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: true    // wanted on selection
                },
                superscript: index == 1 ? false : {
                    title: 'Superscript',
                    image: '\uf12b', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: true    // wanted on selection
                },
                */
                indent: {
                    title: 'Indent',
                    image: '\uf03c', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                outdent: {
                    title: 'Outdent',
                    image: '\uf03b', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                orderedList: {
                    title: 'Ordered list',
                    image: '\uf0cb', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                unorderedList: {
                    title: 'Unordered list',
                    image: '\uf0ca', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                removeformat: {
                    title: 'Remove format',
                    image: '\uf12d' // <img src="path/to/image.png" width="16" height="16" alt="" />
                }
            },
            // Submit-Button
            submit: {
                title: 'Submit',
                image: '\uf00c' // <img src="path/to/image.png" width="16" height="16" alt="" />
            },
            // Other properties
            dropfileclick: 'Drop image or click',
            placeholderUrl: 'www.example.com',
            maxImageSize: [600, 200]
                    /*
                     onImageUpload: function( insert_image ) {
                     // Used to insert an image without XMLHttpRequest 2
                     // A bit tricky, because we can't easily upload a file
                     // via '$.ajax()' on a legacy browser.
                     // You have to submit the form into to a '<iframe/>' element.
                     // Call 'insert_image(url)' as soon as the file is online
                     // and the URL is available.
                     // Best way to do: http://malsup.com/jquery/form/
                     // For example:
                     //$(this).parents('form')
                     //       .attr('action','/path/to/file')
                     //       .attr('method','POST')
                     //       .attr('enctype','multipart/form-data')
                     //       .ajaxSubmit({
                     //          success: function(xhrdata,textStatus,jqXHR){
                     //            var image_url = xhrdata;
                     //            console.log( 'URL: ' + image_url );
                     //            insert_image( image_url );
                     //          }
                     //        });
                     },
                     onKeyEnter: function() {
                     if( typeof console != 'undefined' )
                     console.log( 'e.g. submit form' );
                     return false; // swallow enter
                     }
                     */
        })/*
        .change(function () {
            if (typeof console != 'undefined')
                console.log('change');
        })
        .focus(function () {
            if (typeof console != 'undefined')
                console.log('focus');
        })
        .blur(function () {
            if (typeof console != 'undefined')
                console.log('blur');
        });*/
    });

    // Demo-Buttons
    $('#editor3-bold').click(function () {
        $('#editor3').wysiwyg('shell').bold();
        return false;
    });
    $('#editor3-red').click(function () {
        $('#editor3').wysiwyg('shell').highlight('#ff0000');
        return false;
    });
    $('#editor3-sethtml').click(function () {
        $('#editor3').wysiwyg('shell').setHTML('This is the new text.');
        return false;
    });
    $('#editor3-inserthtml').click(function () {
        $('#editor3').wysiwyg('shell').insertHTML('Insert some text.');
        return false;
    });
/*
    // Raw editor
    var option = {
        element: $('#editor0').get(0),
        onkeypress: function (code, character, shiftKey, altKey, ctrlKey, metaKey) {
            if (typeof console != 'undefined')
                console.log('RAW: ' + character + ' key pressed');
        },
        onselection: function (collapsed, rect, nodes, rightclick) {
            if (typeof console != 'undefined' && rect)
                console.log('RAW: selection rect(' + rect.left + ',' + rect.top + ',' + rect.width + ',' + rect.height + '), ' + nodes.length + ' nodes');
        },
        onplaceholder: function (visible) {
            if (typeof console != 'undefined')
                console.log('RAW: placeholder ' + (visible ? 'visible' : 'hidden'));
        }
    };
    var wysiwygeditor = wysiwyg(option);
    //wysiwygeditor.setHTML( '<html>' );
*/
});