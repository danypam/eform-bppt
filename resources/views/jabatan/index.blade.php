@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">POSITION</h3>
                                <div class="right">
                                    @can('jabatan-create')
                                    <a href="#" class="btn btn-info btn-lg " data-toggle="modal" data-target="#exampleModal" id="tambahjabatan">Add New Position</a>
                                    @endcan
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>Position</th>
                                        <th>Echelon</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data_jabatan as $jab)
                                        <tr>
                                            <td>{{$jab->nama_jabatan}}</td>
                                            <td>{{$jab->eselon}}</td>
                                            <td>{{$jab->created_at}}</td>
                                            <td>
                                                @can('jabatan-edit')
                                                <a href="/jabatan/{{$jab->id}}/edit" class="btn btn-warning btn-sm">Edit</a>
                                                @endcan
                                                @can('jabatan-delete')
                                                <a href="#" class="btn btn-danger btn-sm delete" jabatan-id="{{$jab->id}}">Delete</a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADD NEW POSITION DATA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/jabatan/create" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Jabatan</label>
                            <input name="nama_jabatan" type="text" class="form-control" id="exampleFormControlInput1" pattern="^[A-Z\s]{0,}$" placeholder="Nama Jabatan"value="{{old('nama_jabatan')}}"required>
                            <small id="emailHelp" class="form-text text-muted"> Allow Uppercase Only </small>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Echelon</label>
                            <input name="eselon" type="text" class="form-control" id="exampleFormControlInput1"pattern="^[A-Z]+\.[a-z]{0,5}$" placeholder="Echelon"required>
                            <small id="eselon" class="form-text text-muted"> Format: alphabet.alphabet Ex: II.a </small>

                        </div>
                </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@stop
@section('footer')

    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();

            $('.delete').click(function () {
                var jab_id = $(this).attr('jabatan-id');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            swal("Poof! Your data has been deleted!", {
                                icon: "success",
                            });
                            window.location = "/jabatan/"+jab_id+"/delete";
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            });

            // jQuery('#ajaxSubmit').click(function(e){
            //     e.preventDefault();
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="viewport"]').attr('content')
            //         }
            //     });
            //     jQuery.ajax({
            //         url: "/jabatan/create",
            //         method: 'post',
            //         data: {
            //             nama_jabatan: jQuery('#nama_jabatan').val(),
            //             eselon: jQuery('#eselon').val(),
            //         },
            //         success: function(result){
            //             if(result.errors)
            //             {
            //                 jQuery('.text-danger').html('');
            //
            //                 jQuery.each(result.errors, function(key, value){
            //                     jQuery('.text-danger').show();
            //                     jQuery('.text-danger').append('<li>'+value+'</li>');
            //
            //                 });
            //             }
            //             else
            //             {
            //                 jQuery('.text-danger').hide();
            //                 $('#tambahjabatan').hide();
            //                 $('#exampleModal').modal('hide');
            //             }
            //         }});
            // });
            // $('#exampleModal').validate(
            //     {
            //         rules : {
            //             nama_jabatan: {
            //                 required: true,
            //                 messages: {
            //                     required: "The Nama Jabatan field is required",
            //                 }
            //             },
            //             eselon: {
            //                 required: true,
            //                 alphanumeric: true,
            //                 messages: {
            //                     required: "The eselon field is required",
            //                     alphanumeric: "Should include alpha and number"
            //                 },
            //                 highlight: function (element) {
            //                     $(element)
            //                         .closest('.form-group')
            //                         .removeClass('success')
            //                         .addClass('error');
            //                        $('#exampleModal').modal('show');
            //
            //                 }
            //             }
            //         }
            //     });

        })


    </script>

@stop



