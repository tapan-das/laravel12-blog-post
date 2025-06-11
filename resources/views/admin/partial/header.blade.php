<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{AdminHelper::adminPath()}}" class="logo logo-dark">
                        @if(!empty(AdminHelper::getSetting('logo')))
                        <span class="logo-sm drfgsedg">
                            <img src="{{asset(AdminHelper::getSetting('logo'))}}" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset(AdminHelper::getSetting('logo'))}}" alt="" height="17">
                        </span>
                        @else
                        <span class="logo-sm">{{AdminHelper::getSetting('appname')}}</span>
                        <span class="logo-lg">
                            {{AdminHelper::getSetting('appname')}}
                        </span>
                        @endif
                    </a>

                    <a href="{{AdminHelper::adminPath()}}" class="logo logo-light">
                        @if(!empty(AdminHelper::getSetting('logo')))
                        <span class="logo-sm dfgdg">
                            <img src="{{asset(AdminHelper::getSetting('logo'))}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset(AdminHelper::getSetting('logo'))}}" alt="" height="50">
                        </span>
                        @else
                        <span class="logo-sm">{{AdminHelper::getSetting('appname')}}</span>
                        <span class="logo-lg">
                            {{AdminHelper::getSetting('appname')}}
                        </span>
                        @endif
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
            </div>

            <div class="d-flex align-items-center">
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item notifications-menu d-none">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        <span
                            class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger notification_count" style="display:none;">0<span
                                class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top" style="background-color:#eb663d !important;">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge badge-soft-light fs-13 notification_count"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <div id="list_notifications">
                                        <div class="text-center pb-5 mt-2">
                                            <h6 class="fs-18 fw-semibold lh-base">Hey! You have no any notifications </h6>
                                        </div>
                                    </div>
                                    <div class="my-3 text-center">
                                        <button type="button" class="btn btn-soft-success waves-effect waves-light" onclick="location.href=''"> Notification <i class="ri-arrow-right-line align-middle"></i></button>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">

                            @if(file_exists(public_path(AdminHelper::myPhoto())))

                            <img class="rounded-circle header-profile-user" src="{{ asset(AdminHelper::myPhoto()) }}"
                                alt="">
                            @endif
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ AdminHelper::myName() }}</span>

                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome</h6>
                        <a class="dropdown-item" href="{{ route('getProfileData') }}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href='{{ route("getLogout") }}'><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>