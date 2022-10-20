<x-app-layout>
  <x-slot name="header">
    {{ __('Approve Perizinan Full Day') }}
  </x-slot>

  <x-errors class="mb-4" :errors="$errors" />

  <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
    <div class="px-12 py-6 border-b border-gray-200">
      <div class="grid grid-cols-1 gap-6 mt-4">
        <div>
          <x-label for="name" :value="__('Nama')" />
          <x-input disabled type="text" name="name" id="name" value="{{ $leave->name }}" />
        </div>

        <div>
          <x-label for="leave_type" :value="__('Kategori')" />
          @switch($leave->leave_type)
            @case(0)
              @php
                $leave_type = 'IZIN';
              @endphp
            @break

            @case(1)
              @php
                $leave_type = 'SAKIT';
              @endphp
            @break

            @case(2)
              @php
                $leave_type = 'KEPERLUAN SEKOLAH';
              @endphp
            @break
          @endswitch
          <x-input disabled type="text" name="leave_type" id="leave_type" value="{{ $leave_type }}" />
        </div>

        <div>
          <x-label for="reason" :value="__('Alasan')" />
          <textarea disabled name="reason" id="reason" cols="30" rows="10"
            class="block mt-1 w-full rounded-md form-input focus:border-indigo-600">{{ $leave->reason }}</textarea>
        </div>

        <div>
          <x-label for="attachment" :value="__('Dokumen')" />
          <img class="mx-auto object-cover rounded" width="300"
            src="https://api.erpeelisme.my.id/m/{{ $leave->attachment }}">
        </div>

        <div>
          <x-label for="created_at" :value="__('Waktu')" />
          <x-input disabled type="text" name="created_at" id="created_at"
            value="{{ Carbon\Carbon::parse($leave->created_at)->locale('id')->isoFormat('LLLL') }}" />
        </div>
      </div>

      <div class="flex justify-center gap-6 mt-6">
        @if (is_null($leave->approve))
          <form onsubmit="return window.confirm('Apakah anda yakin?')"
            action="{{ route('attendances.leaves.full-days.update', ['full_day' => $leave->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="approve" value="1">

            <button type="submit"
              class="py-2 px-4 text-center bg-green-600 rounded-md text-white text-sm hover:bg-green-500">
              Terima
            </button>
          </form>

          <form onsubmit="return window.confirm('Apakah anda yakin?')"
            action="{{ route('attendances.leaves.full-days.update', ['full_day' => $leave->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="approve" value="0">

            <button type="submit"
              class="py-2 px-4 text-center bg-red-600 rounded-md text-white text-sm hover:bg-red-500">
              Tolak
            </button>
          </form>
        @else
          <form onsubmit="return window.confirm('Apakah anda yakin?')"
            action="{{ route('attendances.leaves.full-days.destroy', ['full_day' => $leave->id]) }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit"
              class="py-2 px-4 text-center bg-red-600 rounded-md text-white text-sm hover:bg-red-500">
              Batalkan Approve
            </button>
          </form>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
