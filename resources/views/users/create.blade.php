<x-app-layout>
  <x-slot name="header">
    {{ __('Create User') }}
  </x-slot>

  <x-errors class="mb-4" :errors="$errors" />

  <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
    <div class="px-12 py-6 border-b border-gray-200">
      <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-6 mt-4">
          <div>
            <x-label for="name" :value="__('Name')" />
            <x-input type="text" name="name" id="name" value="{{ old('name') }}" required />
          </div>

          <div>
            <x-label for="username" :value="__('Username')" />
            <x-input type="text" name="username" id="username" value="{{ old('username') }}" required />
          </div>

          <div>
            <x-label for="role" :value="__('Role')" />
            <select name="role" id="role"
              class="block mt-1 w-full rounded-md form-select focus:border-indigo-600">
              <option value="KURIKULUM">Kurikulum</option>
              <option value="KARYAWAN">Karyawan</option>
            </select>
          </div>
        </div>

        <div class="flex justify-end mt-6">
          <x-button>
            {{ __('Submit') }}
          </x-button>
        </div>

      </form>

    </div>
  </div>
</x-app-layout>
