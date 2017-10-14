/*!
 * @author Sean Coker <sean@seancoker.com>
 * @author Jan Järfalk <jan.jarfalk@unwrongest.com>
 * @Version 1.0.2
 * @url http://sean.is/building/jquery-airport
 * @description Airport is a rather simple text effect plugin for Jquery. It emulates the style of those flickering information boards you sometimes find on airports and train stations.
 */
(function ($) {
	$.fn.extend({
		airport: function (array) {
			var self = $(this);
			var chars = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
			var longest = 0;
			var items = items2 = array.length;

			function pad(a, b) {
				return a + new Array(b - a.length + 1).join(' ');
			}

			$(this).empty();

			while (items--) {
				if (array[items].length > longest) {
					longest = array[items].length;
				}
			}

			while (items2--) {
				array[items2] = pad(array[items2], longest);
			}

			spans = longest;
			while (spans--) {
				$(this).prepend('<span class="c' + spans + '"></span>');
			}

			function testChar(a, b, c, d) {
				if (c >= array.length) {
					//setTimeout(function() {testChar(0, 0, 0, 0);}, 10);
				} else if (d >= longest) {
					//setTimeout(function() {testChar(0, 0, c + 1, 0);}, 10);
					//draw();
				} else {
					var name = $(self).find('.c' + a);
					name.html((chars[b] == " ") ? "&nbsp;" : chars[b]);
					setTimeout(function () {
						var character = array[c].substring(d, d + 1);

						if (b > chars.length) {
							name.html(character);
							testChar(a + 1, 0, c, d + 1);
						} else if (chars[b] != character.toLowerCase()) {
							testChar(a, b + 1, c, d);
						} else {
							if ((character == chars[b].toUpperCase()) && (name.html() != '&nbsp;')) {
								name.html(name.html().toUpperCase());
							}
							testChar(a + 1, 0, c, d + 1);
						}
					}, 10);
				}
			}

			testChar(0, 0, 0, 0);
		}
	});
})(jQuery);
