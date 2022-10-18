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
              <p class="text-gray-900 whitespace-no-wrap">
                {{ Carbon\Carbon::parse($timetable->date)->locale('id')->isoFormat('dddd, LL') }}
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
                <a href="{{ route('attendances.timetables.edit', ['timetable' => $timetable->id]) }}"
                  class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Edit">
                  <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                    </path>
                  </svg>
                </a>
                <form onsubmit="return window.confirm('Apakah anda yakin?')"
                  action="{{ route('attendances.timetables.destroy', ['timetable' => $timetable->id]) }}"
                  method="POST">
                  @csrf
                  @method('DELETE')

                  <button type="submit"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="Delete">
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                    </svg>
                  </button>
                </form>
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
