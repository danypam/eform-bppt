<nav class="navbar navbar-default navbar-fixed-top">
    <div class="brand">
        <a href="{{url('dashboard')}}"><img src="{{asset('assets/img/logofix1.png')}}" alt="" class="img-responsive logo"></a>
    </div>
    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
        </div>

        <div id="navbar-menu">
            <ul class="nav navbar-nav navbar-right">

                <notification v-bind:submissions="submissions"></notification>
{{--                @if(Auth::check())--}}
{{--                <li class="dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">--}}
{{--                        <i class="lnr lnr-alarm"></i>--}}
{{--                        <span class="badge bg-danger">{{auth()->user()->unreadNotifications->count()}}</span>--}}
{{--                    </a>--}}
{{--                    <ul class="dropdown-menu notifications">--}}
{{--                        @if(auth()->user()->unreadNotifications->count())--}}
{{--                            @foreach(auth()->user()->unreadNotifications as $notifications)--}}
{{--                                 <li><a href="/inbox" class="notification-item"><span class="dot bg-success"></span>New Form {{(isset($data['submission']['form_id'])? $data['submission']['form_id']: '' )}} submit by {{(isset($data['submission']['user_id'])? $data['submission']['user_id'] : '')}}</a></li>--}}
{{--                            @endforeach--}}
{{--                                <li><a href="/inbox" class="more">See all notifications</a></li>--}}
{{--                        @else--}}
{{--                            <li><p class="more">No Notification</p></li>--}}
{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--                @endif--}}
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{auth()->user()->pegawai->getFoto()}}" class="img-circle" alt="Avatar"> <span>{{auth()->user()->name}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="/{{auth()->user()->id}}/profile"><i class="lnr lnr-user"></i> <span>Profil Saya</span></a></li>
                        {{--<li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>--}}
                        <li><a href="/logout"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
{{--                        LOGOUT CAS--}}
{{--                        <li><a href="/cas/logout"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>--}}
                    </ul>
                </li>
                <!-- <li>
                    <a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
                </li> -->
            </ul>
        </div>
    </div>
</nav>

