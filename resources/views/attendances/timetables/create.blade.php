<x-app-layout>
  <x-slot name="header">
    {{ __('Tambah Jadwal Masuk/Keluar') }}
  </x-slot>

  <x-errors class="mb-4" :errors="$errors" />

  <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
    <div class="px-12 py-6 border-b border-gray-200">
      <form action="{{ route('attendances.timetables.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-6 mt-4">
          <div>
            <x-label for="date" :value="__('Tanggal')" />
            <x-input type="date" name="date" id="date" value="{{ old('date') }}" required />
          </div>

          <div>
            <x-label for="work_time" :value="__('Masuk')" />
            <x-input type="time" name="work_time" id="work_time" value="{{ old('work_time') }}" required />
          </div>

          <div>
            <x-label for="home_time" :value="__('Keluar')" />
            <x-input type="time" name="home_time" id="home_time" value="{{ old('home_time') }}" required />
          </div>

          <div>
            <x-label for="role" :value="__('Role')" />
            <select name="role" id="role"
              class="block mt-1 w-full rounded-md form-select focus:border-indigo-600">
              <option value="MRD">Murid</option>
              <option value="GRU">Guru</option>
              <option value="KWN">Karyawan</option>
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
