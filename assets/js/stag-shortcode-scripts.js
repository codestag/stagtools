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
