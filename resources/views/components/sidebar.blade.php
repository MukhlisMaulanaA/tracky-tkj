@php
  $routes = [
      ['name' => 'Dashboard', 'href' => route('index.dashboard'), 'icon' => 'layout-dashboard'],
      [
          'name' => 'Invoice Tracker',
          'href' => route('invoices.index'),
          'icon' => 'file-text',
          'hasSubmenu' => true,
          'submenu' => [
              ['name' => 'Tambah Invoice', 'href' => route('invoices.create'), 'icon' => 'plus'],
              ['name' => 'Daftar Invoice', 'href' => route('invoices.index'), 'icon' => 'list'],
          ],
      ],
      ['name' => 'Salary Tracker', 'href' => route('salaries.index'), 'icon' => 'dollar-sign'],
  ];
@endphp

<!-- Desktop Sidebar -->
<div
  class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:left-0 lg:z-10 lg:bg-white lg:shadow-lg transition-all duration-300"
  :class="collapsed ? 'lg:w-20' : 'lg:w-64'">

  <!-- Logo Section -->
  <div class="flex items-center justify-center h-16 px-4 border-b border-gray-200">
    <div x-show="!collapsed" x-transition:enter="transition ease-in-out duration-300"
      x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95">
      <h1 class="text-xl font-bold text-gray-900">Tracky TKJ</h1>
    </div>
    <div x-show="collapsed" x-transition:enter="transition ease-in-out duration-300"
      x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95">
      <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
        <span class="text-white font-bold text-sm">TR</span>
      </div>
    </div>
  </div>

  <!-- Navigation -->
  <nav class="flex-1 mt-8 space-y-2 px-2" x-data="{ openSubmenu: null }">
    @foreach ($routes as $index => $route)
      <div class="relative">
        @if (isset($route['hasSubmenu']) && $route['hasSubmenu'])
          <!-- Menu with Submenu -->
          <div>
            <!-- Main Menu Item with Dropdown -->
            <button
              @click="collapsed ? window.location.href = '{{ $route['href'] }}' : (openSubmenu = openSubmenu === {{ $index }} ? null : {{ $index }})"
              class="group flex items-center w-full px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 text-left
                {{ str_contains(request()->url(), 'invoices') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}"
              x-tooltip="collapsed ? '{{ $route['name'] }}' : ''">

              <x-icon :name="$route['icon']" class="h-5 w-5 flex-shrink-0" />

              <span class="ml-3 flex-1 text-left transition-all duration-300" x-show="!collapsed"
                x-transition:enter="transition ease-in-out duration-300 delay-100"
                x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in-out duration-200"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-4">
                {{ $route['name'] }}
              </span>

              <!-- Chevron Icon -->
              <x-icon name="chevron-down" class="h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                x-show="!collapsed" class="openSubmenu === {{ $index }} ? 'rotate-180' : ''"
                x-transition:enter="transition ease-in-out duration-300 delay-150"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in-out duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" />
            </button>

            <!-- Submenu Dropdown -->
            <div x-show="!collapsed && openSubmenu === {{ $index }}"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0 transform scale-95"
              x-transition:enter-end="opacity-100 transform scale-100"
              x-transition:leave="transition ease-in duration-150"
              x-transition:leave-start="opacity-100 transform scale-100"
              x-transition:leave-end="opacity-0 transform scale-95"
              class="mt-1 ml-6 space-y-1 bg-gray-50 rounded-lg p-2">
              @foreach ($route['submenu'] as $submenuItem)
                <a href="{{ $submenuItem['href'] }}"
                  class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200
                    {{ request()->url() === $submenuItem['href'] ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-white hover:shadow-sm' }}">
                  <x-icon :name="$submenuItem['icon']" class="h-4 w-4 flex-shrink-0" />
                  <span class="ml-2">{{ $submenuItem['name'] }}</span>
                </a>
              @endforeach
            </div>
          </div>
        @else
          <!-- Regular Menu Item -->
          <a href="{{ $route['href'] }}"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
              {{ request()->url() === $route['href'] ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}"
            x-tooltip="collapsed ? '{{ $route['name'] }}' : ''">

            <x-icon :name="$route['icon']" class="h-5 w-5 flex-shrink-0" />

            <span class="ml-3 transition-all duration-300" x-show="!collapsed"
              x-transition:enter="transition ease-in-out duration-300 delay-100"
              x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
              x-transition:leave="transition ease-in-out duration-200"
              x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-4">
              {{ $route['name'] }}
            </span>
          </a>
        @endif
      </div>
    @endforeach
  </nav>

  <!-- User Profile Section -->
  <div class="border-t border-gray-200 p-4">
    <div
      class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200"
      x-tooltip="collapsed ? 'John Doe - Administrator' : ''">
      <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
        <x-icon name="user" class="h-4 w-4 text-white" />
      </div>

      <div class="flex-1 min-w-0" x-show="!collapsed" x-transition:enter="transition ease-in-out duration-300 delay-100"
        x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-4">
        <p class="text-sm font-medium text-gray-900 truncate">John Doe</p>
        <p class="text-xs text-gray-500 truncate">Administrator</p>
      </div>

      <x-icon name="settings" class="h-4 w-4 text-gray-400 flex-shrink-0" x-show="!collapsed"
        x-transition:enter="transition ease-in-out duration-300 delay-150" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in-out duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" />
    </div>
  </div>
</div>

<!-- Mobile Sidebar -->
<div
  class="lg:hidden fixed inset-y-0 left-0 z-40 bg-white shadow-lg transform transition-transform duration-300 ease-in-out w-64"
  :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'" x-show="true">

  <!-- Mobile Logo Section -->
  <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
    <h1 class="text-xl font-bold text-gray-900">Tracky TKJ</h1>
    <button @click="mobileMenuOpen = false" class="p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100">
      <x-icon name="x" class="h-5 w-5" />
    </button>
  </div>

  <!-- Mobile Navigation -->
  <nav class="mt-8 space-y-2 px-4" x-data="{ mobileOpenSubmenu: null }">
    @foreach ($routes as $index => $route)
      <div class="relative">
        @if (isset($route['hasSubmenu']) && $route['hasSubmenu'])
          <!-- Mobile Menu with Submenu -->
          <div>
            <!-- Main Menu Item -->
            <button
              @click="mobileOpenSubmenu = mobileOpenSubmenu === {{ $index }} ? null : {{ $index }}"
              class="group flex items-center w-full px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 text-left
                {{ str_contains(request()->url(), 'invoices') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
              <x-icon :name="$route['icon']" class="h-5 w-5 flex-shrink-0" />
              <span class="ml-3 flex-1 text-left">{{ $route['name'] }}</span>
              <x-icon name="chevron-down"
                class="h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0" class="mobileOpenSubmenu === {{ $index }} ? 'rotate-180' : ''" />
            </button>

            <!-- Mobile Submenu -->
            <div x-show="mobileOpenSubmenu === {{ $index }}"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0 transform scale-95"
              x-transition:enter-end="opacity-100 transform scale-100"
              x-transition:leave="transition ease-in duration-150"
              x-transition:leave-start="opacity-100 transform scale-100"
              x-transition:leave-end="opacity-0 transform scale-95"
              class="mt-1 ml-6 space-y-1 bg-gray-50 rounded-lg p-2">
              @foreach ($route['submenu'] as $submenuItem)
                <a href="{{ $submenuItem['href'] }}" @click="mobileMenuOpen = false"
                  class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200
                    {{ request()->url() === $submenuItem['href'] ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-white hover:shadow-sm' }}">
                  <x-icon :name="$submenuItem['icon']" class="h-4 w-4 flex-shrink-0" />
                  <span class="ml-2">{{ $submenuItem['name'] }}</span>
                </a>
              @endforeach
            </div>
          </div>
        @else
          <!-- Regular Mobile Menu Item -->
          <a href="{{ $route['href'] }}" @click="mobileMenuOpen = false"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200
              {{ request()->url() === $route['href'] ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
            <x-icon :name="$route['icon']" class="h-5 w-5" />
            <span class="ml-3">{{ $route['name'] }}</span>
          </a>
        @endif
      </div>
    @endforeach
  </nav>

  <!-- Mobile User Profile -->
  <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
    <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
      <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
        <x-icon name="user" class="h-4 w-4 text-white" />
      </div>
      <div class="flex-1">
        <p class="text-sm font-medium text-gray-900">John Doe</p>
        <p class="text-xs text-gray-500">Administrator</p>
      </div>
      <x-icon name="settings" class="h-4 w-4 text-gray-400" />
    </div>
  </div>
</div>
