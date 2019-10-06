(function( $ ) {
	'use strict';
    $.fn.importReplacePlugin = function(input, regular_price, sale_price, stock, manage_stock) {
		if(typeof input === "string" && input.length == 0) {
			throw new Error('Input required parameter!');
		}
		if(typeof regular_price === "string" && regular_price.length == 0) {
			throw new Error('RegularPrice required parameter!');
		}
		if(typeof sale_price === "string" && sale_price.length == 0) {
			throw new Error('SalePrice required parameter!');
		}
		if(typeof stock === "string" && stock.length == 0) {
			throw new Error('Stock required parameter!');
		}
		if(typeof manage_stock === "string" && manage_stock.length == 0) {
			throw new Error('ManageStock required parameter!');
		}
		return this.each(function(){
			var $this = $(this);
			var success = function(data) {
				var val = $this.input.val();
				// var sale_price = $this.sale_price.val();
				// console.log(val, data.sku, sale_price);
				if(val != data.sku) {
					clear();
					return $this;
				}
				$this.regular_price.val(data.max_price);//.attr({'disabled': true});
				// $this.sale_price.val(data.min_price-1);//.attr({'disabled': true});
				// $this.stock.val(1).attr({'disabled': true});
				// $this.manage_stock.attr({'checked': true}).attr({'disabled': true});
				// $.apply($this);
			}
			var clear = function() {
				console.log($this.input.val());
				// $this.regular_price.attr({'disabled': false});
				// $this.sale_price.attr({'disabled': false});
				// $this.stock.attr({'disabled': false});
				// $this.manage_stock.attr({'disabled': false});
			}
			var query = function() {

			}
			$(this).change(function() {
				if(input.indexOf('#') != -1) {
					$this.input = $(input);
					$this.regular_price = $(regular_price);
					// $this.sale_price = $(sale_price);
					$this.stock = $(stock);
					$this.manage_stock = $(manage_stock);
				} else {
					$this.input = $(this).find(`input[name=${input}]`);
					$this.regular_price = $(this).find(`input[name=${regular_price}]`);
					// $this.sale_price = $(this).find(`input[name=${sale_price}]`);
					$this.stock = $(this).find(`input[name=${stock}]`);
					$this.manage_stock = $(this).find(`input[name=${manage_stock}]`);
				}
				$.ajax({
					url: `${WPURLS.siteurl}/wp-json/importopencardfeed/v1/find/${$this.input.val()}`,
					type: 'GET',
					beforeSend: function() {
						// loading();	
					},
					success: function(data) {success(data)},
					error: function() {clear()},
				});
			})
		});
	}
	$( window ).load(function() {
		
		$('form').each(function(i,form){
			$(form).importReplacePlugin('_sku','_regular_price','_sale_price','_stock','_manage_stock');
		});
		// if(location.search.indexOf('edit') != -1){
		// 	$('form').importReplacePlugin('#_sku','#_regular_price','#_sale_price','#_stock','#_manage_stock').trigger('change');
		// }
		// if(location.search.indexOf('product') != -1){

		// 	$('#posts-filter').importReplacePlugin('_sku','_regular_price','_sale_price','_stock','_manage_stock');
		// }
		// $('form[method=get]').importReplacePlugin('_sku','_regular_price','_sale_price','_stock','_manage_stock');
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

class ImportReplacePlugin {
    constructor(params) {
		this.params = params;
		input
		regular_price
		sale_price
		stock
		manage_stock
    }
}