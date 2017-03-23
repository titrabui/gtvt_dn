function backToRegiserAndEditForm() {
	var confirm_form = document.getElementById("confirm-form");

	// Create a hidden back flag element, and append it to the form
	var back_flag_input = document.createElement('input');
	back_flag_input.type = 'hidden';
	back_flag_input.name = 'back';
	back_flag_input.value = 'back';

	// add back flag element into confirm form to get back previous page
	confirm_form.appendChild(back_flag_input);

	// get path name without confirm path
	var array_origin_path = location.pathname.split( "/confirm" );

	// get new path
	var new_path = array_origin_path[0];

	// get last character of action form for detecting previouse page is register or edit
	var last_character = confirm_form.action.slice(-1);

	// check if last character is number then it is the project id
	if ( ! isNaN(last_character)) {
		var project_id = parseInt(location.pathname.split( "/confirm/" )[1]);
		confirm_form.action = new_path + "/edit/" + project_id;
	} else {
		confirm_form.action = new_path + "/register";
	}

	// get back
	confirm_form.submit();
}

function projectConfirmSubmit() {
	$('.btn').prop('disabled', true);
	$('#confirm-form').submit();
}