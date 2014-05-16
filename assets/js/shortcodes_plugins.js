/**
 * Table of Contents
 *
 * 1. jQuery Live Query
 * 2. jQuery Appendo
 * 3. base64.js
 * 4. custom
 *
 */

// 1. jQuery Live Query
(function(a){a.extend(a.fn,{livequery:function(e,d,c){var b=this,f;if(a.isFunction(e)){c=d,d=e,e=undefined}a.each(a.livequery.queries,function(g,h){if(b.selector==h.selector&&b.context==h.context&&e==h.type&&(!d||d.$lqguid==h.fn.$lqguid)&&(!c||c.$lqguid==h.fn2.$lqguid)){return(f=h)&&false}});f=f||new a.livequery(this.selector,this.context,e,d,c);f.stopped=false;f.run();return this},expire:function(e,d,c){var b=this;if(a.isFunction(e)){c=d,d=e,e=undefined}a.each(a.livequery.queries,function(f,g){if(b.selector==g.selector&&b.context==g.context&&(!e||e==g.type)&&(!d||d.$lqguid==g.fn.$lqguid)&&(!c||c.$lqguid==g.fn2.$lqguid)&&!this.stopped){a.livequery.stop(g.id)}});return this}});a.livequery=function(b,d,f,e,c){this.selector=b;this.context=d;this.type=f;this.fn=e;this.fn2=c;this.elements=[];this.stopped=false;this.id=a.livequery.queries.push(this)-1;e.$lqguid=e.$lqguid||a.livequery.guid++;if(c){c.$lqguid=c.$lqguid||a.livequery.guid++}return this};a.livequery.prototype={stop:function(){var b=this;if(this.type){this.elements.unbind(this.type,this.fn)}else{if(this.fn2){this.elements.each(function(c,d){b.fn2.apply(d)})}}this.elements=[];this.stopped=true},run:function(){if(this.stopped){return}var d=this;var e=this.elements,c=a(this.selector,this.context),b=c.not(e);this.elements=c;if(this.type){b.bind(this.type,this.fn);if(e.length>0){a.each(e,function(f,g){if(a.inArray(g,c)<0){a.event.remove(g,d.type,d.fn)}})}}else{b.each(function(){d.fn.apply(this)});if(this.fn2&&e.length>0){a.each(e,function(f,g){if(a.inArray(g,c)<0){d.fn2.apply(g)}})}}}};a.extend(a.livequery,{guid:0,queries:[],queue:[],running:false,timeout:null,checkQueue:function(){if(a.livequery.running&&a.livequery.queue.length){var b=a.livequery.queue.length;while(b--){a.livequery.queries[a.livequery.queue.shift()].run()}}},pause:function(){a.livequery.running=false},play:function(){a.livequery.running=true;a.livequery.run()},registerPlugin:function(){a.each(arguments,function(c,d){if(!a.fn[d]){return}var b=a.fn[d];a.fn[d]=function(){var e=b.apply(this,arguments);a.livequery.run();return e}})},run:function(b){if(b!=undefined){if(a.inArray(b,a.livequery.queue)<0){a.livequery.queue.push(b)}}else{a.each(a.livequery.queries,function(c){if(a.inArray(c,a.livequery.queue)<0){a.livequery.queue.push(c)}})}if(a.livequery.timeout){clearTimeout(a.livequery.timeout)}a.livequery.timeout=setTimeout(a.livequery.checkQueue,20)},stop:function(b){if(b!=undefined){a.livequery.queries[b].stop()}else{a.each(a.livequery.queries,function(c){a.livequery.queries[c].stop()})}}});a.livequery.registerPlugin("append","prepend","after","before","wrap","attr","removeAttr","addClass","removeClass","toggleClass","empty","remove","html");a(function(){a.livequery.play()})})(jQuery);

// 2. jQuery.appendo
/**
 * Appendo Plugin for jQuery v1.01
 * Creates interface to create duplicate clones of last table row (usually for forms)
 * (c) 2008 Kelly Hallman. Free software released under MIT License.
 * See http://deepliquid.com/content/Appendo.html for more info
 */

// Attach appendo as a jQuery plugin
jQuery.fn.appendo = function(opt)
{
    this.each(function() { jQuery.appendo.init(this,opt); });
    return this;
};

// appendo namespace
jQuery.appendo = function() {

    // Create a closure so that we can refer to "this" correctly down the line
    var myself = this;

    // Global Options
    // These can be set with inline Javascript like so:
    // jQuery.appendo.opt.maxRows = 5;
    // $.appendo.opt.allowDelete = false;
    // (no need, in fact you shouldn't, wrap in jQuery(document).ready() etc)
    this.opt = { };

    this.init = function(obj,opt) {

        // Extend the defaults with global options and options given, if any
        var options = jQuery.extend({
                labelAdd:       'Add Row',
                labelDel:       'Remove',
                allowDelete:    true,
                // copyHandlers does not seem to work
                // it's been removed from the docs for now...
                copyHandlers:   false,
                focusFirst:     true,
                onAdd:          function() { return true; },
                onDel:      function() { return true; },
                maxRows:        0,
                wrapClass:      'appendoButtons',
                wrapStyle:      { padding: '.4em .2em .5em' },
                buttonStyle:    { marginRight: '.5em' },
                subSelect:      'tr:last'
            },
            myself.opt,
            opt
        );

        // Store clone of last table row
        var $cpy = jQuery(obj).find(options.subSelect).clone(options.copyHandlers);
        // We consider this starting off with 1 row
        var rows = 1;
        // Create two button objects
        var $add_btn = jQuery('#form-child-add').click(clicked_add),
            $del_btn = new_button(options.labelDel).click(clicked_del).hide()
        ;

        // Append a row to table instance
        function add_row()
        {
            var $dup = $cpy.clone(options.copyHandlers);
            $dup.appendTo(obj);
            update_buttons(1);
            if (typeof(options.onAdd) == "function") options.onAdd($dup);
            if (!!options.focusFirst) $dup.find('input:first').focus();
        };

        // Remove last row from table instance
        function del_row()
        {
            var $row = jQuery(obj).find(options.subSelect);
            if ((typeof(options.onDel) != "function") || options.onDel($row))
            {
                $row.remove();
                update_buttons(-1);
            }
        };

        // Updates the button states after rows change
        function update_buttons(rowdelta)
        {
            // Update rows if a delta is provided
            rows = rows + (rowdelta || 0);
            // Disable the add button if maxRows is set and we have that many rows
            // $add_btn.attr('disabled',(!options.maxRows || (rows < options.maxRows))?false:true);
            // Show remove button if we've added rows and allowDelete is set
            (options.allowDelete && (rows > 1))? $del_btn.show(): $del_btn.hide();
        };

        // Returns (jQuery) button objects with label
        function new_button(label)
        {
            return jQuery('<button />')
                .css(options.buttonStyle)
                .html(label);
        };

        // This function can be returned to kill a received event
        function nothing(e)
        {
            e.stopPropagation();
            e.preventDefault();
            return false;
        };

        // Handles a click on the add button
        function clicked_add(e)
        {
            if (!options.maxRows || (rows < options.maxRows)) add_row();
            return nothing(e);
        };

        // Handles a click event on the remove button
        function clicked_del(e)
        {
            if (rows > 1) del_row();
            return nothing(e);
        };

        // Add the buttons after the table instance
        /*
        jQuery('<div />')
            .addClass(options.wrapClass)
            .css(options.wrapStyle)
            .append( $add_btn, $del_btn )
            .insertAfter(obj);
        */

        // Update the buttons
        update_buttons();

    };
    return this;
}();

// 3. base64.js
function base64_decode(h){var d="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";var c,b,a,m,l,k,j,n,g=0,o=0,e="",f=[];if(!h){return h}h+="";do{m=d.indexOf(h.charAt(g++));l=d.indexOf(h.charAt(g++));k=d.indexOf(h.charAt(g++));j=d.indexOf(h.charAt(g++));n=m<<18|l<<12|k<<6|j;c=n>>16&255;b=n>>8&255;a=n&255;if(k==64){f[o++]=String.fromCharCode(c)}else{if(j==64){f[o++]=String.fromCharCode(c,b)}else{f[o++]=String.fromCharCode(c,b,a)}}}while(g<h.length);e=f.join("");e=this.utf8_decode(e);return e}function base64_encode(h){var d="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";var c,b,a,m,l,k,j,n,g=0,o=0,f="",e=[];if(!h){return h}h=this.utf8_encode(h+"");do{c=h.charCodeAt(g++);b=h.charCodeAt(g++);a=h.charCodeAt(g++);n=c<<16|b<<8|a;m=n>>18&63;l=n>>12&63;k=n>>6&63;j=n&63;e[o++]=d.charAt(m)+d.charAt(l)+d.charAt(k)+d.charAt(j)}while(g<h.length);f=e.join("");switch(h.length%3){case 1:f=f.slice(0,-2)+"==";break;case 2:f=f.slice(0,-1)+"=";break}return f}function utf8_decode(a){var c=[],e=0,g=0,f=0,d=0,b=0;a+="";while(e<a.length){f=a.charCodeAt(e);if(f<128){c[g++]=String.fromCharCode(f);e++}else{if(f>191&&f<224){d=a.charCodeAt(e+1);c[g++]=String.fromCharCode(((f&31)<<6)|(d&63));e+=2}else{d=a.charCodeAt(e+1);b=a.charCodeAt(e+2);c[g++]=String.fromCharCode(((f&15)<<12)|((d&63)<<6)|(b&63));e+=3}}}return c.join("")}function utf8_encode(a){var h=(a+"");var i="",b,e,c=0;b=e=0;c=h.length;for(var d=0;d<c;d++){var g=h.charCodeAt(d);var f=null;if(g<128){e++}else{if(g>127&&g<2048){f=String.fromCharCode((g>>6)|192)+String.fromCharCode((g&63)|128)}else{f=String.fromCharCode((g>>12)|224)+String.fromCharCode(((g>>6)&63)|128)+String.fromCharCode((g&63)|128)}}if(f!==null){if(e>b){i+=h.slice(b,e)}i+=f;b=e=d+1}}if(e>b){i+=h.slice(b,c)}return i};

// 4. custom
jQuery(document).ready(function($) {
    var stags = {
        loadVals: function()
        {
            var shortcode = $('#_stag_shortcode').text(),
                uShortcode = shortcode;

            // fill in the gaps eg {{param}}
            $('.stag-input').each(function() {
                var input = $(this),
                    id = input.attr('id'),
                    id = id.replace('stag_', ''),       // gets rid of the stag_ prefix
                    re = new RegExp("{{"+id+"}}","g");

                uShortcode = uShortcode.replace(re, input.val());
            });

            // adds the filled-in shortcode as hidden input
            $('#_stag_ushortcode').remove();
            $('#stag-sc-form-table').prepend('<div id="_stag_ushortcode" class="hidden">' + uShortcode + '</div>');

        },
        cLoadVals: function()
        {
            var shortcode = $('#_stag_cshortcode').text(),
                pShortcode = '';
                shortcodes = '';

            // fill in the gaps eg {{param}}
            $('.child-clone-row').each(function() {
                var row = $(this),
                    rShortcode = shortcode;

                $('.stag-cinput', this).each(function() {
                    var input = $(this),
                        id = input.attr('id'),
                        id = id.replace('stag_', '')        // gets rid of the stag_ prefix
                        re = new RegExp("{{"+id+"}}","g");

                    rShortcode = rShortcode.replace(re, input.val());
                });

                shortcodes = shortcodes + rShortcode + "\n";
            });

            // adds the filled-in shortcode as hidden input
            $('#_stag_cshortcodes').remove();
            $('.child-clone-rows').prepend('<div id="_stag_cshortcodes" class="hidden">' + shortcodes + '</div>');

            // add to parent shortcode
            this.loadVals();
            pShortcode = $('#_stag_ushortcode').text().replace('{{child_shortcode}}', shortcodes);

            // add updated parent shortcode
            $('#_stag_ushortcode').remove();
            $('#stag-sc-form-table').prepend('<div id="_stag_ushortcode" class="hidden">' + pShortcode + '</div>');
        },
        children: function()
        {
            // assign the cloning plugin
            $('.child-clone-rows').appendo({
                subSelect: '> div.child-clone-row:last-child',
                allowDelete: false,
                focusFirst: false
            });

            // remove button
            $('.child-clone-row-remove').live('click', function() {
                var btn = $(this),
                    row = btn.parent();

                if( $('.child-clone-row').size() > 1 )
                {
                    row.remove();
                }
                else
                {
                    alert('You need a minimum of one row');
                }

                return false;
            });

            // assign jUI sortable
            $( ".child-clone-rows" ).sortable({
                placeholder: "sortable-placeholder",
                items: '.child-clone-row'

            });
        },
        resizeTB: function()
        {
            var ajaxCont = $('#TB_ajaxContent'),
                tbWindow = $('#TB_window'),
                stagPopup = $('#stag-popup');

            tbWindow.css({
                height: stagPopup.outerHeight(),
                width: stagPopup.outerWidth(),
                marginLeft: -(stagPopup.outerWidth()/2),
                maxHeight: "85%",
                overflowY: "scroll"
            });

            ajaxCont.css({
                paddingTop: 0,
                paddingLeft: 0,
                paddingRight: 0,
                paddingBottom: 0,
                height: (tbWindow.outerHeight()),
                overflow: 'auto', // IMPORTANT
                width: stagPopup.outerWidth(),
            });

            $('#stag-popup').addClass('no_preview');
        },

        media: function(){
            var stag_media_frame,
                frame_title,
                insertButton = $('.stag-open-media');

            if ( insertButton.data('type') === "image" ) {
                frame_title = StagShortcodes.media_frame_image_title;
            } else if ( insertButton.data('type') === "video" ) {
                frame_title = StagShortcodes.media_frame_video_title;
            }

            insertButton.on('click', function(e){
                e.preventDefault();

                if(stag_media_frame){
                    stag_media_frame.open();
                    return;
                }

                stag_media_frame = wp.media.frames.stag_media_frame = wp.media({
                    className: 'media-frame stag-media-frame',
                    frame: 'select',
                    multiple: false,
                    title: frame_title,
                    library: {
                        type: insertButton.data('type')
                    },
                    button: {
                        text: insertButton.data('text')
                    }
                });

                stag_media_frame.on('select', function(){
                    var media_attachment = stag_media_frame.state().get('selection').first().toJSON();
                    $('#stag_src').val(media_attachment.url);
                    $('.stag-input').trigger('change');
                });

                stag_media_frame.open();

            });
        },

        load: function()
        {
            var stags = this,
                tbWindow = $('#TB_window'),
                popup = $('#stag-popup'),
                form = $('#stag-sc-form', popup),
                shortcode = $('#_stag_shortcode', form).text(),
                popupType = $('#_stag_popup', form).text(),
                uShortcode = '',
                iconSelector = $('.stag-all-icons').find('i'),
                closePopup = $('#close-popup');

            closePopup.on('click', function(){
                tb_remove();
            });

            // resize TB
            stags.resizeTB();
            $(window).resize(function() { stags.resizeTB() });

            tbWindow.css({
                border: "none",
            });

            tbWindow.find('#TB_title').remove();

            // initialise
            stags.loadVals();
            stags.children();
            stags.cLoadVals();
            stags.media();

            // update on children value change
            $('.stag-cinput', form).live('change', function() {
                stags.cLoadVals();
            });

            // update on value change
            $('.stag-input', form).live('change', function() {
                stags.loadVals();
            });

            // font icon selection thing
            iconSelector.on('click', function(){
                iconSelector.removeClass('active-icon');
                $(this).addClass('active-icon');
                $('#stag_icon').val( $(this).data('icon-id') );
                $('.stag-input').trigger('change');
            });

            // when insert is clicked
            $('.stag-insert', form).click(function() {
                if(window.tinyMCE) {
                    var version = tinyMCE.majorVersion;

                    if ( version === '3' ) {
                        window.tinyMCE.execInstanceCommand( window.tinyMCE.activeEditor.id, 'mceInsertContent', false, $('#_stag_ushortcode', form).html());
                        tb_remove();
                    } else if ( version === '4' ) {
                        window.tinyMCE.activeEditor.insertContent( $('#_stag_ushortcode', form).html() );
                        tb_remove();
                    }

                }
            });
        }
    }

    // run
    $('#stag-popup').livequery( function() { stags.load(); } );
});
