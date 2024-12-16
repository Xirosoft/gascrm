<!-- Main SideBar Start -->
<div class="flyOut-sidebar">
    <div id="sideBar" class="">
        <!-- Main Logo Start -->
        <div class="main__logo">
            <a href="dashboard.html" class="brand__logo">
                <img src="{{ asset('admin-assets/images/logo.png') }}" alt="brand-logo" />
            </a>
            <div id="toggle__btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M22 12H3" stroke="#000000" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                    <path d="M22 4H13" stroke="#000000" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                    <path d="M22 20H13" stroke="#000000" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                    <path d="M7 7L2 12L7 17" stroke="#000000" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </svg>
            </div>
        </div>
        <!-- Main Logo End -->
        <!-- NavItem Start -->
        <ul class="nav__item">
            <li class="nav__heading">General</li>
            <!-- Navlist Start -->
            <li class="nav__list {{ Request::routeIs('dashboard') ? 'active' : ''}}"">
                <a href=" {{ route('dashboard') }}">
                <div class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 20V10M12 20V4M6 20V14" stroke="#EB5E28" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="link__name">{{ __('lang.Dashboard') }}</span>
                </a>
            </li>

            <li class="nav__list nav__dropdown {{ (Request::routeIs('lead.*')) ? 'active' : ''}}">
                <a href="javascript:void(0)">
                    <div class="icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 17L12 22L22 17M2 12L12 17L22 12M12 2L2 7L12 12L22 7L12 2Z"
                                stroke="#667085" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="link__name">{{ __('lang.Leads') }}</span>
                </a>
                <!-- Dropdown -->
                <ul class="sub__menu">
                    <li><a href="{{ route('lead.create') }}">{{ __('lang.AddNewLead') }}</a></li>
                    <li><a href="{{ route('lead.index') }}">{{ __('lang.AllLeads') }}</a></li>
                    <li><a href="{{ route('lead.index') }}">{{ __('lang.TodayLeads') }}</a></li>
                </ul>
                <!-- Dropdown -->
            </li>

            <li class="nav__list nav__dropdown {{ (Request::routeIs('contact.*')) ? 'active' : ''}}">
                <a href="javascript:void(0)">
                    <div class="icon">
                        <svg width="24" height="20" viewBox="0 0 24 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17 19V17C17 15.9391 16.5786 14.9217 15.8284 14.1716C15.0783 13.4214 14.0609 13 13 13H5C3.93913 13 2.92172 13.4214 2.17157 14.1716C1.42143 14.9217 1 15.9391 1 17V19M23 19V17C22.9993 16.1137 22.7044 15.2528 22.1614 14.5523C21.6184 13.8519 20.8581 13.3516 20 13.13M16 1.13C16.8604 1.3503 17.623 1.8507 18.1676 2.55231C18.7122 3.25392 19.0078 4.11683 19.0078 5.005C19.0078 5.89317 18.7122 6.75608 18.1676 7.45769C17.623 8.1593 16.8604 8.6597 16 8.88M13 5C13 7.20914 11.2091 9 9 9C6.79086 9 5 7.20914 5 5C5 2.79086 6.79086 1 9 1C11.2091 1 13 2.79086 13 5Z"
                                stroke="#667085" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="link__name">{{ __('lang.Contacts') }}</span>
                </a>
                <!-- Dropdown -->
                <ul class="sub__menu">
                    <li><a href="{{ route('contact.create') }}">{{ __('lang.AddNewContact') }}</a></li>
                    <li><a href="{{ route('contact.index') }}">{{ __('lang.AllContacts') }}</a></li>
                </ul>
                <!-- Dropdown -->
            </li>

            <li class="nav__list nav__dropdown {{ (Request::routeIs('task.*')) ? 'active' : ''}}">
                <a href="javascript:void(0)">
                    <div class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.75 3C0.75 1.75736 1.75736 0.75 3 0.75H7C8.24264 0.75 9.25 1.75736 9.25 3V9C9.25 9.13807 9.13807 9.25 9 9.25H3C1.75736 9.25 0.75 8.24264 0.75 7V3ZM3 20.75C1.75736 20.75 0.75 19.7426 0.75 18.5L0.75 14.5C0.75 13.2574 1.75736 12.25 3 12.25H9C9.13807 12.25 9.25 12.3619 9.25 12.5V18.5C9.25 19.7426 8.24264 20.75 7 20.75H3ZM20.75 18.5C20.75 19.7426 19.7426 20.75 18.5 20.75H14.5C13.2574 20.75 12.25 19.7426 12.25 18.5V12.5C12.25 12.3619 12.3619 12.25 12.5 12.25L18.5 12.25C19.7426 12.25 20.75 13.2574 20.75 14.5V18.5ZM18.5 0.75C19.7426 0.75 20.75 1.75736 20.75 3V7C20.75 8.24264 19.7426 9.25 18.5 9.25H12.5C12.3619 9.25 12.25 9.13807 12.25 9V3C12.25 1.75736 13.2574 0.75 14.5 0.75L18.5 0.75Z"
                                stroke="#667085" stroke-width="1.5" />
                        </svg>
                    </div>
                    <span class="link__name">{{ __('lang.Tasks') }}</span>
                </a>
                <!-- Dropdown -->
                <ul class="sub__menu">
                    <li><a href="{{ route('task.create') }}">{{ __('lang.AddNewTask') }}</a></li>
                    <li><a href="{{ route('task.index') }}">{{ __('lang.AllTasks') }}</a></li>
                </ul>
                <!-- Dropdown -->
            </li>

            <li class="nav__list nav__dropdown {{ (Request::routeIs('event.*')) ? 'active' : ''}}">
                <a href="javascript:void(0)">
                    <div class="icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9 11L12 14L22 4M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16"
                                stroke="#667085" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="link__name">{{ __('lang.Events') }}</span>
                </a>
                <!-- Dropdown -->
                <ul class="sub__menu">
                    <li><a href="{{ route('event.create') }}">{{ __('lang.AddNewEvent') }}</a></li>
                    <li><a href="{{ route('event.index') }}">{{ __('lang.AllEvents') }}</a></li>
                    <li><a href="{{ route('event.calender') }}">{{ __('lang.Calendar') }}</a></li>
                </ul>
                <!-- Dropdown -->
            </li>
            
            <li class="nav__heading">Other</li>
            @role('Super Admin')
            <!-- Navlist Start -->
            <li class="nav__list nav__dropdown {{ (Request::routeIs('email.*') || Request::routeIs('note.*') || Request::routeIs('file.*')) ? 'active' : ''}}">
                <a href="#">
                    <div class="icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path
                                d="M2 12.88V11.12C2 10.08 2.85 9.22 3.9 9.22C5.71 9.22 6.45 7.94 5.54 6.37C5.02 5.47 5.33 4.3 6.24 3.78L7.97 2.79C8.76 2.32 9.78 2.6 10.25 3.39L10.36 3.58C11.26 5.15 12.74 5.15 13.65 3.58L13.76 3.39C14.23 2.6 15.25 2.32 16.04 2.79L17.77 3.78C18.68 4.3 18.99 5.47 18.47 6.37C17.56 7.94 18.3 9.22 20.11 9.22C21.15 9.22 22.01 10.07 22.01 11.12V12.88C22.01 13.92 21.16 14.78 20.11 14.78C18.3 14.78 17.56 16.06 18.47 17.63C18.99 18.54 18.68 19.7 17.77 20.22L16.04 21.21C15.25 21.68 14.23 21.4 13.76 20.61L13.65 20.42C12.75 18.85 11.27 18.85 10.36 20.42L10.25 20.61C9.78 21.4 8.76 21.68 7.97 21.21L6.24 20.22C5.33 19.7 5.02 18.53 5.54 17.63C6.45 16.06 5.71 14.78 3.9 14.78C2.85 14.78 2 13.92 2 12.88Z"
                                stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <span class="link__name">Settings</span>
                </a>
                <!-- Dropdown -->
                <ul class="sub__menu">
                    @can('list email')
                    <li><a href="{{ route('email.index') }}">{{ __('lang.Emails') }}</a></li>
                    @endcan
                    @can('list email')
                    <li><a href="{{ route('note.index') }}">{{ __('lang.Notes') }}</a></li>
                    @endcan
                    @can('list note')
                    <li><a href="{{ route('file.index') }}">{{ __('lang.Files') }}</a></li>
                    @endcan
                </ul>
                <!-- Dropdown -->
            </li>

            <li class="nav__list nav__dropdown {{ (Request::routeIs('setting.*')) ? 'active' : ''}}">
                <a href="#">
                    <div class="icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 17L12 22L22 17M2 12L12 17L22 12M12 2L2 7L12 12L22 7L12 2Z"
                                stroke="#667085" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="link__name">{{ __('lang.Constants') }}</span>
                </a>
                <!-- Dropdown -->
                <ul class="sub__menu">
                    @can('list salutation')
                    <li><a href="{{ route('setting.salutation.index') }}">{{ __('lang.salutation') }}</a></li>
                    @endcan
                    @can('list industry')
                    <li><a href="{{ route('setting.industry.index') }}">{{ __('lang.Industries') }}</a></li>
                    @endcan
                    @can('list rating')
                    <li><a href="{{ route('setting.rating.index') }}">{{ __('lang.LeadStatus') }}</a></li>
                    @endcan
                    @can('list rating')
                    <li><a href="{{ route('setting.rating.index') }}">{{ __('lang.Ratings') }}</a></li>
                    @endcan
                    @can('list source')
                    <li><a href="{{ route('setting.source.index') }}">{{ __('lang.Sources') }}</a></li>
                    @endcan
                    @can('list account-type')
                    <li><a href="{{ route('setting.account-type.index') }}">{{ __('lang.AccountTypes') }}</a></li>
                    @endcan
                </ul>
                <!-- Dropdown -->
            </li>

            <li class="nav__list nav__dropdown {{ (Request::routeIs('user.*')) ? 'active' : ''}}">
                <a href="#">
                    <div class="icon">
                        <svg width="24" height="20" viewBox="0 0 24 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17 19V17C17 15.9391 16.5786 14.9217 15.8284 14.1716C15.0783 13.4214 14.0609 13 13 13H5C3.93913 13 2.92172 13.4214 2.17157 14.1716C1.42143 14.9217 1 15.9391 1 17V19M23 19V17C22.9993 16.1137 22.7044 15.2528 22.1614 14.5523C21.6184 13.8519 20.8581 13.3516 20 13.13M16 1.13C16.8604 1.3503 17.623 1.8507 18.1676 2.55231C18.7122 3.25392 19.0078 4.11683 19.0078 5.005C19.0078 5.89317 18.7122 6.75608 18.1676 7.45769C17.623 8.1593 16.8604 8.6597 16 8.88M13 5C13 7.20914 11.2091 9 9 9C6.79086 9 5 7.20914 5 5C5 2.79086 6.79086 1 9 1C11.2091 1 13 2.79086 13 5Z"
                                stroke="#667085" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="link__name">{{ __('lang.Users') }}</span>
                </a>
                <!-- Dropdown -->
                <ul class="sub__menu">
                    @can('list user')
                    <li><a href="{{ route('setting.salutation.index') }}">{{ __('lang.Users') }}</a></li>
                    @endcan
                </ul>
                <!-- Dropdown -->
            </li>
            @endrole
        </ul>
    </div>
</div>
<!-- Main SideBar End -->