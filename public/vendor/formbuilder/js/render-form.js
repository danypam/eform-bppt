jQuery(function() {

	var fbRenderOptions = {
		container: false,
		dataType: 'json',
		formData: window._form_builder_content ? window._form_builder_content : '',
		render: true,
        clearDefaultControls: true,
        userDefinedControls: [{ label: 'User Control', attrs: { type: 'datetime-local', className: 'text-input', name: 'datetime-local', identifier: 'datetime-local' } }],
        layoutTemplates: {
        },
            templates:{
                // "datetime-local": function(fieldData) {
                //     return {
                //         field: ' <input type="datetime-local" name="' + fieldData.name + '" id="' + fieldData.name + '" class="form-control"/>'
                //     }
                // },
                selectFromDatabase: function(fieldData){
                    var field = ' <select type="selectFromDatabase" name="' + fieldData.name + '" id="' + fieldData.name + '" class="form-control"/>'
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
            },
	}
	$('#fb-render').formRender(fbRenderOptions)
})
