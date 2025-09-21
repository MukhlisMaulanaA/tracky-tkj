<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}">
  <title>Dashboard</title>
  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
  
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
  
  <script src="https://unpkg.com/lucide@latest"></script>
  
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body x-data="{
    collapsed: false,
    mobileMenuOpen: false,
    // Auto collapse on mobile
    init() {
        this.collapsed = window.innerWidth < 1024;
        window.addEventListener('resize', () => {
            if (window.innerWidth < 1024) {
                this.collapsed = true;
                this.mobileMenuOpen = false;
            }
        });
    }
}" class="h-screen flex bg-gray-50">

  <!-- Mobile Backdrop -->
  <div x-show="mobileMenuOpen && window.innerWidth < 1024"
    x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="mobileMenuOpen = false"
    class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden">
  </div>

  <!-- Sidebar -->
  <x-sidebar />
  @stack('scripts')

  <!-- Main Content -->
  <div class="flex-1 flex flex-col min-w-0 lg:ml-0"
    :class="{ 'lg:ml-20': collapsed && window.innerWidth >= 1024, 'lg:ml-64': !collapsed && window.innerWidth >= 1024 }">

    <!-- Navbar -->
    <x-navbar />

    <!-- Page Content -->
    <main class="flex-1 overflow-y-auto bg-gray-50">
      <div class="p-4 sm:p-6 lg:p-8">
        @yield('content')
      </div>
    </main>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>



</body>

</html>
