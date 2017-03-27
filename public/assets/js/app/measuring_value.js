$( document ).ready(function() {
	$('#measuringValueModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)							// Button that triggered the modal
		var measuring_value = button.data('whatever').split(',')	// Extract info from data-* attributes

		var modal = $(this)
		modal.find('.modal-message').text('Bạn có chắc chắn muốn xóa giá trị đo lúc ' + measuring_value[2] + ' ' + measuring_value[3] + ' ở điểm đo ' + measuring_value[1] + ' không?')
		modal.find('.modal-submit').attr('onclick', 'measuringValueDelete(\"' + measuring_value[0] + '\")')
	})

	$( ".month-select" ).change(function() {
		$( ".month-form" ).submit()
	})
});

function measuringValueDelete(url) {
	window.location.href = url
}