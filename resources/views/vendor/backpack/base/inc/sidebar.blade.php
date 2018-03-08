@if (Auth::check())
    <aside class="main-sidebar">
      <section class="sidebar">
        @include('backpack::inc.sidebar_user_panel')

        <ul class="sidebar-menu">



          @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
            <li class="header">{{ trans('app.admin') }}</li>

              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/home') }}"><i class="fa fa-home"></i> <span>{{ trans('app.home') }}</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/sale') }}"><i class="fa fa-image"></i> <span>{{ trans('app.sale') }}</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/client') }}"><i class="fa fa-user"></i> <span>{{ trans('app.client') }}</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/hotel') }}"><i class="fa fa-building"></i> <span>{{ trans('app.hotels') }}</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/item') }}"><i class="fa fa-bus"></i> <span>{{ trans('app.items') }}</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/payment') }}"><i class="fa fa-money"></i> <span>{{ trans('app.payments') }}</span></a></li>

              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}"><i class="fa fa-key"></i> <span>{{ trans('app.user') }}</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/entity') }}"><i class="fa fa-user"></i> <span>{{ trans('app.entity') }}</span></a></li>
          @endif


          @if (Auth::user()->profile == App\Models\User::USER_PROFILE__VENDOR)
              <li class="header">{{ trans('app.vendor') }}</li>
              <li><a href="{{ backpack_url('dashboard') }}"><i class="fas fa-home"></i> <span>{{ trans('app.home') }}</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/sale') }}"><i class="fa fa-image"></i> <span>{{ trans('app.sale') }}</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/client') }}"><i class="fa fa-user"></i> <span>{{ trans('app.client') }}</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/hotel') }}"><i class="fa fa-building"></i> <span>{{ trans('app.hotels') }}</span></a></li>
          @endif


        </ul>
      </section>
    </aside>
@endif
