    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="{{ route('dashboard')}}">Vali</a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="{{ route('dashboard')}}" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
          <!--Notification Menu-->
          <li class="dropdown"><a class="app-nav__item" href="{{ route('dashboard')}}" data-bs-toggle="dropdown" aria-label="Show notifications"><i class="bi bi-bell fs-5"></i></a>
            <ul class="app-notification dropdown-menu dropdown-menu-right">
              <li class="app-notification__title">You have 4 new notifications.</li>
              <div class="app-notification__content">
                <li><a class="app-notification__item" href="{{ asset('assets_backend/javascript:;')}}"><span class="app-notification__icon"><i class="bi bi-envelope fs-4 text-primary"></i></span>
                    <div>
                      <p class="app-notification__message">Lisa sent you a mail</p>
                      <p class="app-notification__meta">2 min ago</p>
                    </div></a></li>
                <li><a class="app-notification__item" href="{{ asset('assets_backend/javascript:;')}}"><span class="app-notification__icon"><i class="bi bi-exclamation-triangle fs-4 text-warning"></i></span>
                    <div>
                      <p class="app-notification__message">Mail server not working</p>
                      <p class="app-notification__meta">5 min ago</p>
                    </div></a></li>
                <li><a class="app-notification__item" href="{{ asset('assets_backend/javascript:;')}}"><span class="app-notification__icon"><i class="bi bi-cash fs-4 text-success"></i></span>
                    <div>
                      <p class="app-notification__message">Transaction complete</p>
                      <p class="app-notification__meta">2 days ago</p>
                    </div></a></li>
                <li><a class="app-notification__item" href="{{ asset('assets_backend/javascript:;')}}"><span class="app-notification__icon"><i class="bi bi-envelope fs-4 text-primary"></i></span>
                    <div>
                      <p class="app-notification__message">Lisa sent you a mail</p>
                      <p class="app-notification__meta">2 min ago</p>
                    </div></a></li>
                <li><a class="app-notification__item" href="{{ asset('assets_backend/javascript:;')}}"><span class="app-notification__icon"><i class="bi bi-exclamation-triangle fs-4 text-warning"></i></span>
                    <div>
                      <p class="app-notification__message">Mail server not working</p>
                      <p class="app-notification__meta">5 min ago</p>
                    </div></a></li>
                <li><a class="app-notification__item" href="{{ asset('assets_backend/javascript:;')}}"><span class="app-notification__icon"><i class="bi bi-cash fs-4 text-success"></i></span>
                    <div>
                      <p class="app-notification__message">Transaction complete</p>
                      <p class="app-notification__meta">2 days ago</p>
                    </div></a></li>
              </div>
              <li class="app-notification__footer"><a href="{{ route('dashboard')}}">See all notifications.</a></li>
            </ul>
          </li>
          <!-- User Menu-->
          <li class="dropdown"><a class="app-nav__item" href="{{ route('dashboard')}}" data-bs-toggle="dropdown" aria-label="Open Profile Menu"><i class="bi bi-person fs-4"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
              <li><a class="dropdown-item" href="{{ asset('assets_backend/page-user.html')}}"><i class="bi bi-gear me-2 fs-5"></i> Settings</a></li>
              <li><a class="dropdown-item" href="{{ asset('assets_backend/page-user.html')}}"><i class="bi bi-person me-2 fs-5"></i> Profile</a></li>
              {{-- <li><a class="dropdown-item" href="{{ asset('assets_backend/page-login.html')}}"><i class="bi bi-box-arrow-right me-2 fs-5"></i> Logout</a></li> --}}
              <li>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2 fs-5"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            </ul>
          </li>
        </ul>
      </header>
