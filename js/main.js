window.onerror = function(message, url, linenumber) {
	var template = swig.compile(tpl.get('error'));
	$('#content').html(template({
		pagedata: {
			url: url,
			data: 'line '+ linenumber,
			message: 'JavaScript error: ' + message + ' on line ' + linenumber
		}
	}));
	$('#content').fadeIn();
	NProgress.done();
};
tpl = {
	templates: {},

	loadTemplates: function(names, callback) {
		var that = this;
		var loadTemplate = function(index) {
			var name = names[index];
			$.get(webroot + template_folder + name + '.template.html', function(data) {
				NProgress.inc();
				that.templates[name] = data;
				index++;
				if (index < names.length) {
					loadTemplate(index);
				} else {
					callback();
				}
			});
		}
		loadTemplate(0);
	},
	get: function(name) {
		$('.navItem, .parentNav, .On').removeClass('On');
		return this.templates[name];
	}
};
function utf8_encode(argString) {
  if (argString === null || typeof argString === 'undefined') {
    return '';
  }

  var string = (argString + '');
  var utftext = '',
    start, end, stringl = 0;

  start = end = 0;
  stringl = string.length;
  for (var n = 0; n < stringl; n++) {
    var c1 = string.charCodeAt(n);
    var enc = null;

    if (c1 < 128) {
      end++;
    } else if (c1 > 127 && c1 < 2048) {
      enc = String.fromCharCode(
        (c1 >> 6) | 192, (c1 & 63) | 128
      );
    } else if ((c1 & 0xF800) != 0xD800) {
      enc = String.fromCharCode(
        (c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
      );
    } else { // surrogate pairs
      if ((c1 & 0xFC00) != 0xD800) {
        throw new RangeError('Unmatched trail surrogate at ' + n);
      }
      var c2 = string.charCodeAt(++n);
      if ((c2 & 0xFC00) != 0xDC00) {
        throw new RangeError('Unmatched lead surrogate at ' + (n - 1));
      }
      c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
      enc = String.fromCharCode(
        (c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
      );
    }
    if (enc !== null) {
      if (end > start) {
        utftext += string.slice(start, end);
      }
      utftext += enc;
      start = end = n + 1;
    }
  }

  if (end > start) {
    utftext += string.slice(start, stringl);
  }

  return utftext;
}
$.fn.serializeObject = function(){
	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name] !== undefined) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};
jQuery.fn.vibrate = function (conf) {
	var config = jQuery.extend({
		speed:        30, 
		duration:    1000, 
		frequency:    0, 
		spread:        3
	}, conf);

	return this.each(function () {
		var t = jQuery(this);
		var vibrate = function () {
			var topPos    = Math.floor(Math.random() * config.spread) - ((config.spread - 1) / 2);
			var leftPos    = Math.floor(Math.random() * config.spread) - ((config.spread - 1) / 2);
			var rotate    = Math.floor(Math.random() * config.spread) - ((config.spread - 1) / 2);
			t.css({
				position:            'relative', 
				left:                leftPos + 'px', 
				top:                topPos + 'px', 
				WebkitTransform:    'rotate(' + rotate + 'deg)'
			});
		};
		var doVibration = function () {
			var vibrationInterval = setInterval(vibrate, config.speed);

			var stopVibration = function () {
				clearInterval(vibrationInterval);
				t.css({
					position:            'static', 
					WebkitTransform:    'rotate(0deg)'
				});
			};
			setTimeout(stopVibration, config.duration);
		};
		doVibration();
	});
};
function doAjaxRequest(url, type, data, callback){
	var request = $.ajax({
		type: type,
		url: webroot + url,
		data: { data: data },
		dataType: 'json',
		success: callback
	});
	request.fail(function(jqXHR, textStatus){
		showNotFoundPage(url, data, textStatus);
		console.log(jqXHR);
	});
}
function showNotFoundPage(url, data, textStatus){
	var template = swig.compile(tpl.get('404'));
		$('#content').html(template({
			pagedata: {
				url: url,
				data: data,
				message: textStatus
			}
		}));
		$('#content').fadeIn();
		NProgress.done();
}
function redirectToUrl(redirectUrl){
	window.location.replace(webroot + redirectUrl);
}
function loadShopContent(){
	NProgress.start();
	Backbone.history.navigate('');
	doAjaxRequest('shop_json', 'post', '', function(pagedata){
		var template = swig.compile(tpl.get('home'));
		$('#content').html(template({ pagedata: pagedata }));
		$('#content').fadeIn();
		NProgress.done();
	});
}
function loadCategory(category){
	NProgress.start();
	var url = 'category_json/' + category;
	var data = '';
	Backbone.history.navigate('category/' + category);
	$('#content').fadeOut();
	doAjaxRequest(url, 'post', data, function(pagedata){
		if(pagedata.category.id > 0){
			var template = swig.compile(tpl.get('category'));
			$('#content').html(template({ pagedata: pagedata }));
			$('#content').fadeIn();
			NProgress.done();
		}else{
			showNotFoundPage(url, data, 'Category not found');
		}
	});
}
function loadProduct(product){
	NProgress.start();
	var url = 'product_json/' + product;
	var data = '';
	Backbone.history.navigate('product/' + product);
	$('#content').fadeOut();
	doAjaxRequest(url, 'post', data, function(pagedata){
		if(pagedata.product.id > 0){
			var template = swig.compile(tpl.get('product'));
			$('#content').html(template({ pagedata: pagedata }));
			$('#content').fadeIn();
			NProgress.done();
		}else{
			showNotFoundPage(url, data, 'Product not found');
		}
	});
}
var usernav_template = '';
function loadUserCredentials(callback){
	NProgress.start();
	doAjaxRequest('auth_json/current', 'post', '', function(pagedata){
		if(pagedata.status == 0){
			$('#login_button').css('display', 'inline-block');
		}else if(pagedata.status == 1){
			var template = swig.compile(usernav_template);
			$('#user_controls_container').html(template({ pagedata: pagedata }));
			callback();
		}else{
			doAjaxRequest('logout', 'post', '', function(pagedata){
				alert('Invalid credentials, loggin out!');
			});
		}
	});
}
function aunthenticateFirst(){
	toastr.warning('Ingrese con su cuenta antes de continuar');
	showLoginPage();
}
function showLoginPage(){
	NProgress.start();
	var url = 'auth_json/providers';
	var data = '';
	Backbone.history.navigate('authentication');
	$('#content').fadeOut();
	doAjaxRequest(url, 'post', data, function(pagedata){
		if(pagedata.status == 1){
			var template = swig.compile(tpl.get('authentication'));
			$('#content').html(template({ pagedata: pagedata }));
			$('#content').fadeIn();
			NProgress.done();
		}else{
			showNotFoundPage(url, data, 'Error loading login providers');
		}
	});
}
function addToCart(product){
	var e = window.event;
	e.cancelBubble = true;
	if(e.stopPropagation){
		e.stopPropagation();
	}
	
	NProgress.start();
	doAjaxRequest('addcart_script/' + product, 'post', '', function(pagedata){
		if(pagedata.result == 1){
			$('#cart').vibrate();
			toastr.success('Producto agregado');
		}else if(pagedata.result == 2){
			toastr.info('El producto seleccionado ya se encuentra en el carrito');
		}
		
		if(pagedata.result != 1 && pagedata.result != 2){
			toastr.warning('Ocurrio un problema al agregar el producto seleccionado, por favor intentelo nuevamente o pongase en contacto con nosotros');
		}else{
			if(pagedata.quantity > 0){
				$('#cart').addClass('full');
				$('#cart_count').text('(' + pagedata.quantity + ')');
			}else{
				$('#cart').removeClass('full');
				$('#cart_count').text('');
			}
		}
		NProgress.done();
	});
}
function removeFromCart(product, name){
	if(confirm('Quitar ' + name + ' del carrito?')){
		NProgress.start();
		doAjaxRequest('removecart_script/' + product, 'post', '', function(pagedata){
			if(pagedata.result == 1){
				$('#cart').vibrate();
				toastr.success(name +' quitado');
				showShoppingCartContents();
			}else if(pagedata.result == 2){
				toastr.info(name + ' ya no se encuentra en el carrito');
			}
			
			if(pagedata.result != 1 && pagedata.result != 2){
				toastr.warning('Ocurrio un problema al quitar ' + name + ', por favor intentelo nuevamente o pongase en contacto con nosotros');
			}else{
				if(pagedata.quantity > 0){
					$('#cart').addClass('full');
					$('#cart_count').text('(' + pagedata.quantity + ')');
				}else{
					$('#cart').removeClass('full');
					$('#cart_count').text('');
				}
			}
			NProgress.done();
		});
	}
}
function removeProduct(product, name, category){
	if(confirm('Eliminar ' + name + '?')){
		NProgress.start();
		doAjaxRequest('product_remove_script/' + product, 'post', '', function(response){
			console.log(response);
			if(response.result == 1){
				toastr.success(name + ' eliminado correctamente');
				loadCategory(category);
			}else{
				toastr.warning('Ocurrio un problema al quitar' + name + ' por favor intentelo nuevamente o pongase en contacto con los desarrolladores');
			}
			NProgress.done();
		});
	}
}
function showShoppingCartContents(){
	NProgress.start();
	Backbone.history.navigate('cart');
	doAjaxRequest('cart_json', 'post', '', function(pagedata){
		var template = swig.compile(tpl.get('cart'));
		$('#content').html(template({ pagedata: pagedata }));
		$('#content').fadeIn();
		NProgress.done();
	});
}
function productsMostViewed(){
	NProgress.start();
	Backbone.history.navigate('popular');
	doAjaxRequest('products_most_viewed_json', 'post', '', function(pagedata){
		var template = swig.compile(tpl.get('popular'));
		$('#content').html(template({ pagedata: pagedata }));
		$('#content').fadeIn();
		NProgress.done();
	});
}
function productsNews(){
	NProgress.start();
	Backbone.history.navigate('news');
	doAjaxRequest('products_news_json', 'post', '', function(pagedata){
		var template = swig.compile(tpl.get('news'));
		$('#content').html(template({ pagedata: pagedata }));
		$('#content').fadeIn();
		NProgress.done();
	});
}
function loadBilling(){
	NProgress.start();
	Backbone.history.navigate('billing');
	doAjaxRequest('billing_json', 'post', '', function(pagedata){
		var template = swig.compile(tpl.get('billing'));
		$('#content').html(template({ pagedata: pagedata}));
		$('#content').fadeIn();
		NProgress.done();
	});
}
function loadTermsOfService(){
	NProgress.start();
	Backbone.history.navigate('tos');
	doAjaxRequest('tos_json', 'post', '', function(pagedata){
		var template = swig.compile(tpl.get('tos'));
		$('#content').html(template({ pagedata: pagedata}));
		$('#content').fadeIn();
		NProgress.done();
	});
}
function doLogout(){
	if(confirm('Cerra sesion?')){
		redirectToUrl('logout');
	}
}
var AppRouter = Backbone.Router.extend({
	routes: {
		'category/:category'	:	'category',
		'product/:product'		:	'product',
		'authentication'		:	'authentication',
		'cart'					:	'cart',
		'news'					:	'news',
		'billing'				:	'billing',
		'tos'					:	'tos',
		'*path'					:	'shop'
	},
	shop: function() {
		loadShopContent();
	},
	category: function(category){
		loadCategory(category);
	},
	product: function(product){
		loadProduct(product);
	},
	authentication: function(){
		showLoginPage();
	},
	cart: function(){
		showShoppingCartContents();
	},
	news: function(){
		productsNews();
	},
	billing: function(){
		loadBilling();
	},
	tos: function(){
		loadTermsOfService();
	}
});

NProgress.start();
tpl.loadTemplates([
	'home',
	'category',
	'product',
	'404',
	'error',
	'usernav',
	'authentication',
	'cart',
	'news',
	'billing',
	'tos'
], function(){
	usernav_template = tpl.get('usernav');
	app = new AppRouter();
	Backbone.history.start({ pushState: true, root: pathroot });
	loadUserCredentials(function(){
		NProgress.done();
	});
});
toastr.options = {
	"closeButton": true,
	"debug": false,
	"positionClass": "toast-top-right",
	"onclick": null,
	"showDuration": "600",
	"hideDuration": "1500",
	"timeOut": "5000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
};