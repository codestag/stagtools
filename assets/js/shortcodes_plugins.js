/**
 * Table of Contents
 *
 * 1.jQuery Appendo
 * 2. base64.js
 * 3. custom
 *
 */

// 1. jQuery.appendo
/**
 * Appendo Plugin for jQuery v1.01
 * Creates interface to create duplicate clones of last table row (usually for forms)
 * (c) 2008 Kelly Hallman. Free software released under MIT License.
 * See http://deepliquid.com/content/Appendo.html for more info
 */

// Attach appendo as a jQuery plugin
jQuery.fn.appendo = function( opt ) {
    this.each( function() {
 jQuery.appendo.init( this, opt );
});
    return this;
};

// appendo namespace
jQuery.appendo = ( function() {

    // Create a closure so that we can refer to "this" correctly down the line
    var myself = this;

    // Global Options
    // These can be set with inline Javascript like so:
    // jQuery.appendo.opt.maxRows = 5;
    // $.appendo.opt.allowDelete = false;
    // (no need, in fact you shouldn't, wrap in jQuery(document).ready() etc)
    this.opt = { };

    this.init = function( obj, opt ) {

        // Extend the defaults with global options and options given, if any
        var options = jQuery.extend({
                labelAdd: 'Add Row',
                labelDel: 'Remove',
                allowDelete: true,

                // copyHandlers does not seem to work
                // it's been removed from the docs for now...
                copyHandlers: false,
                focusFirst: true,
                onAdd: function() {
 return true;
},
                onDel: function() {
 return true;
},
                maxRows: 0,
                wrapClass: 'appendoButtons',
                wrapStyle: { padding: '.4em .2em .5em' },
                buttonStyle: { marginRight: '.5em' },
                subSelect: 'tr:last'
            },
            myself.opt,
            opt
        );

        // Store clone of last table row
        var $cpy = jQuery( obj ).find( options.subSelect ).clone( options.copyHandlers );

        // We consider this starting off with 1 row
        var rows = 1;

        // Create two button objects
        var $add_btn = jQuery( '#form-child-add' ).click( clicked_add ),
            $del_btn = new_button( options.labelDel ).click( clicked_del ).hide()
        ;

        // Append a row to table instance
        function add_row() {
            var $dup = $cpy.clone( options.copyHandlers );
            $dup.appendTo( obj );
            update_buttons( 1 );
            if ( 'function' == typeof( options.onAdd ) ) {
options.onAdd( $dup );
}
            if ( options.focusFirst ) {
$dup.find( 'input:first' ).focus();
}
        }

        // Remove last row from table instance
        function del_row() {
            var $row = jQuery( obj ).find( options.subSelect );
            if ( ( 'function' != typeof( options.onDel ) ) || options.onDel( $row ) ) {
                $row.remove();
                update_buttons( -1 );
            }
        }

        // Updates the button states after rows change
        function update_buttons( rowdelta ) {

            // Update rows if a delta is provided
            rows = rows + ( rowdelta || 0 );

            // Disable the add button if maxRows is set and we have that many rows
            // $add_btn.attr('disabled',(!options.maxRows || (rows < options.maxRows))?false:true);
            // Show remove button if we've added rows and allowDelete is set
            ( options.allowDelete && ( 1 < rows ) ) ? $del_btn.show() : $del_btn.hide();
        }

        // Returns (jQuery) button objects with label
        function new_button( label ) {
            return jQuery( '<button />' )
                .css( options.buttonStyle )
                .html( label );
        }

        // This function can be returned to kill a received event
        function nothing( e ) {
            e.stopPropagation();
            e.preventDefault();
            return false;
        }

        // Handles a click on the add button
        function clicked_add( e ) {
            if ( ! options.maxRows || ( rows < options.maxRows ) ) {
add_row();
}
            return nothing( e );
        }

        // Handles a click event on the remove button
        function clicked_del( e ) {
            if ( 1 < rows ) {
del_row();
}
            return nothing( e );
        }

        // Update the buttons
        update_buttons();

    };
    return this;
}() );

// 3. custom
var FontAwesomeIcons;

( function( $ ) {
    'use strict';

    FontAwesomeIcons = function() {
        var html = '';

        $.each( stIconObj.fontawesome, function( cat, icons ) {
            html += '<span class="icon-category">' + cat + '</span>';

            icons.map( function( icon ) {
                html += '<i class="' + icon.style + ' fa-' + icon.id + '" data-icon-id="' + icon.id + '" data-style="' + icon.style + '"></i>';
            });
        });

        return html;
    };

}( jQuery ) );

jQuery( document ).ready( function( $ ) {
    var stags = {
        loadVals: function() {
            var shortcode = $( '#_stag_shortcode' ).text(),
                uShortcode = shortcode;

            // fill in the gaps eg {{param}}
            $( '.stag-input' ).each( function() {
                var input = $( this ),
                    id = input.attr( 'id' ),
                    id = id.replace( 'stag_', '' ),       // gets rid of the stag_ prefix
                    re = new RegExp( '{{' + id + '}}', 'g' );

                uShortcode = uShortcode.replace( re, input.val() );
            });

            // adds the filled-in shortcode as hidden input
            $( '#_stag_ushortcode' ).remove();
            $( '#stag-sc-form-table' ).prepend( '<div id="_stag_ushortcode" class="hidden">' + uShortcode + '</div>' );
        },

        cLoadVals: function() {
            var shortcode = $( '#_stag_cshortcode' ).text(),
                pShortcode = '';
                shortcodes = '';

            // fill in the gaps eg {{param}}
            $( '.child-clone-row' ).each( function() {
                var row = $( this ),
                    rShortcode = shortcode;

                $( '.stag-cinput', this ).each( function() {
                    var input = $( this ),
                        id = input.attr( 'id' ),
                        id = id.replace( 'stag_', '' );        // gets rid of the stag_ prefix
                        re = new RegExp( '{{' + id + '}}', 'g' );

                    rShortcode = rShortcode.replace( re, input.val() );
                });

                shortcodes = shortcodes + rShortcode + '\n';
            });

            // adds the filled-in shortcode as hidden input
            $( '#_stag_cshortcodes' ).remove();
            $( '.child-clone-rows' ).prepend( '<div id="_stag_cshortcodes" class="hidden">' + shortcodes + '</div>' );

            // add to parent shortcode
            this.loadVals();
            pShortcode = $( '#_stag_ushortcode' ).text().replace( '{{child_shortcode}}', shortcodes );

            // add updated parent shortcode
            $( '#_stag_ushortcode' ).remove();
            $( '#stag-sc-form-table' ).prepend( '<div id="_stag_ushortcode" class="hidden">' + pShortcode + '</div>' );
        },

        children: function() {

            // assign the cloning plugin
            $( '.child-clone-rows' ).appendo({
                subSelect: '> div.child-clone-row:last-child',
                allowDelete: false,
                focusFirst: false
            });

            // remove button
            $( '.child-clone-rows' ).on( 'click', '.child-clone-row-remove', function() {
                var btn = $( this ),
                    row = btn.parent();

                if ( 1 < $( '.child-clone-row' ).size() ) {
                    row.remove();
                } else {
                    alert( 'You need a minimum of one row' );
                }

                return false;
            });

            // assign jUI sortable
            $( '.child-clone-rows' ).sortable({
                placeholder: 'sortable-placeholder',
                items: '.child-clone-row'
            });
        },

        resizeTB: function() {
            var ajaxCont = $( '#TB_ajaxContent' ),
                tbWindow = $( '#TB_window' ),
                stagPopup = $( '#stag-popup' );

            tbWindow.css({
                height: stagPopup.outerHeight(),
                width: stagPopup.outerWidth(),
                marginLeft: -( stagPopup.outerWidth() / 2 ),
                maxHeight: '85%',
                overflowY: 'scroll'
            });

            ajaxCont.css({
                paddingTop: 0,
                paddingLeft: 0,
                paddingRight: 0,
                paddingBottom: 0,
                height: ( tbWindow.outerHeight() ),
                overflow: 'auto', // IMPORTANT
                width: stagPopup.outerWidth()
            });

            $( '#stag-popup' ).addClass( 'no_preview' );
        },

        media: function() {
            var stag_media_frame,
                frame_title,
                insertButton = $( '.stag-open-media' );

            if ( 'image' === insertButton.data( 'type' ) ) {
                frame_title = StagShortcodes.media_frame_image_title;
            } else if ( 'video' === insertButton.data( 'type' ) ) {
                frame_title = StagShortcodes.media_frame_video_title;
            }

            insertButton.on( 'click', function( e ) {
                e.preventDefault();

                if ( stag_media_frame ) {
                    stag_media_frame.open();
                    return;
                }

                stag_media_frame = wp.media.frames.stag_media_frame = wp.media({
                    className: 'media-frame stag-media-frame',
                    frame: 'select',
                    multiple: false,
                    title: frame_title,
                    library: {
                        type: insertButton.data( 'type' )
                    },
                    button: {
                        text: insertButton.data( 'text' )
                    }
                });

                stag_media_frame.on( 'select', function() {
                    var media_attachment = stag_media_frame.state().get( 'selection' ).first().toJSON();
                    $( '#stag_src' ).val( media_attachment.url );
                    $( '.stag-input' ).trigger( 'change' );
                });

                stag_media_frame.open();

            });
        },

        load: function() {
            var stags = this,
                tbWindow = $( '#TB_window' ),
                popup = $( '#stag-popup' ),
                form = $( '#stag-sc-form', popup ),
                shortcode = $( '#_stag_shortcode', form ).text(),
                popupType = $( '#_stag_popup', form ).text(),
                uShortcode = '',
                iconSelector = $( '.stag-all-icons' ).find( 'i' ),
                closePopup = $( '#close-popup' );

            closePopup.on( 'click', function() {
                tb_remove();
            });

            // resize TB
            stags.resizeTB();
            $( window ).resize( function() {
 stags.resizeTB();
});

            tbWindow.css({
                border: 'none'
            });

            tbWindow.find( '#TB_title' ).remove();

            // initialise
            stags.loadVals();
            stags.children();
            stags.cLoadVals();
            stags.media();

            // update on children value change
            $( '.child-clone-rows', form ).on( 'change', '.stag-cinput', function() {
                stags.cLoadVals();
            });

            // update on value change
            $( '#stag-sc-form-table', form ).on( 'change', '.stag-input', function() {
                stags.loadVals();
            });

            var iconContainer = $( '.stag-all-icons' );
            iconContainer.append( FontAwesomeIcons() );

            iconContainer.on( 'click', 'i', function( e ) {
                iconContainer.find( 'i' ).removeClass( 'active-icon' );
                $( this ).addClass( 'active-icon' );
                $( '#stag_icon' ).val( $( this ).data( 'icon-id' ) );
                $( '#stag_style' ).val( $( this ).data( 'style' ) );
                $( '.stag-input' ).trigger( 'change' );
            });

            $( '.stag-control-buttonset' ).buttonset();
            $( '.stag-control-buttonset' ).on( 'change', 'input', function( e ) {
                var id = $( this ).data( 'key' );
                $( '#' + id ).val( $( this ).val() );
                $( '.stag-input' ).trigger( 'change' );
            });

            // when insert is clicked
            $( '.stag-insert', form ).click( function() {
                if ( window.tinyMCE ) {
                    var version = tinyMCE.majorVersion;

                    if ( '3' === version ) {
                        window.tinyMCE.execInstanceCommand( window.tinyMCE.activeEditor.id, 'mceInsertContent', false, $( '#_stag_ushortcode', form ).html() );
                        tb_remove();
                    } else if ( '4' === version ) {
                        window.tinyMCE.activeEditor.insertContent( $( '#_stag_ushortcode', form ).html() );
                        tb_remove();
                    }

                }
            });
        }
    };

    // run
    $( 'body' ).on( 'DOMNodeInserted', '#stag-popup', function(e) {
        if ($(e.target).attr('id') === 'stag-popup') {
            stags.load();
        }
    } );
});

var __ = wp.i18n.__;

window.StagLang = {
    insert: __( 'Insert Stag Shortcode', 'stag' ),
    button: __( 'Buttons', 'stag' ),
    columns: __( 'Columns', 'stag' ),
    tabs: __( 'Tabs', 'stag' ),
    toggle: __( 'Toggle', 'stag' ),
    dropcap: __( 'Dropcap', 'stag' ),
    icon: __( 'Font Icon', 'stag' ),
    media_elements: __( 'Media Elements', 'stag' ),
    widget_area: __( 'Widget Area', 'stag' ),
    image: __( 'Image', 'stag' ),
    video: __( 'Video', 'stag' ),
    map: __( 'Google Map', 'stag' )
};
