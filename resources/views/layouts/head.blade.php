<!-- Title -->
<title>@yield('title')</title>
<!-- Favicon -->
<link rel="icon" href="{{URL::asset('assets/img/brand/invoice-favicon.png')}}" type="image/x-icon" />
<!-- Icons css -->
<link href="{{URL::asset('assets/css/icons.css')}}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" />
<!--  Sidebar css -->
<link href="{{URL::asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
<!-- Sidemenu css -->
<link rel="stylesheet" href="{{URL::asset('assets/css-rtl/sidemenu.css')}}">
@yield('css')
<!--- Style css -->
<link href="{{URL::asset('assets/css-rtl/style.css')}}" rel="stylesheet">
<!--- Dark-mode css -->
<link href="{{URL::asset('assets/css-rtl/style-dark.css')}}" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{URL::asset('assets/css-rtl/skin-modes.css')}}" rel="stylesheet">

<style>
	/* Custom styling for clean notification list */
	.main-header-notification .dropdown-menu {
		box-shadow: 0 10px 30px rgba(0,0,0,0.1);
		border: 1px solid #e8e8f7;
		border-radius: 8px;
		overflow: hidden;
	}
	.main-notification-list .notification-item {
		transition: background-color 0.2s ease, padding 0.2s ease;
	}
	.main-notification-list .notification-item:hover {
		background-color: #f8f9fa;
		text-decoration: none;
	}
	.main-notification-list .unread-notification {
		background-color: #f4f6fb;
		border-right: 4px solid #0162e8;
	}
	.unread-indicator {
		display: inline-block;
		width: 8px;
		height: 8px;
		background-color: #0162e8;
		border-radius: 50%;
		box-shadow: 0 0 5px rgba(1, 98, 232, 0.5);
		animation: pulse-dot 1.5s infinite;
	}
	@keyframes pulse-dot {
		0% { box-shadow: 0 0 0 0 rgba(1, 98, 232, 0.4); }
		70% { box-shadow: 0 0 0 6px rgba(1, 98, 232, 0); }
		100% { box-shadow: 0 0 0 0 rgba(1, 98, 232, 0); }
	}
	.notification-label {
		font-size: 14px;
		font-weight: 600;
		color: #3b4863;
		line-height: 1.3;
	}
	.notification-label.text-primary {
		color: #0162e8 !important;
	}
	.notification-subtext {
		font-size: 11.5px;
		margin-top: 4px;
	}
	.menu-header-content {
		padding: 15px 20px !important;
	}
</style>