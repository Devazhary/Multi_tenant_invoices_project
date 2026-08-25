<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
	<div class="container-fluid">
		<div class="main-header-left ">
			<div class="responsive-logo">
				<a href="{{ url('/' . $page = 'dashboard') }}"><img
						src="{{URL::asset('assets/img/brand/invoice-pro-logo(1).png')}}" class="logo-1" alt="logo"></a>
				<a href="{{ url('/' . $page = 'dashboard') }}"><img
						src="{{URL::asset('assets/img/brand/invoice-pro-logo(1).png')}}" class="dark-logo-1"
						alt="logo"></a>
				<a href="{{ url('/' . $page = 'dashboard') }}"><img
						src="{{URL::asset('assets/img/brand/invoice-favicon.png')}}" class="logo-2" alt="logo"></a>
				<a href="{{ url('/' . $page = 'dashboard') }}"><img
						src="{{URL::asset('assets/img/brand/invoice-favicon.png')}}" class="dark-logo-2" alt="logo"></a>
			</div>
			<div class="app-sidebar__toggle" data-toggle="sidebar">
				<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
				<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
			</div>
			<div class="main-header-center mr-3 d-sm-none d-md-none d-lg-block">
				<input class="form-control" placeholder="Search for anything..." type="search"> <button class="btn"><i
						class="fas fa-search d-none d-md-block"></i></button>
			</div>
		</div>
		<div class="main-header-right">
			<div class="nav nav-item  navbar-nav-right ml-auto">
				<div class="nav-link" id="bs-example-navbar-collapse-1">
					<form class="navbar-form" role="search">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search">
							<span class="input-group-btn">
								<button type="reset" class="btn btn-default">
									<i class="fas fa-times"></i>
								</button>
								<button type="submit" class="btn btn-default nav-link resp-btn">
									<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
										fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
										stroke-linejoin="round" class="feather feather-search">
										<circle cx="11" cy="11" r="8"></circle>
										<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
									</svg>
								</button>
							</span>
						</div>
					</form>
				</div>
				@php
					$unreadCount = auth('web')->user()->unreadNotifications->count();
				@endphp
				{{-- Notification wrapper - bell is static, only dropdown content is refreshed via AJAX --}}
				<div id="notification-wrapper" class="dropdown nav-item main-header-notification">
					{{-- Bell anchor is STATIC - must never be replaced (jQuery click event is bound here) --}}
					<a class="new nav-link" href="#">
						<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none"
							stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
							class="feather feather-bell">
							<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
							<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
						</svg>
						@if($unreadCount > 0)
							<span class="pulse"></span>
						@endif
					</a>
					{{-- Dropdown menu - inner content refreshed every 4 seconds via AJAX --}}
					<div class="dropdown-menu">
						<div id="notification-dropdown-content">
							@include('layouts.notification-partial')
						</div>
					</div>
				</div>
				<div class="nav-item full-screen fullscreen-button">
					<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg"
							class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor"
							stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
							class="feather feather-maximize">
							<path
								d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
							</path>
						</svg></a>
				</div>
				<div class="dropdown main-profile-menu nav nav-item nav-link">
					<a class="profile-user d-flex" href=""><img alt=""
							src="{{URL::asset('assets/img/brand/admin.png')}}"></a>
					<div class="dropdown-menu">
						<div class="main-header-profile bg-primary p-3">
							<div class="d-flex wd-100p">
								<div class="main-img-user"><img alt="" src="{{URL::asset('assets/img/brand/admin.png')}}"
										class=""></div>
								<div class="mr-3 my-auto">
									<h6>{{ Auth::user()->name }}</h6><span>{{ Auth::user()->email }}</span>
								</div>
							</div>
						</div>
						<a class="dropdown-item" href=""><i class="bx bx-user-circle"></i>Profile</a>
						<a class="dropdown-item" href=""><i class="bx bx-cog"></i> Edit Profile</a>
						<a class="dropdown-item" href=""><i class="bx bxs-inbox"></i>Inbox</a>
						<a class="dropdown-item" href=""><i class="bx bx-envelope"></i>Messages</a>
						<a class="dropdown-item" href=""><i class="bx bx-slider-alt"></i> Account Settings</a>
						<a class="dropdown-item" href="#"
							onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<i class="bx bx-log-out"></i> تسجيل خروج
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /main-header -->

<script>
(function () {
    'use strict';

    var REFRESH_INTERVAL_MS = 4000;
    var notificationUrl = '{{ route("notifications.partial") }}';
    var wrapper = document.getElementById('notification-wrapper');

    function isDropdownOpen() {
        return wrapper && wrapper.classList.contains('show');
    }

    function refreshNotifications() {
        // لو الـ dropdown مفتوح، مش هنعمل refresh عشان محتاجش يتحرك تحت إيد المستخدم
        if (isDropdownOpen()) return;

        fetch(notificationUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html',
            },
            credentials: 'same-origin'
        })
        .then(function (response) {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(function (html) {
            // نحدّث بس المحتوى الداخلي للـ dropdown - مش الـ bell اللي عليه الـ event
            var dropdownContent = document.getElementById('notification-dropdown-content');
            if (dropdownContent) {
                dropdownContent.innerHTML = html;
            }
        })
        .catch(function (error) {
            console.warn('[Notifications] Refresh failed:', error);
        });
    }

    // ابدأ الـ polling بعد تحميل الصفحة
    setInterval(refreshNotifications, REFRESH_INTERVAL_MS);

})();
</script>