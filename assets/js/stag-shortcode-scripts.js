(function($){
	
	"use strict";

	$(document).ready(function(){
		$(".stag-tabs").tabs({
			hide: { effect: "fadeOut", duration: 200 },
			show: { effect: "fadeIn", duration: 200 }
		});

		$(".stag-toggle").each( function () {
			if($(this).attr('data-id') == 'closed') {
				$(this).accordion({ header: '.stag-toggle-title', collapsible: true, heightStyle: "content", active: false });
			} else {
				$(this).accordion({ header: '.stag-toggle-title', collapsible: true, heightStyle: "content" });
			}
		});
	});

})(jQuery);

var Stagtools = {};

Stagtools.Map = ( function($) {
	function setupMap(options) {
		var mapOptions, mapElement, map, marker;

		if( typeof google === 'undefined' ) return;

		mapOptions = {
			zoom: parseFloat(options.zoom),
			center: new google.maps.LatLng(options.center.lat, options.center.long),
			scrollwheel: false,
			styles: options.styles
		};

		mapElement = document.getElementById(options.id);
	 	map = new google.maps.Map(mapElement, mapOptions);

		marker = new google.maps.Marker({
			position: new google.maps.LatLng(options.center.lat, options.center.long),
			map: map
		});
	}
	return {
		init: function(options) {
			setupMap(options);
		}
	}
} )(jQuery);
