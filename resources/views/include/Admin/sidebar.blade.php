<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    <div class="user-profile dropdown m-t-20">
                        <div class="user-pic">

                            <img src="{{ App\Models\basic\Basic::getImage() }}" alt="users" class="rounded-circle img-fluid" />

                        </div>
                        <div class="user-content hide-menu m-t-10">
                            <h5 class="nameOfUser m-b-10 user-name font-medium">{{ Auth::guard('Admin')->user()->name }}</h5>
                            <a href="javascript:void(0)" class="btn btn-circle btn-sm m-r-5" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="ti-settings"></i>
                            </a>
                            <a href="javascript:void(0)" title="Logout" class="btn btn-circle btn-sm">
                                <i class="ti-power-off"></i>
                            </a>
                            <div class="dropdown-menu animated flipInY" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="{{route('profile.index')}}">
                                    <a class="dropdown-item" href="{{route('user.logout')}}">
                                        <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                    <!-- End User Profile-->
                </li>
                <!-- User Profile-->

                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="/manage/home" aria-expanded="false">
                        <i class="fa fa-home"></i>
                        <span class="hide-menu">{{trans('main.home')}}</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('User.index')}}" aria-expanded="false">
                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                        <span class="hide-menu">{{trans('user.users')}}</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('Live_service.index')}}" aria-expanded="false">
                        <i class="fas fa-rss" aria-hidden="true"></i>
                        <span class="hide-menu">خدمات 24/7</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('Industrial.index')}}" aria-expanded="false">
                        <i class="fa fa-industry" aria-hidden="true"></i>
                        <span class="hide-menu">خدمات صناعيه</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('homeService.index')}}" aria-expanded="false">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span class="hide-menu">خدمات منزليه</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('setting.index')}}" aria-expanded="false">
                        <i class="fa fa-info" aria-hidden="true"></i>
                        <span class="hide-menu">عن التطبيق</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">الاعدادات</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-Mailbox-Empty"></i>
                        <span class="hide-menu">الاعدادات </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item">
                            <a href="{{route('Car_model.index')}}" class="sidebar-link">
                                <i class="mdi mdi-email"></i>
                                <span class="hide-menu"> انواع السيارات </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{route('Province.index')}}" class="sidebar-link">
                                <i class="mdi mdi-email"></i>
                                <span class="hide-menu">  المقاطعات </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{route('Workshop_type.index')}}" class="sidebar-link">
                                <i class="mdi mdi-email"></i>
                                <span class="hide-menu">  انواع الورش </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{route('Car_electration.index')}}" class="sidebar-link">
                                <i class="mdi mdi-email"></i>
                                <span class="hide-menu">   ميكانيكي السيارات </span>
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
