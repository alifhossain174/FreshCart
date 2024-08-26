<div class="getcom-user-sidebar">
    <div class="user-sidebar-head">
        <div class="user-sidebar-profile">
            @if(Auth::user()->image)
                <img alt="" src="{{env('ADMIN_URL')."/".Auth::user()->image}}" />
            @endif
        </div>
        <div class="user-sidebar-profile-info">
            <h5>{{Auth::user()->name}}</h5>
            <p>{{Auth::user()->email}}</p>
            <p>{{Auth::user()->phone}}</p>
            <div class="user-sidebar-profile-btn">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fi-rr-sign-out-alt"></i>Logout</a>
            </div>
        </div>
    </div>
    <div class="user-sidebar-menus">
        <ul class="user-sidebar-menu-list">
            <li>
                <a class="{{ (Request::path() == 'home') ? 'active' : ''}}" href="{{url('/home')}}"><i class="fi-ss-apps"></i>Dashboard</a>
            </li>
            <li>
                <a class="{{ (Request::path() == 'my/orders') || (str_contains(Request::path(), 'order/details')) || (str_contains(Request::path(), 'track/my/order')) ? 'active' : ''}}" href="{{url('/my/orders')}}"><i class="fi-ss-shopping-cart"></i>My orders</a>
            </li>
            <li>
                <a class="{{ (Request::path() == 'my/wishlists') ? 'active' : ''}}" href="{{url('/my/wishlists')}}"><i class="fi-ss-heart"></i>Wishlist's</a>
            </li>
            <li>
                <a class="{{ (Request::path() == 'promo/coupons') ? 'active' : ''}}" href="{{url('/promo/coupons')}}"><i class="fi-ss-ticket"></i>Promo/ Coupon</a>
            </li>
            <li>
                <a class="{{ (Request::path() == 'user/address') ? 'active' : ''}}" href="{{url('user/address')}}"><i class="fi-ss-map-marker"></i>Address</a>
            </li>
            <li>
                <a class="{{ (Request::path() == 'my/payments') ? 'active' : ''}}" href="{{url('/my/payments')}}"><i class="fi-ss-credit-card"></i>Payments</a>
            </li>
            <li>
                <a class="{{ (Request::path() == 'product/reviews') ? 'active' : ''}}" href="{{url('/product/reviews')}}"><i class="fi-ss-star"></i>Product reviews</a>
            </li>
            <li>
                <a class="{{ (Request::path() == 'support/tickets') || (Request::path() == 'create/ticket') || (str_contains(Request::path(), 'support/ticket/message')) ? 'active' : ''}}" href="{{url('/support/tickets')}}"><i class="fi-ss-comments"></i>Support tickets</a>
            </li>
            <li>
                <a class="{{ (Request::path() == 'manage/profile') ? 'active' : ''}}" href="{{url('/manage/profile')}}"><i class="fi-ss-settings"></i>Manage profile</a>
            </li>
            <li>
                <a class="{{ (Request::path() == 'change/password') ? 'active' : ''}}" href="{{url('change/password')}}"><i class="fi-ss-password"></i>Change password</a>
            </li>
        </ul>
    </div>
</div>
