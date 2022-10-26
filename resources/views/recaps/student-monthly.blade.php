<x-app-layout>
  <x-slot name="header">
    {{ __('Rekap Presensi Bulanan Siswa') }}
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
          <p class="text-sm text-gray-600">{!! $message !!}</p>
        </div>
      </div>
    </div>
  @endif

  <form action="{{ route('recaps.students.monthly.export') }}"
    class="relative h-[50vh] mb-3 flex flex-wrap flex-col lg:flex-row gap-6 justify-center items-center flex-1">
    <select name="classroom_id" id="classroom_id"
      class="py-4 px-6 text-sm text-gray-700 border-0 placeholder-gray-600 bg-gray-50 rounded-md shadow focus:bg-white focus:border-gray-300 focus:outline-none form-select">
      @foreach ($classrooms as $classroom)
        <option @selected(request()->input('classroom_id') === $classroom->id) value="{{ $classroom->id }}">{{ $classroom->grade }}</option>
      @endforeach
    </select>

    <select name="month" id="month"
      class="py-4 px-6 text-sm text-gray-700 border-0 placeholder-gray-600 bg-gray-50 rounded-md shadow focus:bg-white focus:border-gray-300 focus:outline-none form-select">
      @foreach ($months as $key => $month)
        <option @selected(request()->input('month') === $key) value="{{ $key }}">{{ $month }}</option>
      @endforeach
    </select>

    <button type="submit"
      class="py-4 px-6 text-center bg-indigo-500 rounded-md text-white text-sm hover:bg-indigo-400">Export</button>
  </form>
</x-app-layout>
