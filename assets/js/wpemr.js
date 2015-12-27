jQuery(document).ready(function($) {

//Date Picker
	$('#birthdate').datepicker({
		dateFormat : 'dd-mm-yy',
      		changeMonth: true,
      		changeYear: true,
      		yearRange: "1950:2015"
	});

});
