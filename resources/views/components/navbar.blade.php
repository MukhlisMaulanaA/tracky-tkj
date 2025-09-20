<header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20">
  <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">

    <!-- Left side -->
    <div class="flex items-center space-x-4">
      <!-- Mobile hamburger -->
      <button @click="mobileMenuOpen = !mobileMenuOpen"
        class="p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 lg:hidden">
        <x-icon name="menu" class="h-5 w-5" />
      </button>

      <!-- Desktop hamburger -->
      <button @click="collapsed = !collapsed"
        class="p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 hidden lg:block">
        <x-icon name="menu" class="h-5 w-5" />
      </button>

      <!-- Dashboard Title -->
      <h1 class="text-xl font-bold text-gray-900">Dashboard</h1>
    </div>

    <!-- Right side -->
    <div class="flex items-center space-x-4" x-data="{ open: false }">

      <!-- Avatar + Name (Trigger Dropdown) -->
      <button @click="open = !open"
        class="flex items-center space-x-2 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md p-2">
        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
          <x-icon name="user" class="h-4 w-4 text-white" />
        </div>
        <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
        <x-icon name="chevron-down" class="h-4 w-4 text-gray-500" />
      </button>

      <!-- Dropdown Menu -->
      <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute right-4 top-14 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-2 z-30">

        <!-- Profile Settings -->
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
          ⚙️ Profile Settings
        </a>

        <!-- Divider -->
        <div class="border-t border-gray-100 my-1"></div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
            🚪 Logout
          </button>
        </form>
      </div>
    </div>
  </div>
</header>
