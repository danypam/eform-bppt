jQuery(function() {
	var fbRenderOptions = {
		container: false,
		dataType: 'json',
		formData: window._form_builder_content ? window._form_builder_content : '',
		render: true,
        templates: {
            "datetime-local": function(fieldData) {
                return {
                    field: ' <input type="datetime-local" id="' + fieldData.name + '" class="form-control"/>'
                }
            },
            selectFromDatabase: function(fieldData){
                return {
                    field: ' <select type="selectFromDatabase" id="' + fieldData.name + '" class="form-control selectfromdatabase"/>',
                    onRender: function () {
                    }
                }
            },
            "duration": function(fieldData) {
                return {
                    field: ' <input type="text" name="' + fieldData.name + '" id="' + fieldData.name + '" class="form-control"/>',
                    onRender: function () {
                        $(document.getElementById(fieldData.name)).daterangepicker({
                            timePicker: true,
                            locale: {
                                format: 'DD/MM/YYYY hh:mm A'
                            }
                        });
                    }
                }
            }
        }
	}
	$('#fb-render').formRender(fbRenderOptions)
})
