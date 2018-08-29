$(document).ready(function() {

    $('.datetimepicker').datetimepicker( {
		hourGrid : 4,
		minuteGrid : 10,
		changeYear : true,
		currentYear : 2011,
		dateFormat : 'dd-mm-yy' 
		
	});

    $('.vtdatepicker').datetimepicker( {
		hourGrid : 4,
		minuteGrid : 10,
		
		changeYear : false,
		currentYear : 2012,
		showHour: false,
		showMinute: false,
		showSecond: false,
		showTime: false, 
		alwaysSetTime: false,
		dateFormat : 'dd/mm/yy', 
		showButtonPanel: false
		
	});
//	if ($("#dm_admin_content").length) {
//	$('.green').focus();
//}

});