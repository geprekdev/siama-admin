<x-app-layout>
  <x-slot name="header">
    {{ __('Perizinan Full Day') }}
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

  <form action="{{ route('attendances.leaves.full-days.index') }}"
    class="relative mb-3 flex flex-wrap flex-col lg:flex-row gap-2 justify-end flex-1">
    <input type="text" name="search" value="{{ request()->input('search') }}" placeholder="Cari"
      class="text-sm text-gray-700 border-0 placeholder-gray-600 bg-gray-50 rounded-md shadow focus:bg-white focus:border-gray-300 focus:outline-none form-input">

    <select name="approve" id="approve"
      class="text-sm text-gray-700 border-0 placeholder-gray-600 bg-gray-50 rounded-md shadow focus:bg-white focus:border-gray-300 focus:outline-none form-select">
      <option @selected(empty(request()->input('approve'))) value="">Pilih Status</option>
      <option @selected(request()->input('approve') === 'diterima') value="diterima">Ditolak</option>
      <option @selected(request()->input('approve') === 'ditolak') value="ditolak">Diterima</option>
      <option @selected(request()->input('approve') === 'menunggu') value="menunggu">Menunggu Konfirmasi</option>
    </select>

    <select name="category" id="category"
      class="text-sm text-gray-700 border-0 placeholder-gray-600 bg-gray-50 rounded-md shadow focus:bg-white focus:border-gray-300 focus:outline-none form-select">
      <option @selected(empty(request()->input('category'))) value="">Pilih Kategori</option>
      <option @selected(request()->input('category') === 'izin') value="izin">Izin</option>
      <option @selected(request()->input('category') === 'sakit') value="sakit">Sakit</option>
      <option @selected(request()->input('category') === 'sekolah') value="sekolah">Keperluan Sekolah</option>
    </select>

    <input type="date" name="date" value="{{ request()->input('date') }}"
      class="text-sm text-gray-700 border-0 placeholder-gray-600 bg-gray-50 rounded-md shadow focus:bg-white focus:border-gray-300 focus:outline-none form-input">

    <button type="submit"
      class="py-2 px-4 text-center bg-yellow-500 rounded-md text-white text-sm hover:bg-yellow-400">Filter</button>
  </form>

  <div class="inline-block overflow-scroll min-w-full max-w-full rounded-lg shadow">
    <table class="min-w-full leading-normal">
      <thead>
        <tr>
          <th
            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
            Nama
          </th>
          <th
            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
            Status
          </th>
          <th
            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
            Kategori
          </th>
          <th
            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
            Tanggal
          </th>
          <th
            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
            Action
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($leaves as $leave)
          <tr>
            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
              <p class="text-gray-900 whitespace-no-wrap">
                {{ $leave->name }}
              </p>
            </td>
            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
              @if ($leave->approve === 0)
                <x-badge color="red">Ditolak</x-badge>
              @elseif ($leave->approve === 1)
                <x-badge color="green">Diterima</x-badge>
              @else
                <x-badge color="yellow">Menunggu Dikonfirmasi</x-badge>
              @endif
            </td>
            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
              @switch($leave->leave_type)
                @case(0)
                  <x-badge color="indigo">Izin</x-badge>
                @break

                @case(1)
                  <x-badge color="blue">Sakit</x-badge>
                @break

                @case(2)
                  <x-badge color="gray">Keperluan Sekolah</x-badge>
                @break
              @endswitch
            </td>
            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
              {{ Carbon\Carbon::parse($leave->created_at)->locale('id')->isoFormat('LL') }}
            </td>
            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
              <a href="{{ route('attendances.leaves.full-days.edit', ['full_day' => $leave->id]) }}"
                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                aria-label="Edit">
                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                  </path>
                </svg>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="flex flex-col xs:flex-row justify-between px-5 py-5 bg-white border-t">
      {{ $leaves->appends([
              'search' => request()->input('search'),
              'approve' => request()->input('approve'),
              'category' => request()->input('category'),
              'date' => request()->input('date'),
          ])->links() }}
    </div>
  </div>
</x-app-layout>
