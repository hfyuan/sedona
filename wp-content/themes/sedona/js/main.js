/*
Usage:
var productId = "AAAAAAA";
var rowId = "2";
var cellId = "3";

url = "/admin/save-product-unit?productId={0}&rowId={1}&cellId={2}";
url = url.format(productId, rowId, cellId);
*/
String.prototype.format = function() {
	var pattern = /\{\d+\}/g;
	var args = arguments;
	return this.replace(pattern, function(capture) {
		return args[capture.match(/\d+/)];
	});
};
var REA = {
	enabled: true,
	log: function(txt) {
		if (!this.enabled) return;
		if (typeof(console) !== "undefined") {
			console.log(">> " + txt + " ");
		}
	},
	getQSValue: function(key) {
		var querystring = location.search.replace(/\?/, "");
		var parts = querystring.split("&");
		var match = {};
		for (var L = 0; L < parts.length; L++) {
			var kvpair = parts[L].split("=");
			match[kvpair[0]] = kvpair[1];
		}
		if (match[key]) {
			return match[key];
		} else {
			return null;
		}
	},
	// using jQuery
	getCookie: function(name) {
		var cookieValue = null;
		if (document.cookie && document.cookie != '') {
			var cookies = document.cookie.split(';');
			for (var i = 0; i < cookies.length; i++) {
				var cookie = jQuery.trim(cookies[i]);
				// Does this cookie string begin with the name we want?
				if (cookie.substring(0, name.length + 1) == (name + '=')) {
					cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
					break;
				}
			}
		}
		return cookieValue;
	}

};