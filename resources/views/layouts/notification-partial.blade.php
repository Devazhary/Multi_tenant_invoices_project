@php
    $unreadCount = auth('web')->user()->unreadNotifications->count();
    $notifications = auth('web')->user()->notifications;
@endphp
<div class="menu-header-content bg-primary text-right">
    <div class="d-flex">
        <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">الإشعارات</h6>
        <a href="{{ route('markAllRead') }}"
            class="badge badge-pill badge-warning mr-auto my-auto float-left">تحديد الكل
            كمقروء</a>
    </div>
    <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">
        @if($unreadCount > 0)
            لديك {{ $unreadCount }} إشعار غير مقروء
        @else
            لا توجد إشعارات جديدة
        @endif
    </p>
</div>

<div class="main-notification-list Notification-scroll">
    @foreach ($notifications as $notification)
        @php $isUnread = is_null($notification->read_at); @endphp
        <a class="d-flex p-3 border-bottom notification-item {{ $isUnread ? 'unread-notification' : '' }}"
            href="{{ route('invoices.details', $notification->data['invoice_id']) }}">
            <div class="mr-3 w-100">
                <h5 class="notification-label mb-1 {{ $isUnread ? 'text-primary' : '' }}">
                    {{ $notification->data['title'] }}</h5>
                <div class="notification-subtext text-muted">
                    {{ $notification->created_at->diffForHumans() }}
                </div>
            </div>
            @if($isUnread)
                <div class="ml-auto mt-2">
                    <span class="unread-indicator"></span>
                </div>
            @endif
        </a>
    @endforeach
</div>
