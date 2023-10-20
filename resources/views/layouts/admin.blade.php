<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin-assets/images/favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/animate.css.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/libs/datetimepicker/datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/libs/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/libs/dropzone/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}">
    @yield('styles')
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <a class="navbar-brand" href="{{ route('dashboard') }}">                        
                        <span class="logo-text">
                            <img src="{{ asset('admin-assets/images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="dark-logo" />
                        </span>
                    </a>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-18"></i>
                                <div class="notify">
                                    <span class="heartbit"></span>
                                    <span class="point"></span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <ul class="list-style-none">
                                    <li>
                                        <div class="drop-title border-bottom">You have 3 new Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center notifications">
                                            <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-danger btn-circle"><i class="fa fa-link"></i></span>
                                                <span class="mail-contnet">
                                                    <h5 class="message-title">Luanch Admin</h5> 
                                                    <span class="mail-desc">Just see the my new admin!</span> 
                                                    <span class="time">9:30 AM</span> 
                                                </span>
                                            </a>
                                            <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-success btn-circle"><i class="ti-calendar"></i></span>
                                                <span class="mail-contnet">
                                                    <h5 class="message-title">Event today</h5> 
                                                    <span class="mail-desc">Just a reminder that you have event</span> 
                                                    <span class="time">9:10 AM</span> 
                                                </span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center mb-1 text-dark" href="javascript:void(0);"> <strong>See all Notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                    </ul>
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('admin-assets/images/avatar.png') }}" alt="{{ Auth::user()->name }}" class="rounded-circle" width="31">
                                <span class="ml-2 user-text font-medium">{{ Auth::user()->name }}</span>
                                <span class="fas fa-angle-down ml-2 user-text"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <div class="d-flex no-block align-items-center p-3 mb-2 border-bottom">
                                    <div class=""><img src="{{ asset('admin-assets/images/avatar.png') }}" alt="{{ Auth::user()->name }}" class="rounded" width="80"></div>
                                    <div class="ml-2">
                                        <h4 class="mb-0">{{ Auth::user()->name }}</h4>
                                        <p class=" mb-0 text-muted">{{ Auth::user()->email }}</p>
                                        <a href="{{ route('profile') }}" class="btn btn-sm btn-danger text-white mt-2 btn-rounded">{{ __('lang.MyProfile') }}</a>
                                    </div>
                                </div>
                                {{-- <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings mr-1 ml-1"></i> {{ __('lang.AccountSetting') }}</a>
                                <div class="dropdown-divider"></div> --}}
                                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off mr-1 ml-1"></i> {{ __('lang.Logout') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item {{ Request::routeIs('dashboard') ? 'selected' : ''}}">
                            <a class="sidebar-link {{ Request::routeIs('dashboard') ? 'active' : ''}}" href="{{ route('dashboard') }}">
                                <span class="hide-menu">{{ __('lang.Dashboard') }}</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ (Request::routeIs('lead.*')) ? 'selected' : ''}}">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <span class="hide-menu">{{ __('lang.Leads') }}</span>
                                <i class="d-none d-sm-block fas fa-angle-down"></i>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ (Request::routeIs('lead.*')) ? 'in' : ''}}">
                                <li class="sidebar-item {{ Request::routeIs('lead.create') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('lead.create') }}">
                                        <span class="hide-menu">{{ __('lang.AddNewLead') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-item {{ Request::routeIs('lead.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('lead.index') }}">
                                        <span class="hide-menu">{{ __('lang.AllLeads') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-item {{ Request::routeIs('lead.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('lead.index') }}">
                                        <span class="hide-menu">{{ __('lang.TodayLeads') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-item {{ (Request::routeIs('account.*')) ? 'selected' : ''}}">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <span class="hide-menu">{{ __('lang.Accounts') }}</span>
                                <i class="d-none d-sm-block fas fa-angle-down"></i>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ (Request::routeIs('account.*')) ? 'in' : ''}}">
                                <li class="sidebar-item {{ Request::routeIs('account.create') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('account.create') }}">
                                        <span class="hide-menu">{{ __('lang.AddNewAccount') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-item {{ Request::routeIs('account.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('account.index') }}">
                                        <span class="hide-menu">{{ __('lang.AllAccounts') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-item {{ (Request::routeIs('contact.*')) ? 'selected' : ''}}">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <span class="hide-menu">{{ __('lang.Contacts') }}</span>
                                <i class="d-none d-sm-block fas fa-angle-down"></i>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ (Request::routeIs('contact.*')) ? 'in' : ''}}">
                                <li class="sidebar-item {{ Request::routeIs('contact.create') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('contact.create') }}">
                                        <span class="hide-menu">{{ __('lang.AddNewContact') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-item {{ Request::routeIs('contact.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('contact.index') }}">
                                        <span class="hide-menu">{{ __('lang.AllContacts') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item {{ (Request::routeIs('task.*')) ? 'selected' : ''}}">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <span class="hide-menu">{{ __('lang.Tasks') }}</span>
                                <i class="d-none d-sm-block fas fa-angle-down"></i>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ (Request::routeIs('task.*')) ? 'in' : ''}}">
                                <li class="sidebar-item {{ Request::routeIs('task.create') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('task.create') }}">
                                        <span class="hide-menu">{{ __('lang.AddNewTask') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-item {{ Request::routeIs('task.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('task.index') }}">
                                        <span class="hide-menu">{{ __('lang.AllTasks') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-item {{ Request::routeIs('task.delegated') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('task.delegated') }}">
                                        <span class="hide-menu">{{ __('lang.DelegatedTasks') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-item {{ Request::routeIs('task.today') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('task.today') }}">
                                        <span class="hide-menu">{{ __('lang.TodayTasks') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-item {{ (Request::routeIs('event.*')) ? 'selected' : ''}}">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <span class="hide-menu">{{ __('lang.Events') }}</span>
                                <i class="d-none d-sm-block fas fa-angle-down"></i>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ (Request::routeIs('event.*')) ? 'in' : ''}}">
                                <li class="sidebar-item {{ Request::routeIs('event.create') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('event.create') }}">
                                        <span class="hide-menu">{{ __('lang.AddNewEvent') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-item {{ Request::routeIs('event.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('event.index') }}">
                                        <span class="hide-menu">{{ __('lang.AllEvents') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-item {{ Request::routeIs('event.calender') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('event.calender') }}">
                                        <span class="hide-menu">{{ __('lang.Calendar') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        @role('Super Admin')
                        <li class="sidebar-item {{ (Request::routeIs('email.*') || Request::routeIs('note.*') || Request::routeIs('file.*')) ? 'selected' : ''}}">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <span class="hide-menu">{{ __('lang.Others') }}</span>
                                <i class="d-none d-sm-block fas fa-angle-down"></i>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ (Request::routeIs('email.*') || Request::routeIs('note.*') || Request::routeIs('file.*')) ? 'in' : ''}}">
                                @can('list email')
                                <li class="sidebar-item {{ Request::routeIs('email.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('email.index') }}">
                                        <span class="hide-menu">{{ __('lang.Emails') }}</span>
                                    </a>
                                </li>
                                @endcan
                                
                                @can('list note')
                                <li class="sidebar-item {{ Request::routeIs('note.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('note.index') }}">
                                        <span class="hide-menu">{{ __('lang.Notes') }}</span>
                                    </a>
                                </li>
                                @endcan
                                
                                @can('list file')
                                <li class="sidebar-item {{ Request::routeIs('file.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('file.index') }}">
                                        <span class="hide-menu">{{ __('lang.Files') }}</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        
                        <li class="sidebar-item {{ (Request::routeIs('setting.*')) ? 'selected' : ''}}">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <span class="hide-menu">{{ __('lang.Constants') }}</span>
                                <i class="d-none d-sm-block fas fa-angle-down"></i>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ (Request::routeIs('setting.*')) ? 'in' : ''}}">
                                @can('list salutation')
                                <li class="sidebar-item {{ Request::routeIs('setting.salutation.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('setting.salutation.index') }}">
                                        <span class="hide-menu">{{ __('lang.Salutations') }}</span>
                                    </a>
                                </li>
                                @endcan
                                
                                @can('list industry')
                                <li class="sidebar-item {{ Request::routeIs('setting.industry.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('setting.industry.index') }}">
                                        <span class="hide-menu">{{ __('lang.Industries') }}</span>
                                    </a>
                                </li>
                                @endcan
                                
                                @can('list lead-status')
                                <li class="sidebar-item {{ Request::routeIs('setting.lead-status.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('setting.lead-status.index') }}">
                                        <span class="hide-menu">{{ __('lang.LeadStatus') }}</span>
                                    </a>
                                </li>
                                @endcan
                                
                                @can('list rating')
                                <li class="sidebar-item {{ Request::routeIs('setting.rating.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('setting.rating.index') }}">
                                        <span class="hide-menu">{{ __('lang.Ratings') }}</span>
                                    </a>
                                </li>
                                @endcan
                                
                                @can('list source')
                                <li class="sidebar-item {{ Request::routeIs('setting.source.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('setting.source.index') }}">
                                        <span class="hide-menu">{{ __('lang.Sources') }}</span>
                                    </a>
                                </li>
                                @endcan
                                
                                @can('list account-type')
                                <li class="sidebar-item {{ Request::routeIs('setting.account-type.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('setting.account-type.index') }}">
                                        <span class="hide-menu">{{ __('lang.AccountTypes') }}</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="sidebar-item {{ (Request::routeIs('user.*')) ? 'selected' : ''}}">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <span class="hide-menu">{{ __('lang.Settings') }}</span>
                                <i class="d-none d-sm-block fas fa-angle-down"></i>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ (Request::routeIs('user.*')) ? 'in' : ''}}">
                                @can('list user')
                                <li class="sidebar-item {{ Request::routeIs('user.index') ? 'active' : ''}}">
                                    <a class="sidebar-link" href="{{ route('user.index') }}">
                                        <span class="hide-menu">{{ __('lang.Users') }}</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endrole
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-wrapper" id="app">
            @yield('content')

            <footer class="footer text-center">
                {{ __('lang.AllRightsReserved') }} {{ config('app.name', 'Laravel') }}.
            </footer>
        </div>
    </div>

    <script src="{{ asset('admin-assets/libs/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/popper.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/jquery-ui-sortable.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/datetimepicker/datetimepicker.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('admin-assets/js/custom.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.js') }}"></script>

    <script>
        @if (session('successMessage'))
        Swal.fire({
            title: 'Success!',
            text: "{!! session('successMessage') !!}",
            type: 'success',
            confirmButtonText: 'Ok'
        });

        @elseif (session('errorMessage'))
        Swal.fire({
            title: 'Error!',
            text: "{!! session('errorMessage') !!}",
            type: 'error',
            confirmButtonText: 'Ok'
        });
        @endif
    </script>

    @yield('scripts')
</html>
