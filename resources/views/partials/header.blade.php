<!-- Header Start -->
<div class="header__dashboard">
    <div class="header__left">
        <div class="main__logo">
            <a href="{{ route('dashboard') }}" class="brand__logo">
                <img src="{{ asset('admin-assets/images/logo.png') }}" alt="brand-logo">
            </a>
        </div>
        <div class="header__search">
            <form action="search.html" method="post" class="search__form search__form--v2">
                <input type="search" class="form-control" name="search" placeholder="Search" />
                <button type="submit">
                    <img src="{{ asset('images/search.png') }}" alt="search" />
                </button>
            </form>
        </div>
        <div class="custom__dropdown">
            <div class="product__add dropdown__btn" id="quick__add">
                <a href="#" class="product__item selected">
                    <div class="icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 1V15" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M1 8H15" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </a>
                <ul class="dropdown__list list p-0">   
                    <li>
                        <a href="profile.html" class="ps-4">
                            <i class="fa-solid fa-plus"></i> Add Lead
                        </a>
                    </li>
                    <li> <a href="d-general-setting.html" class="ps-4">
                            <i class="fa-solid fa-plus"></i> Add Customer
                        </a>
                    </li>
                    <li>
                        <a href="login.html" class="ps-4">
                            <i class="fa-solid fa-plus"></i> Add User
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="header__right">
        <div id="toggler__btn">
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
        <div class="dropdown__btn fullscreen-button">
            <a class="full-screen-link drop__action--btn" href="javascript:void(0);">
                <i class="fa-solid fa-expand"></i>
            </a>
        </div>
        <div class="dropdown__btn">
            <a href="#" class="message__button drop__action--btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M22 10V13C22 17 20 19 16 19H15.5C15.19 19 14.89 19.15 14.7 19.4L13.2 21.4C12.54 22.28 11.46 22.28 10.8 21.4L9.3 19.4C9.14 19.18 8.77 19 8.5 19H8C4 19 2 18 2 13V8C2 4 4 2 8 2H14"
                        stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M15.9965 11H16.0054" stroke="#292D32" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M11.9945 11H12.0035" stroke="#292D32" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M7.99451 11H8.00349" stroke="#292D32" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <div class="dot"></div>
            </a>
            <ul class="dropdown__list dropdown__list--v2">
                <li>
                    <h4 class="header__title">Message</h4>
                </li>
                <li>
                    <a href="#" class="chat__user chat__user--unread">
                        <div class="chat__avatar">
                            <div class="user__status user__status--block"></div>
                            <img src="assets/images/avatar.jpg" alt="avatar" />
                        </div>
                        <div class="chat__user__content">
                            <h4 class="name">Arlene McCoy</h4>
                            <p class="lastMsg">You: Free Real Estate...</p>
                            <span class="chat__user__msgAge">just now</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="chat__user">
                        <div class="chat__avatar">
                            <div class="user__status user__status--away"></div>
                            <img src="assets/images/avatar.jpg" alt="avatar" />
                        </div>
                        <div class="chat__user__content">
                            <h4 class="name">Ralph Edwards</h4>
                            <p class="lastMsg">Internet Banner...</p>
                            <span class="chat__user__msgAge">15mn</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="chat__user">
                        <div class="chat__avatar">
                            <div class="user__status"></div>
                            <img src="assets/images/avatar.jpg" alt="avatar" />
                        </div>
                        <div class="chat__user__content">
                            <h4 class="name">Cameron Williamson</h4>
                            <p class="lastMsg">Influencing The...</p>
                            <span class="chat__user__msgAge">25mn</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="chat__user chat__user--unread">
                        <div class="chat__avatar">
                            <div class="user__status user__status--active"></div>
                            <img src="assets/images/avatar.jpg" alt="avatar" />
                        </div>
                        <div class="chat__user__content">
                            <h4 class="name">Jenny Wilson</h4>
                            <p class="lastMsg">How To Boost Traffic...</p>
                            <span class="chat__user__msgAge">3h</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="chat__user">
                        <div class="chat__avatar">
                            <div class="user__status"></div>
                            <img src="assets/images/avatar.jpg" alt="avatar" />
                        </div>
                        <div class="chat__user__content">
                            <h4 class="name">Dianne Russell</h4>
                            <p class="lastMsg">7 Ways To Advertise...</p>
                            <span class="chat__user__msgAge">7h</span>
                        </div>
                    </a>
                </li>
                <li class="show__btn text-center">
                    <a href="#" class="solid__btn">Show All</a>
                </li>
            </ul>
        </div>
        <div class="dropdown__btn">
            <a href="#" class="notification__button drop__action--btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.0206 2.91C8.71058 2.91 6.02058 5.6 6.02058 8.91V11.8C6.02058 12.41 5.76058 13.34 5.45058 13.86L4.30058 15.77C3.59058 16.95 4.08058 18.26 5.38058 18.7C9.69058 20.14 14.3406 20.14 18.6506 18.7C19.8606 18.3 20.3906 16.87 19.7306 15.77L18.5806 13.86C18.2806 13.34 18.0206 12.41 18.0206 11.8"
                        stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" />
                    <path
                        d="M13.8699 3.2C13.5599 3.11 13.2399 3.04 12.9099 3C11.9499 2.88 11.0299 2.95 10.1699 3.2C10.4599 2.46 11.1799 1.94 12.0199 1.94C12.8599 1.94 13.5799 2.46 13.8699 3.2Z"
                        stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M15.0195 19.06C15.0195 20.71 13.6695 22.06 12.0195 22.06C11.1995 22.06 10.4395 21.72 9.89953 21.18C9.35953 20.64 9.01953 19.88 9.01953 19.06"
                        stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" />
                </svg>
                <div class="dot"></div>
            </a>
            <ul class="dropdown__list dropdown__list--v2">
                <li>
                    <h4 class="header__title">Notifications</h4>
                </li>
                <li>
                    <a href="#" class="notification__wrap">
                        <div class="icon">
                            <img src="assets/images/notification/avatar-01.png" alt="avatar" />
                        </div>
                        <div class="content">
                            <h5 class="title">
                                <span class="text-gray">Jane Cooper</span>
                                recently
                                <span class="text-black">Cancelled order</span>
                            </h5>
                            <span>5 min ago</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="notification__wrap">
                        <div class="icon">
                            <img src="assets/images/notification/icon-01.png" alt="avatar" />
                        </div>
                        <div class="content">
                            <h5 class="title">
                                <span class="text-gray">New Report</span>
                                has been received
                            </h5>
                            <span>5 min ago</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="notification__wrap">
                        <div class="icon">
                            <img src="assets/images/notification/Icon-02.png" alt="avatar" />
                        </div>
                        <div class="content">
                            <h5 class="title">
                                <span class="text-gray">Received</span>
                                <span class="span">$10,000</span>
                                usd for new shipment
                            </h5>
                            <span>5 min ago</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="notification__wrap">
                        <div class="icon">
                            <img src="assets/images/notification/avatar-01.png" alt="avatar" />
                        </div>
                        <div class="content">
                            <h5 class="title">
                                <span class="text-gray">Jane Cooper</span>
                                recently
                                <span class="text-black">Cancelled order</span>
                            </h5>
                            <span>5 min ago</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="notification__wrap">
                        <div class="icon">
                            <img src="assets/images/notification/icon-01.png" alt="avatar" />
                        </div>
                        <div class="content">
                            <h5 class="title">
                                <span class="text-gray">New Report</span>
                                has been received
                            </h5>
                            <span>5 min ago</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="notification__wrap">
                        <div class="icon">
                            <img src="assets/images/notification/Icon-02.png" alt="avatar" />
                        </div>
                        <div class="content">
                            <h5 class="title">
                                <span class="text-gray">Received</span>
                                <span class="span">$10,000</span>
                                usd for new shipment
                            </h5>
                            <span>5 min ago</span>
                        </div>
                    </a>
                </li>
                <li class="show__btn text-center">
                    <a href="#" class="solid__btn">Show All</a>
                </li>
            </ul>
        </div>

        <div class="dropdown__btn">
            <a href="#" class="avatar__button drop__action--btn">
                <img src="{{ asset('admin-assets/images/avatar.png') }}" alt="{{ Auth::user()->name }}" />
            </a>
            <ul class="dropdown__list">
                <li class="active">
                    <a href="{{ route('profile') }}">
                        <i class="fa-solid fa-user"></i>
                        {{ __('lang.MyProfile') }}
                    </a>
                </li>
                <li>
                    <a href="d-general-setting.html">
                        <i class="fa-solid fa-gear"></i>
                        {{ __('lang.AccountSetting') }}
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off mr-1 ml-1"></i> {{ __('lang.Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Header End -->