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
                "datetime-local": function(fieldData) {
                    return {
                        field: ' <input type="datetime-local" name="' + fieldData.name + '" id="' + fieldData.name + '" class="form-control"/>'
                    }
                },
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
            },
	}
	$('#fb-render').formRender(fbRenderOptions)
})
