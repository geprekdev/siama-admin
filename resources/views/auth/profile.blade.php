<x-app-layout>
  <x-slot name="header">
    {{ __('My profile') }}
  </x-slot>

  @if ($message = Session::get('success'))
    <div class="inline-flex w-full mb-4 overflow-hidden bg-white rounded-lg shadow-md">
      <div class="flex items-center justify-center w-12 bg-green-500">
        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z">
          </path>
        </svg>
      </div>

      <div class="px-4 py-2 -mx-3">
        <div class="mx-3">
          <span class="font-semibold text-green-500">Success</span>
          <p class="text-sm text-gray-600">{{ $message }}</p>
        </div>
      </div>
    </div>
  @endif

  <x-errors class="mb-4" :errors="$errors" />

  <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
    <div class="p-6 border-b border-gray-200">

      <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
          <div>
            <x-label for="name" :value="__('Name')" />
            <x-input type="text" name="name" id="name" value="{{ old('name', auth()->user()->first_name) }}"
              required />
          </div>

          <div>
            <x-label for="username" :value="__('Username')" />
            <x-input type="username" name="username" id="username"
              value="{{ old('username', auth()->user()->username) }}" required />
          </div>

          <div>
            <x-label for="password" :value="__('Password')" />
            <x-input type="password" name="password" id="password" />
          </div>

          <div>
            <x-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-input type="password" name="password_confirmation" id="password_confirmation" />
          </div>
        </div>

        <div class="flex justify-end mt-4">
          <x-button>
            {{ __('Submit') }}
          </x-button>
        </div>

      </form>

    </div>
  </div>
</x-app-layout>
