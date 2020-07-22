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

        }
	}
	$('#fb-render').formRender(fbRenderOptions)
})
