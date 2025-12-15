<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
  <div class="sidebar-inner px-2 pt-3">

    <ul class="nav flex-column pt-3 pt-md-0">

      <!-- Brand -->
      <li class="nav-item">
        <a href="/dashboard" class="nav-link d-flex align-items-center">
          <span class="sidebar-icon me-3">
            <img src="/assets/img/brand/light.svg" height="20" width="20" alt="Volt Logo">
          </span>
          <span class="mt-1 ms-1 sidebar-text">Volt Laravel</span>
        </a>
      </li>

      <!-- Purchasing Trend (Dashboard) -->
      <li class="nav-item {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
        <a href="/dashboard" class="nav-link">
          <span class="sidebar-icon">
            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
              <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
          </span>
          <span class="sidebar-text">Purchasing Trend</span>
        </a>
      </li>

      <!-- Cost by Category (Transactions) -->
      <li class="nav-item {{ Request::segment(1) == 'transactions' ? 'active' : '' }}">
        <a href="/transactions" class="nav-link">
          <span class="sidebar-icon">
            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
              <path fill-rule="evenodd"
                d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                clip-rule="evenodd"></path>
            </svg>
          </span>
          <span class="sidebar-text">Cost by Category</span>
        </a>
      </li>

      <!-- Sales Trend -->
      <li class="nav-item {{ Request::segment(1) == 'sales-trend' ? 'active' : '' }}">
        <a href="/sales-trend" class="nav-link">
          <span class="sidebar-icon">
            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M3 3h2v14H3V3zm4 6h2v8H7V9zm4-4h2v12h-2V5zm4 8h2v4h-2v-4z"/>
            </svg>
          </span>
          <span class="sidebar-text">Sales Trend</span>
        </a>
      </li>

      <!-- Top Sales Breakdown -->
      <li class="nav-item {{ Request::segment(1) == 'top-sales-breakdown' ? 'active' : '' }}">
        <a href="/top-sales-breakdown" class="nav-link">
          <span class="sidebar-icon">
            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4h12v2H4V4zm0 5h8v2H4V9zm0 5h6v2H4v-2z"/>
            </svg>
          </span>
          <span class="sidebar-text">Top Sales Breakdown</span>
        </a>
      </li>

      <!-- Cost vs Sales -->
      <li class="nav-item {{ Request::segment(1) == 'cost-vs-sales' ? 'active' : '' }}">
        <a href="/cost-vs-sales" class="nav-link">
          <span class="sidebar-icon">
            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M3 17l5-6 4 3 5-8 1 1-6 10-4-3-5 6z"/>
            </svg>
          </span>
          <span class="sidebar-text">Cost vs Sales</span>
        </a>
      </li>

      <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>

    </ul>
  </div>
</nav>
