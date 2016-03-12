jQuery.validator.addMethod("cnp", function (value, element, param) {
	if ($(param).length > 0)
	{
		value += '';
		var constanta = "279146358279";

		if (value.length != 13)
			return false;

		if ((value.charAt(3) == 0) && (value.charAt(4) == 0))
			return false;

		if ((value.charAt(5) == 0) && (value.charAt(6) == 0))
			return false;

		if (value.charAt(5) > 3)
			return false;

		if ((value.charAt(5) == 3) && (value.charAt(6) > 1))
			return false;

		var suma = 0;

		for (i = 0; i < constanta.length; i++) {
			suma = suma + value.charAt(i) * constanta.charAt(i);
		}

		var rest = suma % 11;

		if ((rest < 10 && rest == value.charAt(12)) || (rest == 10 && value.charAt(12) == 1)) {
			return(true);
		}
		else {
			return(false);
		}
	}
	else
		return true;
}, jQuery.validator.format("CNP invalid"));

jQuery.validator.addMethod("uniqueValue", function (value, element, param) {
	if ($(param).length <= 0)
	{
		return true;
	}

	var parentForm = $(element).closest('form');
	var timeRepeated = 0;
	$(parentForm.find('input[type="text"]')).each(function () {
		if ($(this).val() === value && !$(this).is('[readonly]')) {
			timeRepeated++;
		}
	});
	if (timeRepeated === 1 || timeRepeated === 0) {
		return true
	}
	else {
		return false
	}
}, jQuery.validator.format("This answer can not be repeated."));