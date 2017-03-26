function backToRegiserAndEditForm(project_id) {
	var confirm_form = document.getElementById("confirm-form");

	// Create a hidden back flag element, and append it to the form
	var back_flag_input = document.createElement('input');
	back_flag_input.type = 'hidden';
	back_flag_input.name = 'back';
	back_flag_input.value = 'back';

	// add back flag element into confirm form to get back previous page
	confirm_form.appendChild(back_flag_input);

	// remove param from URL
	var alteredURL = removeParam("project", location.pathname);

	// get path name without confirm path
	var array_origin_path = alteredURL.split( "/confirm" );

	// get new path
	var new_path = array_origin_path[0];

	// get last character of action form for detecting previouse page is register or edit
	var last_character = alteredURL.slice(-1);

	// check if last character is number then it is the measuring_point id
	if ( ! isNaN(last_character)) {
		var measuring_point_id = parseInt(alteredURL.split( "/confirm/" )[1]);
		confirm_form.action = new_path + "/edit/" + measuring_point_id + "?project=" + project_id;
	} else {
		confirm_form.action = new_path + "/register?project=" + project_id;
	}

	// get back
	//confirm_form.submit();
}

function measuringPointConfirmSubmit() {
	$('.btn').prop('disabled', true);
	$('#confirm-form').submit();
}

function removeParam(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}