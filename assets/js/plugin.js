/* eslint-disable */
tinymce.PluginManager.add('stagShortcodes', function(editor, url) {

	editor.addCommand( 'stagPopup', function( ui, v ){
		var popup = v.identifier;

		// load thickbox
		tb_show( StagLang.insert, ajaxurl + "?action=popup&popup=" + popup + "&width=" + 670 );
	});

	var menu_items = [
        { text: StagLang.media_elements, menu: [
	        { text: StagLang.image, onclick: function(e){ addPopup('image') } },
	        { text: StagLang.video, onclick: function(e){ addPopup('video') } },
        ] },
        { onclick: function(e){ addPopup('widget_area') }, text: StagLang.widget_area },
        { onclick: function(e){ addPopup('button') }, text: StagLang.button },
        { onclick: function(e){ addPopup('columns') }, text: StagLang.columns },
        { onclick: function(e){ addPopup('dropcap') }, text: StagLang.dropcap },
        { onclick: function(e){ addPopup('tabs') }, text: StagLang.tabs },
        { onclick: function(e){ addPopup('toggle') }, text: StagLang.toggle },
        { onclick: function(e){ addPopup('icon') }, text: StagLang.icon },
        { onclick: function(e){ addPopup('map') }, text: StagLang.map }
    ];

    /**
     * Delete Widget area from object is Stag Custom Sidebars is not active.
     *
     * @link https://wordpress.org/plugins/stag-custom-sidebars/
     */
    var IsSCSActive = ( typeof StagShortcodes !== 'undefined' && StagShortcodes.is_scs_active === "1") ? true : false;

    if( !IsSCSActive ) {
    	delete menu_items[1];
    }

    editor.addButton('stagShortcodes', {
		icon: 'stagtools',
		text: false,
		tooltip: StagLang.insert,
		type: 'menubutton',
		menu: menu_items
	});

	function addPopup( shortcode ) {
		tinyMCE.activeEditor.execCommand( "stagPopup", false, {
			title: StagLang.insert,
			identifier: shortcode
		});
	}
});
