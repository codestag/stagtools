tinymce.PluginManager.add('stagShortcodes', function(editor, url) {

	editor.addCommand( 'stagPopup', function( ui, v ){
		var popup = v.identifier;

		// load thickbox
		tb_show( editor.getLang('stag.insert'), ajaxurl + "?action=popup&popup=" + popup + "&width=" + 670 );
	});

    editor.addButton('stagShortcodes', {
		icon: false,
		text: 'StagTools',
		tooltip: editor.getLang('stag.insert'),
		type: 'menubutton',
		menu: [
	        { text: editor.getLang('stag.media_elements'), menu: [
		        { text: editor.getLang('stag.image'), onclick: function(e){ addPopup('image') } },
		        { text: editor.getLang('stag.video'), onclick: function(e){ addPopup('video') } },
	        ] },
	        { onclick: function(e){ addPopup('alert') }, text: editor.getLang('stag.alert') },
	        { onclick: function(e){ addPopup('button') }, text: editor.getLang('stag.button') },
	        { onclick: function(e){ addPopup('columns') }, text: editor.getLang('stag.columns') },
	        { onclick: function(e){ addPopup('divider') }, text: editor.getLang('stag.divider') },
	        { onclick: function(e){ addPopup('dropcap') }, text: editor.getLang('stag.dropcap') },
	        { onclick: function(e){ addPopup('intro') }, text: editor.getLang('stag.intro') },
	        { onclick: function(e){ addPopup('tabs') }, text: editor.getLang('stag.tabs') },
	        { onclick: function(e){ addPopup('toggle') }, text: editor.getLang('stag.toggle') },
	        { onclick: function(e){ addPopup('icon') }, text: editor.getLang('stag.icon') },
	        { onclick: function(e){ addPopup('map') }, text: editor.getLang('stag.map') }
        ]
	});

	function addPopup( shortcode ) {
		tinyMCE.activeEditor.execCommand( "stagPopup", false, {
			title: tinyMCE.activeEditor.getLang('stag.insert'),
			identifier: shortcode
		});
	}
});
