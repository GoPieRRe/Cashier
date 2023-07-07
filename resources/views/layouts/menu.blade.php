<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <h1 class="m-2">Cashier</h1>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboard -->
      <li class="menu-item active">
        <a href="@if(auth()->user()->level == 'admin') admin @else cashier @endif" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Pages</span>
      </li> 
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Account Settings">Account</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ route('account.index') }}" class="menu-link">
              <div data-i18n="Account">User</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('costumer.index') }}" class="menu-link">
              <div data-i18n="Notifications">Costumer</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="pages-account-settings-connections.html" class="menu-link">
              <div data-i18n="Connections">Connections</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-food-menu"></i>
          <div data-i18n="Misc">List</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ route('menu.index') }}" class="menu-link">
              <div>Menu</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="pages-misc-under-maintenance.html" class="menu-link">
              <div data-i18n="Under Maintenance">transaction</div>
            </a>
          </li>
        </ul>
      </li>
      {{-- <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-copy"></i>
          <div data-i18n="Extended UI">Extended UI</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="extended-ui-perfect-scrollbar.html" class="menu-link">
              <div data-i18n="Perfect Scrollbar">Perfect scrollbar</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="extended-ui-text-divider.html" class="menu-link">
              <div data-i18n="Text Divider">Text Divider</div>
            </a>
          </li>
        </ul>
      </li> --}}

      <li class="menu-item">
        <a href="{{ route('order.index') }}" class="menu-link">
          <i class="menu-icon fas fa-utensils"></i>
          <div data-i18n="Boxicons">Order</div>
        </a>
      </li>
    </ul>
  </aside>