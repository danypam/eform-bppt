jQuery(function() {

	var fbRenderOptions = {
		container: false,
		dataType: 'json',
		formData: window._form_builder_content ? window._form_builder_content : '',
		render: true,
        fields: [{
            label: 'Star Rating',
            attrs: {
                type: 'starRating'
            },
            icon: '🌟'
        }],
        templates: {
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
            }
        },
	}
	$('#fb-render').formRender(fbRenderOptions)
})
