<div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li ><a href="{{url('dashboard')}}" class="{{(request()->is('dashboard'))?'active': ''}}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
                @if (auth()->user()->can('inbox-list-all') ||
                    auth()->user()->can('inbox-list-mengetahui-menyetujui') ||
                    auth()->user()->can('inbox-list-mengetahui') ||
                    auth()->user()->can('inbox-list-menyetujui'))
                <li ><a href="/inbox" class="{{(request()->is('inbox*'))?'active': ''}}"><i class="lnr lnr-envelope"></i> <span>Surat Masuk</span></a></li>
                @endif
                @if (auth()->user()->can('submission-list'))
                <li><a href="{{ route('formbuilder::my-submissions.index') }}" class="{{(request()->is('my-submission*'))?'active': ''}}"><i class="lnr lnr-inbox"></i> <span>Surat Saya</span></a></li>
                @endif
                @if (auth()->user()->can('task-list') || auth()->user()->can('task-approve'))
                <li><a href="{{url('task')}}" class="{{Request::is('task*')?'active':''}}"><i class="lnr lnr-briefcase"></i> <span>Tugas</span></a></li>
                @endif
                @if (auth()->user()->can('pegawai-list') || auth()->user()->can('pegawai-delete') || auth()->user()->can('pegawai-create')|| auth()->user()->can('pegawai-edit'))
                    <li><a href="/pegawai" class="{{(request()->is('pegawai*'))?'active': ''}}"><i class="lnr lnr-users"></i> <span>Pegawai</span></a></li>
                @endif
                @can('crud-management')
                    <li>
                        <a href="#subPages" data-toggle="collapse" class="collapse"><i class="lnr lnr-file-empty"></i> <span>DATA</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                        <div id="subPages" class="collapse">
                            <ul class="nav">
                                @if (auth()->user()->can('unitjab-list') || auth()->user()->can('unitjab-delete') || auth()->user()->can('unitjab-create')|| auth()->user()->can('unitjab-edit'))
                                    <li><a href="/unitjab"  class="{{(request()->is('unitjab*'))?'active': ''}}"><i class="fa fa-shirtsinbulk"></i><span>Unit Jabatan</span></a></li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endcan
                @if (auth()->user()->can('form-list') || auth()->user()->can('form-delete') || auth()->user()->can('form-create')|| auth()->user()->can('form-edit'))
                    <li><a href="/forms" class="{{(request()->is('forms*'))?'active': ''}}"><i class="lnr lnr-plus-circle"></i> <span>Form Builder</span></a></li>
                @endif
                @if(auth()->user()->can('form-input'))
                    <li><a href="/formulir" class="{{(request()->is('form*'))?'active': ''}}"><i class="lnr lnr-file-add"></i> <span>Formulir</span></a></li>
                @endif

                <li>
                    <a href="#subPages1" data-toggle="collapse" class="collapsed "><i class="lnr lnr-cog"></i> <span>Pengaturan</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPages1" class="collapse ">
                        <ul class="nav">
                            <li><a href="/{{auth()->user()->id}}/profile" class="{{Request::is(auth()->user()->id.'/profile')?'active':''}}"><i class="fa fa-user-circle-o"></i><span>Profil Saya</span></a></li>
                            <li><a href="/auth/ubahpass" class="{{Request::is('auth/ubahpass*')?'active':''}}"><i class="fa fa-expeditedssl"></i><span>Ubah Password</span></a></li>
                            @role('Admin')
                            <li><a href="/log" class="{{(request()->is('log*'))?'active': ''}}"><i class="fa fa-group"></i><span>Aktifitas User</span></a></li>
                            <li><a href="/roles" class="{{(request()->is('roles*'))?'active': ''}}"><i class="fa fa-drivers-license-o"></i><span>Roles</span></a></li>
                            <li><a href="/permission"  class="{{(request()->is('permission*'))?'active': ''}}"><i class="fa fa-key"></i><span>Permissions</span></a></li>
                            <li><a href="/users" class="{{(request()->is('users*'))?'active': ''}}"><i class="fa fa-address-book-o"></i><span> Akses Akun</span></a></li>
                            @endrole
                        </ul>
                    </div>
                </li>

            </ul>
        </nav>
    </div>
</div>
