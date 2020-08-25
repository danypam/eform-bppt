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

    //get database
    function getTableName(fld) {
        console.log($('.selectfromdatabase' ,fld));
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/getTable",
            success: function(result){
                result.forEach(function (r) {
                    $('.fld-table', fld).append($('<option>', {
                        value: r.TABLE_NAME,
                        text: r.TABLE_NAME
                    }));
                })
            }});

        $('.fld-table', fld).on('change', function () {
            $('.fld-value', fld).empty()
            $('.fld-lbl', fld).empty()
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/getColumn/" + $('.fld-table', fld).val(),
                success: function(result){
                    result.forEach(function (r) {
                        $('.fld-value, .fld-lbl', fld).append($('<option>', {
                            value: r,
                            text: r
                        }));
                    })
                }});
        })
    }


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
        userDefinedControls: [{ label: 'User Control', attrs: { type: 'datetime', className: 'text-input', name: 'customcontrol', identifier: 'customcontrol' } }],
        fields: [
        // {
        //     label: 'Time',
        //     attrs: {
        //         type: 'datetime-local'
        //     },
        //     icon: '⏰'
        // },
            {
                label: 'Duration',
                attrs: {
                    type: 'duration'
                },
                icon: '⏰'
            },
            {
                label: 'Select From Database',
                attrs: {
                    type: 'selectFromDatabase'
                },
                icon: '🛢'
            },],
        templates: {
            // "datetime-local": function(fieldData) {
            //     return {
            //         field: ' <input type="datetime-local" name="' + fieldData.name + '"  id="' + fieldData.name + '" class="form-control"/>'
            //      /*   onRender: function() {
            //             $(document.getElementById(fieldData.name)).daterangepicker({
            //                 timePicker: true,
            //                 locale: {
            //                     format: 'DD/MM/YYYY hh:mm A'
            //                 }
            //             });
            //         }*/
            //     }
            // },
            "duration": function(fieldData) {
                return {
                    field: ' <input type="text" name="' + fieldData.name + '" id="' + fieldData.name + '" class="form-control"/>',
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
                return {
                    field: ' <select type="selectFromDatabase" name="' + fieldData.name + '" id="' + fieldData.name + '" class="form-control selectfromdatabase"/>',
                    onRender: function () {
                    }
                }
            },

        },
        disableFields: [
            'button',
            'autocomplete'// buttons are not needed since we are the one handling the submission
        ],  // field types that should not be shown
        disabledAttrs: [
            'access',
        ],
        typeUserDisabledAttrs: {
            'selectFromDatabase':[
              'value'
            ],
            'checkbox-group': [
                'multiple'],
            'file': [
                'multiple',
                'subtype',
            ],/*
            'checkbox-group': [
                'other',
            ],*/
        },
        typeUserAttrs: {
        //     datetimepicker: {
        //         label:{
        //             value: ''
        //         },
        //     },
            selectFromDatabase: {
                label:{
                  value: ''
                },
                className:{
                  value: 'form-control'
                },
                table:{
                    label: '<span style="color: red">Table</span>',
                    options: {
                        '' : 'Choose this first'
                    },
                    required: 'true'
                },
                value:{
                    label: '<span style="color: red">Value Option</span>',
                    options: {},
                    required: 'true'
                },
                lbl:{
                    label: '<span style="color: red">Label Option</span>',
                    options: {},
                    required: 'true'
                }
            },
        //     text: {
        //         label:{
        //             value: ''
        //         },
        //         name: {
        //             label: 'field',
        //             required: 'true'
        //         },
        //     },
        //     Text2ColumnDynamic: {
        //         label:{
        //             value: ''
        //         },
        //         column1: {
        //             label: 'column 1',
        //             value: ''
        //         },
        //         column2: {
        //             label: 'column 2',
        //             value: ''
        //         }
        //     },
        //     textarea: {
        //         label:{
        //             value: ''
        //         },
        //         name: {
        //             label: 'field',
        //             required: 'true'
        //         }
        //     },
        //     'checkbox-group': {
        //         label:{
        //             value: ''
        //         },
        //         name: {
        //             label: 'field',
        //             required: 'true'
        //         }
        //     },
        //     number: {
        //         label:{
        //             value: ''
        //         },
        //         name: {
        //             label: 'field',
        //             required: 'true'
        //         }
        //     },
        //     date: {
        //         label:{
        //             value: ''
        //         },
        //         name: {
        //             label: 'field',
        //             required: 'true'
        //         }
        //     },
        //     file: {
        //         label:{
        //             value: ''
        //         },
        //         name: {
        //             label: 'field',
        //             required: 'true'
        //         }
        //     },
        //     hidden: {
        //         label:{
        //             value: ''
        //         },
        //         name: {
        //             label: 'field',
        //             required: 'true'
        //         }
        //     },
        //     'radio-group': {
        //         label:{
        //             value: ''
        //         },
        //         name: {
        //             label: 'field',
        //             required: 'true'
        //         }
        //     },
        },
        typeUserEvents: {
            number: {
                onnadd: function (fld) {
                    console.log(fld);
                }
            },
            text: {
                onadd: function(fld) {
                    console.log(fld);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: "/testAjax",
                        success: function(result){
                            console.log(result);
                            result.forEach(function (r) {
                                $('.fld-subtype', fld).append($('<option>', {
                                    value: r.id,
                                    text: r.nama_lengkap
                                }));
                            })
                        }});

                }
            },
            selectFromDatabase: {
                onadd: function (fld) {getTableName(fld)
                    /*$.ajax({
                        type: "GET",
                        dataType: "json",
                        url: "/testAjax",
                        success: function(result){
                            console.log(result);
                            result.forEach(function (r) {
                                $('.fld-table', fld).append($('<option>', {
                                    value: r.id,
                                    text: r.nama_lengkap
                                }));
                            })
                        }});*/
                    /*$.ajax({
                        type: "GET",
                        dataType: "json",
                        url: "/testAjax",
                        success: function(result){
                            console.log(result);
                            result.forEach(function (r) {
                                $('.fld-table', fld).append($('<option>', {
                                    value: r.id,
                                    text: r.nama_lengkap
                                }));
                            })
                        }});*/
                    //var table = $('.fld-table', fld);

                }
            },
            //text:{onadd: function (fld) {field(fld)}},
            /*textarea:{onadd: function (fld) {field(fld)}},
            select:{onadd: function (fld) {field(fld)}},
            'checkbox-group':{onadd: function (fld) {field(fld)}},
            //number:{onadd: function (fld) {field(fld)}},
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
                visibility: "PRIVATE",//$('#visibility').val(),
                allows_edit: "0",//$('#allows_edit').val(),
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


    //Preview
    $('.fb-preview').on('click', function () {
        var fbRenderOptions = {
            container: false,
            dataType: 'json',
            formData: formBuilder.actions.getData('json', true) ? formBuilder.actions.getData('json', true) : '',
            render: true,
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
        };

        $('.modal-body').formRender(fbRenderOptions)
        //formBuilder.actions.showData();
    });

    $('.getJSON').on('click', function() {
        alert(formBuilder.actions.getData('json', true));
    });
})
