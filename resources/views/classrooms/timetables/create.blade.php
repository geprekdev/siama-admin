<x-app-layout>
  <x-slot name="header">
    {{ __('Tambah Jadwal Pelajaran') }}
  </x-slot>

  <x-errors class="mb-4" :errors="$errors" />

  <div class="bg-white min-h-[70vh] overflow-hidden shadow-md sm:rounded-lg">
    <div class="px-12 py-6 border-b border-gray-200">
      <form action="{{ route('classrooms.timetables.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6 mt-4">
          <div>
            <x-label for="date" :value="__('Tanggal')" />
            <x-input type="date" name="date" id="date" required />
          </div>

          <div>
            <x-label for="file" :value="__('File untuk di-import')" />
            <x-input type="file" name="file" id="file" required />
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
