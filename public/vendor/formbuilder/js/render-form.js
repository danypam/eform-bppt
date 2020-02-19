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
            starRating: function(fieldData) {
                return {
                    field: '<span id="' + fieldData.name + '">',
                    onRender: function() {
                        $(document.getElementById(fieldData.name)).rateYo({
                            rating: 3.6
                        });
                    }
                };
            }
        },
	}
	$('#fb-render').formRender(fbRenderOptions)
})
