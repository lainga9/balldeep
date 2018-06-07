var Pikaday = require('pikaday');

var datepicker = (function() {

	var elems = document.querySelectorAll('[data-datepicker]'),
		pickers = [],

	init = function() {

		new Pikaday({
			field: document.getElementById('test')
		});

		// elems.forEach(function(elem) {
		// 	pickers.push(new Pikaday({
		// 		field: elem,
		// 		format: 'MM-DD-YYYY',
		// 		defaultDate: new Date(),
		// 		setDefaultDate: true,
		// 		onClose: function () {
		// 			document.activeElement.blur();
		// 		}
		// 	}));
		// });

		// console.log(pickers);
	};

	return {init: init};

})();

datepicker.init();