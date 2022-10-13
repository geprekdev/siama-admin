<x-app-layout>
  <x-slot name="header">
    {{ __('Jadwal Masuk/Keluar') }}
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

  <div class="flex justify-end">
    <a href="{{ route('attendances.timetables.create') }}"
      class="mb-4 py-2 px-4 text-center bg-indigo-600 rounded-md text-white text-sm hover:bg-indigo-500">Tambah</a>
  </div>

  <div class="mb-3 flex justify-end flex-1">
    <form action="{{ route('attendances.timetables.index') }}" class="relative">
      <input type="date" name="date" value="{{ request()->input('date') }}"
        class="text-sm text-gray-700 border-0 placeholder-gray-600 bg-gray-50 rounded-md shadow focus:bg-white focus:border-gray-300 focus:outline-none form-input">

      <button type="submit"
        class="py-2 px-4 text-center bg-yellow-500 rounded-md text-white text-sm hover:bg-yellow-400">Filter</button>
    </form>
  </div>

  <div class="inline-block overflow-hidden min-w-full rounded-lg shadow">
    <table class="min-w-full leading-normal">
      <thead>
        <tr>
          <th
            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
            Tanggal
          </th>
          <th
            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
            Masuk
          </th>
          <th
            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
            Keluar
          </th>
          <th
            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
            Role
          </th>
          <th
            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
            Action
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($timetables as $timetable)
          <tr>
            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
              <p class="text-gray-900 whitespace-no-wrap">{{ Carbon\Carbon::parse($timetable->date)->format('d M Y') }}
              </p>
            </td>
            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
              <p class="text-gray-900 whitespace-no-wrap">
                {{ Carbon\Carbon::parse($timetable->work_time)->format('H:i:s') }}</p>
            </td>
            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
              <p class="text-gray-900 whitespace-no-wrap">
                {{ Carbon\Carbon::parse($timetable->home_time)->format('H:i:s') }}</p>
            </td>
            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
              @switch($timetable->role)
                @case('MRD')
                  <x-badge color="yellow">Murid</x-badge>
                @break

                @case('GRU')
                  <x-badge color="indigo">Guru</x-badge>
                @break

                @case('KWN')
                  <x-badge color="green">Karyawan</x-badge>
                @break

                @default
                  <x-badge color="gray">Undefined</x-badge>
                @break
              @endswitch
            </td>
            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
              <div class="flex flex-wrap">

              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="flex flex-col xs:flex-row justify-between px-5 py-5 bg-white border-t">
      {{ $timetables->links() }}
    </div>
  </div>
</x-app-layout>
