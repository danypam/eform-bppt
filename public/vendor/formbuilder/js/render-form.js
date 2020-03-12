jQuery(function() {

	var fbRenderOptions = {
		container: false,
		dataType: 'json',
		formData: window._form_builder_content ? window._form_builder_content : '',
		render: true,
        layoutTemplates: {
        },
            templates:{
                datetimepicker: function(fieldData) {
                    return {
                        field: ' <input type="text" id="' + fieldData.name + '" class="form-control" value="' + fieldData.value + '"/>',
                        onRender: function() {
                            $(document.getElementById(fieldData.name)).daterangepicker({
                                timePicker: true,
                                locale: {
                                    format: 'DD/MM/YYYY hh:mm A'
                                }
                            });
                        }
                    }
                },
                selectFromDatabase: function(fieldData){
                    var field = ' <select type="selectFromDatabase" id="' + fieldData.name + '" class="form-control"/>'
                    return {
                        field: field,
                        onRender: function() {
                            fieldData.values.forEach(function (r) {
                                $($(document.getElementById(fieldData.name))).append($('<option>', {
                                    value: r.value,
                                    text: r.label
                                }))
                            })
                        }
                    }
                },
            },
	}
	$('#fb-render').formRender(fbRenderOptions)
})
