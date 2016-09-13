(function( $ ) {
	'use strict';
	$( function() {
		//$('#iseek_opening_hours_mon_x').parent().css('opacity', '.5');
		//$('body').css('display', 'none');

		var toggleHours = function(selector) {
			if( $(selector).is(':checked') ){
				$(selector).parent().parent().next().css('display', 'none').find('input').prop('disabled', true);
				$(selector).parent().parent().next().next().css('display', 'none').find('input').prop('disabled', true);
			} else {
				$(selector).parent().parent().next().css('display', 'table-row').find('input').prop('disabled', false);
				$(selector).parent().parent().next().next().css('display', 'table-row').find('input').prop('disabled', false);
			}
		}

		var checkHours = function(selectors) {
			selectors.forEach(function(selector){
				console.log(selector);

				if( $(selector).is(':checked') ){
					$(selector).parent().parent().next().css('display', 'none').find('input').prop('disabled', true);
					$(selector).parent().parent().next().next().css('display', 'none').find('input').prop('disabled', true);
				}

				$(selector).on('change', function(event) {
					toggleHours(selector);
				});
			});
		}

		var validateOptions = function () {
			$('.settings_page_iseek-oh input[type="time"]').on('keypress', function(event) {
				if (!event.which)
					return;
				var char = String.fromCharCode(event.which);
				console.log(char);

				if (char.match(/^[^0-9+#\:\b]+$/)) event.preventDefault();
			});

			$('.settings_page_iseek-oh input').on('change', function(event) {
				var timeStr = $(this).val();

				if ( timeStr > 0 && timeStr <= 24 ){
					if ( timeStr <= 9 )
						$(this).val( '0' + timeStr + ':00' );
					else
						$(this).val( timeStr + ':00' );
				} else {
					var timeSplit = timeStr.split(":");
					var valid = ( timeSplit[0]!=undefined && timeSplit[1]!=undefined && timeSplit[0] >= 0 && timeSplit[0] <= 24) && (timeSplit[1] >= 0 && timeSplit[1] <= 59);

					if (!valid){
						$(this).val('');
					} else {
						if (timeSplit[1] == undefined || timeSplit[1] == null)
							timeSplit[1] = '00';
						if (timeSplit[0] < 10 && timeSplit[0][0] != 0)
							timeSplit[0] = '0' + timeSplit[0];
						if (timeSplit[1] < 10 && timeSplit[1][0] != 0)
							timeSplit[1] = '0' + timeSplit[1];
						$(this).val(timeSplit[0] + ':' + timeSplit[1]);
					}
				}

			});
		}

		var selectors = [
			'#iseek_opening_hours_mon_x',
			'#iseek_opening_hours_tue_x',
			'#iseek_opening_hours_wed_x',
			'#iseek_opening_hours_thu_x',
			'#iseek_opening_hours_fri_x',
			'#iseek_opening_hours_sat_x',
			'#iseek_opening_hours_sun_x'
		];

		// Go!
		checkHours(selectors);
		validateOptions();
	});

})( jQuery );
