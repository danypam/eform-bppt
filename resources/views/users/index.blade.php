@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">USERS</h3>
                                <div class="right">
                                    <a class="btn btn-info btn-lg" href="{{ route('users.create') }}"> Tambah User</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php
                                $i=0;
                                ?>
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Updated At</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $user)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if(!empty($user->getRoleNames()))
                                                    @foreach($user->getRoleNames() as $v)
                                                        <label class="badge badge-success">{{ $v }}</label>
                                                    @endforeach
                                                @endif
                                            @if($user->status == true)
                                                <td><span class="label label-success">Aktif</span></td>
                                            @else
                                                <td><span class="label label-danger ">Tidak Aktif </span></td>
                                            @endif
                                            <td>{{$user->created_at}}</td>
                                            <td>
                                                <a class="btn btn-secondary btn-sm" href="{{ route('users.show',$user->id) }}">Lihat</a>
                                                <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}">Ubah</a>
                                                @if($user->status == false)
                                                    <a href="/users/{{$user->id}}/deletee" class="btn btn-success btn-sm ">Aktif</a>
                                                @else
                                                    <a href="/users/{{$user->id}}/delete" class="btn btn-danger btn-sm ">Nonaktif</a>
                                                @endif
{{--                                                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}--}}
{{--                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}--}}
{{--                                                {!! Form::close() !!}--}}
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

@stop
@section('footer')
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        })
    </script>

@stop

