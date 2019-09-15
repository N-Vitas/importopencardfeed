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
			if ($(this).val() == 'aaaaaa') {
				regular_price.val(25000).attr({'disabled': true});
				sale_price.val(23000).attr({'disabled': true});
				stock.val(100).attr({'disabled': true});
				manage_stock.attr({'checked': true}).attr({'disabled': true});
			} else {
				regular_price.attr({'disabled': false});
				sale_price.attr({'disabled': false});
				stock.attr({'disabled': false});
				manage_stock.attr({'disabled': false});
			}
		});
	
		
	});
})( jQuery );
