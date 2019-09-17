(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$( window ).load(function() {
		var input = $('#_sku');
		var regular_price = $('#_regular_price');
		var sale_price = $('#_sale_price');
		var stock = $('#_stock');
		var manage_stock = $('#_manage_stock');
		input.change(function (){
			$.ajax({
				url: `${WPURLS.siteurl}/wp-json/importopencardfeed/v1/find/${$(this).val()}`,
				type: 'GET',
				beforeSend: function() {
					loading();	
				},
				success: function( data ) {
					stop();
					regular_price.val(data.max_price).attr({'disabled': true});
					sale_price.val(data.min_price).attr({'disabled': true});
					stock.val(1).attr({'disabled': true});
					manage_stock.attr({'checked': true}).attr({'disabled': true});
				},
				error: function() { 
					stop();
					regular_price.attr({'disabled': false});
					sale_price.attr({'disabled': false});
					stock.attr({'disabled': false});
					manage_stock.attr({'disabled': false});
                }
			});
		});
		function loading() {
			if(!$("#loading")) {
				$("body").append(`
					<div id="loading" style="
						position: fixed;
						top: 0;
						right: 0;
						bottom: 0;
						left: 0;
						background: rgba(0,0,0,0.5);
						z-index: 9999;
						display: block;
					">
					</div>
				`);
			}
        }
		function stop() {
			if(!$("#loading")) {
				return;
			}
			$("#loading").css("display","none");
        }
		
	});
})( jQuery );
