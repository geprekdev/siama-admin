<x-app-layout>
  @section('assets')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
  @endsection

  <x-slot name="header">
    {{ __('Edit Jadwal Pelajaran') }}
  </x-slot>

  <x-errors class="mb-4" :errors="$errors" />

  <div class="bg-white min-h-[70vh] overflow-hidden shadow-md sm:rounded-lg">
    <div class="px-12 py-6 border-b border-gray-200">
      <form action="{{ route('classrooms.timetables.update', ['timetable' => $timetable->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 mt-4">
          <div>
            <x-label for="date" :value="__('Tanggal')" />
            <x-input type="date" name="date" id="date" value="{{ old('date', $timetable->date) }}"
              required />
          </div>

          <div>
            <x-label for="start_time" :value="__('Mulai')" />
            <x-input type="time" name="start_time" id="start_time"
              value="{{ old('start_time', Carbon\Carbon::parse($timetable->start_time)->format('H:i')) }}" required />
          </div>

          <div>
            <x-label for="end_time" :value="__('Selesai')" />
            <x-input type="time" name="end_time" id="end_time"
              value="{{ old('end_time', Carbon\Carbon::parse($timetable->end_time)->format('H:i')) }}" required />
          </div>

          <div>
            <x-label for="subject_id" :value="__('Kelas')" />
            <select name="subject_id" id="subject_id"
              class="block mt-1 w-full rounded-md form-select focus:border-indigo-600">
              @foreach ($subjects as $subject)
                <option @selected(old('subject_id', $timetable->subject_id) === $subject->id) value="{{ $subject->id }}">
                  {{ "{$subject->name} - {$subject->grade}" }}</option>
              @endforeach
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

  <script>
    const subject = document.getElementById('subject_id');
    const subjectChoices = new Choices(subject, {
      renderChoiceLimit: 3
    });
  </script>
</x-app-layout>
