<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi Tabungan</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --primary-color: #667eea;
      --sidebar-bg: #1e293b;
      --sidebar-hover: #334155;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      overflow-x: hidden;
      background-color: #f8fafc;
    }

    .sidebar {
      width: 260px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background: var(--sidebar-bg);
      color: #fff;
      padding: 1.5rem 1rem;
      transition: transform 0.3s ease;
      z-index: 1040;
      box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
    }

    .sidebar a {
      color: #fff;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .sidebar a.active,
    .sidebar a:hover {
      background: var(--primary-gradient);
      border-radius: 10px;
      transform: translateX(5px);
    }

    .sidebar .nav-link {
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      border-radius: 10px;
      transition: all 0.3s ease;
    }

    .sidebar .nav-link i {
      margin-right: 0.75rem;
      font-size: 1.2rem;
      width: 24px;
      text-align: center;
    }

    .sidebar.hidden {
      transform: translateX(-100%);
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.5rem;
      margin-bottom: 1.5rem;
    }

    .brand-icon {
      width: 40px;
      height: 40px;
      background: var(--primary-gradient);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
    }

    .brand-text {
      font-weight: 700;
      font-size: 1.25rem;
    }

    .main-content {
      margin-left: 260px;
      padding: 2rem;
      transition: margin-left 0.3s ease;
      min-height: 100vh;
    }

    .toggle-btn {
      background: var(--primary-gradient);
      border: none;
      color: #fff;
      font-size: 1.25rem;
      border-radius: 10px;
      padding: 10px 14px;
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 1100;
      display: none;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .toggle-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .toggle-btn:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
    }

    .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1039;
      display: none;
    }

    .sidebar-overlay.show {
      display: block;
    }

    .profile-section {
      margin-top: auto;
      padding-top: 1.5rem;
      border-top: 1px solid #374151;
    }

    .profile {
      display: flex;
      align-items: center;
      padding: 0.75rem;
      border-radius: 10px;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .profile:hover {
      background-color: var(--sidebar-hover);
    }

    .profile-img {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 0.75rem;
      border: 2px solid var(--primary-color);
    }

    .profile-info {
      flex: 1;
    }

    .profile-name {
      font-weight: 600;
      font-size: 0.95rem;
      margin-bottom: 0.1rem;
    }

    .profile-role {
      font-size: 0.8rem;
      color: #94a3b8;
    }

    .dropdown-menu {
      background: var(--sidebar-bg);
      border: 1px solid #374151;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      border-radius: 10px;
      margin-top: 0.5rem !important;
    }

    .dropdown-item {
      color: #fff;
      padding: 0.6rem 1rem;
      transition: all 0.3s ease;
      border-radius: 5px;
      margin: 0.1rem 0.5rem;
      width: auto;
    }

    .dropdown-item:hover {
      background: var(--primary-gradient);
      color: #fff;
    }

    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
        padding: 1.5rem;
      }

      .toggle-btn {
        display: inline-block;
      }
    }

    .sidebar::-webkit-scrollbar {
      width: 4px;
    }

    .sidebar::-webkit-scrollbar-track {
      background: #374151;
    }

    .sidebar::-webkit-scrollbar-thumb {
      background: var(--primary-gradient);
      border-radius: 10px;
    }

    .sidebar hr {
      border-color: #374151;
      margin: 1rem 0;
    }

    .dropdown-toggle::after {
      display: none !important;
    }
  </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<button class="toggle-btn" id="toggleSidebar">
  <i class="bi bi-list"></i>
</button>

<div class="sidebar d-flex flex-column" id="sidebar">
  <div class="brand">
    <div class="brand-icon">
      <i class="bi bi-wallet2"></i>
    </div>
    <span class="brand-text">TabunganKu</span>
  </div>
  
  <hr>
  
  <ul class="nav flex-column mb-auto">
    <li class="nav-item">
      <a href="/home" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a href="/tabungan" class="nav-link {{ request()->is('tabungan*') ? 'active' : '' }}">
        <i class="bi bi-bullseye"></i> Tujuan Tabungan
      </a>
    </li>
  </ul>

  <div class="profile-section">
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle profile" 
         id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://ui-avatars.com/api/?name=User&background=667eea&color=fff" alt="User" class="profile-img">
        <div class="profile-info">
          <div class="profile-name">{{ Auth::user()->name }}</div>
        </div>
        <i class="bi bi-chevron-down ms-2"></i>
      </a>
      
      <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownUser">
          <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
            @csrf
            <button type="submit" class="dropdown-item text-danger bg-transparent border-0 w-100 text-start">
              <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="main-content" id="mainContent">
  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    function toggleSidebar() {
      sidebar.classList.toggle('show');
      overlay.classList.toggle('show');
      
      // Update toggle button icon
      const icon = toggleBtn.querySelector('i');
      if (sidebar.classList.contains('show')) {
        icon.className = 'bi bi-x';
        document.body.style.overflow = 'hidden';
      } else {
        icon.className = 'bi bi-list';
        document.body.style.overflow = '';
      }
    }

    toggleBtn.addEventListener('click', toggleSidebar);

    overlay.addEventListener('click', toggleSidebar);

    sidebar.addEventListener('click', function(e) {
      if (e.target.tagName === 'A' && window.innerWidth <= 992) {
        if (!e.target.classList.contains('dropdown-toggle')) {
          toggleSidebar();
        }
      }
    });

    window.addEventListener('resize', function() {
      if (window.innerWidth > 992) {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
        toggleBtn.querySelector('i').className = 'bi bi-list';
      }
    });

    const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
    const dropdownList = [...dropdownElementList].map(dropdownToggleEl => 
      new bootstrap.Dropdown(dropdownToggleEl)
    );

    document.querySelectorAll('.dropdown-menu').forEach(menu => {
      menu.addEventListener('click', function(e) {
        e.stopPropagation();
      });
    });
  });
</script>

</body>
</html>