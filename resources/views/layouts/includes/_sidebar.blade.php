<div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
{{--                test submit--}}
                <li><a href="/dashboard" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
                <li><a href="/inbox" class=""><i class="lnr lnr-user"></i> <span>Inbox</span></a></li>
                <li>
                    <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>CRUD</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPages" class="collapse ">
                        <ul class="nav">
                            @if (auth()->user()->can('jabatan-list') || auth()->user()->can('jabatan-delete') || auth()->user()->can('jabatan-create')|| auth()->user()->can('jabatan-edit'))
                            <li><a href="/jabatan" class="">Jabatan</a></li>
                            @endif
                            @if (auth()->user()->can('unit-list') || auth()->user()->can('unit-delete') || auth()->user()->can('unit-create')|| auth()->user()->can('unit-edit'))
                            <li><a href="/unit" class="">Unit Kerja</a></li>
                            @endif
                            @if (auth()->user()->can('unitjab-list') || auth()->user()->can('unitjab-delete') || auth()->user()->can('unitjab-create')|| auth()->user()->can('unitjab-edit'))
                            <li><a href="/unitjab" class="">Unit Jabatan</a></li>
                            @endif
                            @if (auth()->user()->can('alamat-list') || auth()->user()->can('alamat-delete') || auth()->user()->can('alamat-create')|| auth()->user()->can('alamat-edit'))
                            <li><a href="/alamat" class="">Lokasi</a></li>
                            @endif
                            @if (auth()->user()->can('layanan-list') || auth()->user()->can('layanan-delete') || auth()->user()->can('layanan-create')|| auth()->user()->can('layanan-edit'))
                            <li><a href="/layanan" class="">Layanan</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
                @if (auth()->user()->can('pegawai-list') || auth()->user()->can('pegawai-delete') || auth()->user()->can('pegawai-create')|| auth()->user()->can('pegawai-edit'))
                <li><a href="/pegawai" class=""><i class="lnr lnr-user"></i> <span>Pegawai</span></a></li>
                @endif
{{--                @if (auth()->user()->can('form-list') || auth()->user()->can('form-delete') || auth()->user()->can('form-create')|| auth()->user()->can('form-edit')|| auth()->user()->can('form-input'))--}}
                <li><a href="/forms" class=""><i class="lnr lnr-user"></i> <span>Form Builder</span></a></li>
                <li><a href="/formulir" class=""><i class="lnr lnr-user"></i> <span>Formulir</span></a></li>
{{--                @endif--}}
                @if (auth()->user()->can('task-list') || auth()->user()->can('task-approve'))
                <li><a href="panels.html" class=""><i class="lnr lnr-user"></i> <span>Task</span></a></li>
                @endif
                <li>
                    <a href="#subPages1" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pengaturan</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPages1" class="collapse ">
                        <ul class="nav">
                            <li><a href="/{{auth()->user()->id}}/profile" class="">My Profile</a></li>
                            <li><a href="/auth/ubahpass" class="">Ubah Password</a></li>
                            @role('Admin')
                            <li><a href="/log" class="">Log Activity</a></li>
                            <li><a href="/roles" class="">Role</a></li>
                            <li><a href="/permission" class="">Permission</a></li>
                            <li><a href="/users" class="">Akses Akun</a></li>
                            @endrole
                        </ul>
                    </div>
                </li>

            </ul>
        </nav>
    </div>
</div>
