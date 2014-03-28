(function(){
	tinymce.create( "tinymce.plugins.stagShortcodes", {

		init: function ( d, e ) {
			d.addCommand("stagPopup", function( a, params){
				var popup = params.identifier;

				// load thickbox
				tb_show("Insert Stag Shortcode", ajaxurl + "?action=popup&popup=" + popup + "&width=" + 670 );
			});
		},

		createControl: function( d, e ){
			var ed = tinymce.activeEditor,
				IsSCSActive = ( typeof StagShortcodes !== 'undefined' && StagShortcodes.is_scs_active === "1") ? true : false;

			if( d === "stagShortcodes" ){
				d = e.createMenuButton( "stagShortcodes", {
					title: ed.getLang('stag.insert'),
					icons: false
				});

				var a = this;
				d.onRenderMenu.add( function( c, b ) {

					c = b.addMenu( { title:ed.getLang('stag.media_elements') } );
						a.addWithPopup( c, ed.getLang('stag.image'), "image" );
						a.addWithPopup( c, ed.getLang('stag.video'), "video" );

					if(IsSCSActive){
						a.addWithPopup( b, ed.getLang('stag.widget_area'), "widget_area" );
					}

					b.addSeparator();

					a.addWithPopup( b, ed.getLang('stag.alert'), "alert" );
					a.addWithPopup( b, ed.getLang('stag.button'), "button" );
					a.addWithPopup( b, ed.getLang('stag.columns'), "columns" );
					a.addWithPopup( b, ed.getLang('stag.divider'), "divider" );
					a.addWithPopup( b, ed.getLang('stag.dropcap'), "dropcap" );
					a.addWithPopup( b, ed.getLang('stag.intro'), "intro" );
					a.addWithPopup( b, ed.getLang('stag.tabs'), "tabs" );
					a.addWithPopup( b, ed.getLang('stag.toggle'), "toggle" );
					a.addWithPopup( b, ed.getLang('stag.icon'), "icon" );
					a.addWithPopup( b, ed.getLang('stag.map'), "map" );

				});

				return d;

			}
			return null;
		},

		addWithPopup: function (d, e, a){
			d.add({
				title: e,
				onclick: function() {
					tinyMCE.activeEditor.execCommand( "stagPopup", false, {
						title: e,
						identifier: a
					})
				}
			});
		},

		addImmediate:function(d,e,a){
			d.add({
				title:e,
				onclick:function(){
					tinyMCE.activeEditor.execCommand( "mceInsertContent",false,a)
				}
			})
		}

	});

	tinymce.PluginManager.add( "stagShortcodes", tinymce.plugins.stagShortcodes);

})();
