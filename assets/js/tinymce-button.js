(function(tinymce) {
	tinymce.PluginManager.add('stagtools_mce_hr_button', function( editor, url ) {
		editor.addButton('stagtools_mce_hr_button', {
			icon: 'hr',
			tooltip: 'Horizontal line',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert Horizontal Line',
					body: [
						{
							type: 'listbox',
							name: 'hr',
							label: 'Style',
							values: [
								{
									text: 'Plain',
									value: 'stag-divider--plain'
								},
								{
									text: 'Strong',
									value: 'stag-divider--strong'
								},
								{
									text: 'Double',
									value: 'stag-divider--double'
								},
								{
									text: 'Dashed',
									value: 'stag-divider--dashed'
								},
								{
									text: 'Dotted',
									value: 'stag-divider--dotted'
								}
							]
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '<hr class="stag-divider ' + e.data.hr + '" />');
					}
				});
			}
		});
	});
})(tinymce);
