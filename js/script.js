$('#enter').click(function(){
	window.location.href = "enter.php"
});

$('#dob').RendezVous({
	inputEmptyByDefault: false,
	defaultDate: {
		day: 10,
		month: 1,
		year: 1993
	},
	formats: {
		display: {
			day: '%D',
			month: '%M',
			year: '%Y',
			date: '%D %M %Y'
		}
	},
	inputSeparator: '/',
	splitInput: false
});

var addressPicker = new AddressPicker();

$('#address').typeahead(null, {
  displayKey: 'description',
  source: addressPicker.ttAdapter()
});