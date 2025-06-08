<header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20">
  <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">

    <!-- Left side - Hamburger + Title -->
    <div class="flex items-center space-x-4">
      <!-- Mobile hamburger (visible on mobile) -->
      <button @click="mobileMenuOpen = !mobileMenuOpen"
        class="p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 lg:hidden">
        <x-icon name="menu" class="h-5 w-5" />
      </button>

      <!-- Desktop hamburger (visible on desktop) -->
      <button @click="collapsed = !collapsed"
        class="p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 hidden lg:block">
        <x-icon name="menu" class="h-5 w-5" />
      </button>

      <!-- Dashboard Title -->
      <h1 class="text-xl font-bold text-gray-900">Dashboard</h1>
    </div>

    <!-- Right side - User info or additional controls -->
    <div class="flex items-center space-x-4">
      <!-- Notification Bell -->
      {{-- <button class="p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 relative">
        <x-icon name="bell" class="h-5 w-5" />
        <span class="absolute -top-1 -right-1 h-3 w-3 bg-red-500 rounded-full"></span>
      </button> --}}

      <!-- User Avatar -->
      <div class="flex items-center space-x-2">
        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
          <x-icon name="user" class="h-4 w-4 text-white" />
        </div>
        <span class="text-sm font-medium text-gray-700 hidden sm:block">John Doe</span>
      </div>
    </div>
  </div>
</header>
