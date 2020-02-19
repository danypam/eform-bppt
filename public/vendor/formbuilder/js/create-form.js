jQuery(function() {
    $('#visibility').change(function(e) {
        e.preventDefault()
        var ref = $(this)

        if (ref.val() == "" || ref.val() == 'PUBLIC') {
            $('#allows_edit_DIV').hide()
        } else {
            $('#allows_edit_DIV').slideDown()
            $('#allows_edit').val('0')
        }
    });

    $('.alert').on('click', function () {
        //console.log($('.fb-editor > select').attr('multiple') == "false");
        if($('select').attr('multiple') == "false"){
            $('this > select').removeAttr('multiple');
        }
    });

    //disable field for update
/*    function field(fld) {
        var name = $('.fld-name', fld);
        if(update && (name.val() !== "")){
            name.prop('disabled', true);
        }
    }*/


    var fbEditor = $(document.getElementById('fb-editor'))
    var formBuilder;

    var fbOptions = {
        dataType: 'json',
        formData: window._form_builder_content ? window._form_builder_content : '',
        controlOrder: [
            'header',
            'paragraph',
            'text',
            'textarea',
            'select',
            'number',
            'date',
            'file',
        ],
        fields: [{
            label: 'Star Rating',
            attrs: {
                type: 'starRating'
            },
            icon: '🌟'
        },
        {
            label: 'Time Picker',
            attrs: {
                type: 'datetimepicker'
            },
            icon: '🌟'
        },{
            label: 'Two Column Text Field',
            attrs: {
                type: 'Text2ColumnDynamic'
            },
            icon: '◻◻'
        }],
        templates: {
            starRating: function(fieldData) {
                return {
                    field: '<span id="' + fieldData.name + '" >',
                    onRender: function() {
                        $(document.getElementById(fieldData.name)).rateYo({
                            rating: 3
                        });
                    }

                };
            },
            datetimepicker: function(fieldData) {
                return {
                    field: '            <div class="form-group">\n' +
                        '                <div class=\'input-group date\' id=\'datetimepicker1\'>\n' +
                        '                    <input type=\'text\' class="form-control" />\n' +
                        '                    <span class="input-group-addon">\n' +
                        '                        <span class="glyphicon glyphicon-calendar"></span>\n' +
                        '                    </span>\n' +
                        '                </div>\n' +
                        '            </div>',
                    onRender: function() {
                        $(document.getElementById(fieldData.name)).datetimepicker();
                    }
                }
            },
            Text2ColumnDynamic: function (fieldData) {
                var random_class    = Math.floor(Math.random()*90000) + 1000000000;
                return {
                    field:
                        '<table class="table table-hover input_fields_wrap-' + random_class + '">' +
                        '   <thead>' +
                        '       <tr class="text-center">' +
                        '           <th>column1</th>' +
                        '           <th>column2</th>' +
                        '           <th> </th>' +
                        '       </tr>' +
                        '   </thead>' +
                        '   <tbody class="table-body">' +
                        '    <tr>' +
                        '       <td><input class="form-control" type="text" name="mytext[]" ></td>' +
                        '       <td><input class="form-control" type="text" name="mytext[]" ></></td>' +
                        '       <td></td>' +
                        '   </tr>' +
                        '   </tbody>' +
                        '</table>' +
                        '<div><button class="btn btn-success add_field_button-'+ random_class +'">╋</button></div>',
                    onRender: function () {
                        var max_fields      = 6; //maximum input boxes allowed
                        var wrapper   		= $(".input_fields_wrap-" + random_class); //Fields wrapper
                        var add_button      = $(".add_field_button-" + random_class); //Add button ID


                        var x = 1; //initlal text box count
                        $(add_button).click(function(e){ //on add input button click
                            e.preventDefault();
                            if(x < max_fields){ //max input box allowed
                                x++; //text box increment
                                $(wrapper).append('<tr>' +
                                    '<td><input class="form-control"  type="text" name="mytext[]" required/></td>' +
                                    '<td><input class="form-control " type="text" name="mytext[]" required/></td>' +
                                    '<td><a href="#" class="remove_field btn btn-danger">－</a></td>' +
                                    '</tr>'); //add input box
                            }else{
                                add_button.prop("disabled", true);
                            }
                        });

                        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                            add_button.prop("disabled", false);
                            e.preventDefault(); $(this).parent('td').parent('tr').remove(); x--;
                        })
                    }
                };
            }
        },
        disableFields: [
            'button',
            'autocomplete'// buttons are not needed since we are the one handling the submission
        ],  // field types that should not be shown
        disabledAttrs: [
            'access',
        ],
        typeUserDisabledAttrs: {
            'checkbox-group': [
                'multiple']
            /*'file': [
                'multiple',
                'subtype',
            ],*//*
            'checkbox-group': [
                'other',
            ],*/
        },
        typeUserAttrs: {/*
            text: {
                name: {
                    label: 'field',
                    required: 'true'
                },
            },
            Text2ColumnDynamic: {
                column1: {
                    label: 'column 1',
                    value: ''
                },
                column2: {
                    label: 'column 2',
                    value: ''
                }
            },
            textarea: {
                name: {
                    label: 'field',
                    required: 'true'
                }
            },
            */  /*
            'checkbox-group': {
                name: {
                    label: 'field',
                    required: 'true'
                }
            },
            number: {
                name: {
                    label: 'field',
                    required: 'true'
                }
            },
            date: {
                name: {
                    label: 'field',
                    required: 'true'
                }
            },
            file: {
                name: {
                    label: 'field',
                    required: 'true'
                }
            },
            hidden: {
                name: {
                    label: 'field',
                    required: 'true'
                }
            },
            'radio-group': {
                name: {
                    label: 'field',
                    required: 'true'
                }
            },
            'Text2ColumnDynamic':{
                name: {
                    label: 'field',
                    required: 'true'
                }
            },*/
        },
        typeUserEvents: {
      /*      text:{onadd: function (fld) {field(fld)}},
            textarea:{onadd: function (fld) {field(fld)}},
            select:{onadd: function (fld) {field(fld)}},
            'checkbox-group':{onadd: function (fld) {field(fld)}},
            number:{onadd: function (fld) {field(fld)}},
            date:{onadd: function (fld) {field(fld)}},
            file:{onadd: function (fld) {field(fld)}},
            hidden:{onadd: function (fld) {field(fld)}},
            'radio-group':{onadd: function (fld) {field(fld)}}*/
        },
        showActionButtons: false, // show the actions buttons at the bottom
        disabledActionButtons: ['data'], // get rid of the 'getData' button
        sortableControls: false, // allow users to re-order the controls to their liking
        editOnAdd: false,
        fieldRemoveWarn: false,
        roles: window.FormBuilder.form_roles || {},
        notify: {
            error: function(message) {
                return swal('Error', message, 'error')
            },
            success: function(message) {
                return swal('Success', message, 'success')
            },
            warning: function(message) {
                return swal('Warning', message, 'warning');
            }
        },
        onSave: function() {
            // var formData = formBuilder.formData
            // console.log(formData)
        },
    }


    formBuilder = fbEditor.formBuilder(fbOptions);

    $('.fb-preview').on('click', function () {
        var fbRenderOptions = {
            container: false,
            dataType: 'json',
            formData: formBuilder.actions.getData('json', true) ? formBuilder.actions.getData('json', true) : '',
            render: true
        };

        $('.modal-body').formRender(fbRenderOptions)
        //formBuilder.actions.showData();
    });

    var fbClearBtn = $('.fb-clear-btn')
    var fbShowDataBtn = $('.fb-showdata-btn')
    var fbSaveBtn = $('.fb-save-btn')

    // setup the buttons to respond to save and clear
    fbClearBtn.click(function(e) {
        e.preventDefault()

        if (! formBuilder.actions.getData().length) return

        sConfirm("Are you sure you want to clear all fields from the form?", function() {
            formBuilder.actions.clearFields()
        })
    });

    fbShowDataBtn.click(function(e) {
        e.preventDefault()
        formBuilder.actions.showData()
    });

    fbSaveBtn.click(function(e) {
        e.preventDefault()

        var form = $('#createFormForm')

        // make sure the form is valid
        if ( ! form.parsley().validate() ) return

        // make sure the form builder is not empty
        if (! formBuilder.actions.getData().length) {
            swal({
                title: "Error",
                text: "The form builder cannot be empty",
                icon: 'error',
            })
            return
        }

        // ask for confirmation
        sConfirm("Save this form definition?", function() {
            fbSaveBtn.attr('disabled', 'disabled');
            fbClearBtn.attr('disabled', 'disabled');

            var formBuilderJSONData = formBuilder.actions.getData('json')
            // console.log(formBuilderJSONData)
            // var formBuilderArrayData = formBuilder.actions.getData()
            // console.log(formBuilderArrayData)

            var pic_array = $('#pic').val();
            console.log(pic_array[0]);
            var pic_json = JSON.stringify(pic_array);

            var postData = {
                name: $('#name').val(),
                visibility: $('#visibility').val(),
                allows_edit: $('#allows_edit').val(),
                form_builder_json: formBuilderJSONData,
                letter_code: $('#letter-code').val(),
                pic: pic_json,
                _token: window.FormBuilder.csrfToken
            }

            var method = form.data('formMethod') ? 'PUT' : 'POST'
            jQuery.ajax({
                url: form.attr('action'),
                processData: true,
                data: postData,
                method: method,
                cache: false,
            })
                .then(function(response) {
                    fbSaveBtn.removeAttr('disabled')
                    fbClearBtn.removeAttr('disabled')

                    if (response.success) {
                        // the form has been created
                        // send the user to the form index page
                        swal({
                            title: "Form Saved!",
                            text: response.details || '',
                            icon: 'success',
                        })

                        setTimeout(function() {
                            window.location = response.dest
                        }, 1500);

                        // clear out the form
                        // $('#name').val('')
                        // $('#visibility').val('')
                        // $('#allows_edit').val('0')
                    } else {
                        swal({
                            title: "Error",
                            text: response.details || 'Error',
                            icon: 'error',
                        })
                    }
                }, function(error) {
                    handleAjaxError(error)

                    fbSaveBtn.removeAttr('disabled')
                    fbClearBtn.removeAttr('disabled')
                })
        })

    })
    // show the clear and save buttons
    $('#fb-editor-footer').slideDown()
})
