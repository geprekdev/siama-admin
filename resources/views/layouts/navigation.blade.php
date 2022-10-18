<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
  class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>

<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
  class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
  <div class="flex items-center justify-center mt-8">
    <div class="flex items-center">
      <span class="text-white text-2xl mx-2 font-semibold">Siamawolu Admin</span>
    </div>
  </div>

  <nav class="mt-10" x-data="{ isMultiLevelMenuOpen: false }">
    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
      <x-slot name="icon">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
        </svg>
      </x-slot>
      {{ __('Dashboard') }}
    </x-nav-link>

    @if (auth()->user()->role === 'ADMIN')
      <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
        <x-slot name="icon">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
            </path>
          </svg>
        </x-slot>
        {{ __('Users') }}
      </x-nav-link>
    @endif

    @if (in_array(auth()->user()->role, ['ADMIN', 'KURIKULUM']))
      <x-nav-link href="{{ route('classrooms.subjects.index') }}" :active="request()->routeIs('classrooms.subjects.index')">
        <x-slot name="icon">
          <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
          </svg>
        </x-slot>
        {{ __('Mata Pelajaran') }}
      </x-nav-link>

      <x-nav-link href="{{ route('attendances.timetables.index') }}" :active="request()->routeIs('attendances.timetables.index')">
        <x-slot name="icon">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
          </svg>
        </x-slot>
        {{ __('Jadwal Masuk/Keluar') }}
      </x-nav-link>

      <x-nav-link href="{{ route('classrooms.timetables.index') }}" :active="request()->routeIs('classrooms.timetables.index')">
        <x-slot name="icon">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
          </svg>

        </x-slot>
        {{ __('Jadwal Pelajaran') }}
      </x-nav-link>
    @endif

    <x-nav-link href="#" @click="isMultiLevelMenuOpen = !isMultiLevelMenuOpen">
      <x-slot name="icon">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z">
          </path>
        </svg>
      </x-slot>
      Two-level menu
    </x-nav-link>
    <template x-if="isMultiLevelMenuOpen">
      <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0"
        x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300"
        x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
        class="p-2 mx-4 mt-2 space-y-2 overflow-hidden text-sm font-medium text-white bg-gray-700 bg-opacity-50 rounded-md shadow-inner"
        aria-label="submenu">
        <li class="px-2 py-1 transition-colors duration-150">
          <a class="w-full" href="#">Child menu</a>
        </li>
      </ul>
    </template>
  </nav>
</div>
