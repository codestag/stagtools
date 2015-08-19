/* jshint node:true */
module.exports = function( grunt ) {
	var _ = require( 'lodash' );

	// Load all Grunt tasks
	require( 'load-grunt-tasks' )( grunt );

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON( 'package.json' ),
		// jshint: {
		// 	options: grunt.file.readJSON( '.jshintrc' ),
		// 	grunt: {
		// 		src: [
		// 			'Gruntfile.js'
		// 		]
		// 	}
		// },
		clean:{
			assets: {
				src: [ 'assets/temp' ]
			}
		},
		yaml: {
			fontawesome: {
				files: [
					{
						expand: true,
						cwd: 'assets',
						src: 'icons*.yml',
						dest: 'assets/temp'
					}
				]
			}
		},
		json_massager: {
			fontawesome: {
				modifier: function( json ) {
					var icons = json.icons,
						newObj = {};

					_.forEach( icons, function( data ) {
						_.forEach( data.categories, function( category ) {
							if ( 'undefined' === typeof newObj[category] ) {
								newObj[category] = [];
							}
							var icon = {
								name: data.name,
								id: 'fa-' + data.id,
								unicode: data.unicode
							};
							newObj[category].push( icon );
						} );
					} );

					_.forEach( newObj, function( category ) {
						category.sort( function( a, b ) {
							if (a.name.toLowerCase() > b.name.toLowerCase()) {
								return 1;
							}
							if (a.name.toLowerCase() < b.name.toLowerCase()) {
								return -1;
							}
							return 0;
						} );
					} );

					return newObj;
				},
				files: {
					'assets/temp/fontawesome.json': [ 'assets/temp/icons*.json' ]
				}
			}
		},
		json: {
			fontawesome: {
				options: {
					namespace: 'stIconObj',
					processName: function( filename ) {
						return filename.toLowerCase();
					}
				},
				src: [ 'assets/temp/fontawesome.json' ],
				dest: 'assets/js/icons.js'
			}
		},
		makepot: {
			target: {
				options: {
					cwd: '',
					potFilename: 'stagtools.pot',
					exclude: ['includes/widgets/lib/.*'],
					type: 'wp-plugin',
					processPot: function( pot, options ) {
						pot.headers['report-msgid-bugs-to'] = 'https://codestag.com/support/';
						pot.headers['last-translator'] = 'Codestag';
						pot.headers['language-team'] = 'Codestag';
						return pot;
					}
				}
			}
		},
	});

	// Process the icons YAML file
	grunt.registerTask( 'fontawesome', [
		'yaml:fontawesome',
		'json_massager:fontawesome',
		'json:fontawesome',
		'clean:assets'
	] );
};
