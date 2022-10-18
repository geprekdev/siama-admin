<x-app-layout>
  @section('assets')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
  @endsection

  <x-slot name="header">
    {{ __('Tambah Mata Pelajaran') }}
  </x-slot>

  <x-errors class="mb-4" :errors="$errors" />

  <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
    <div class="px-12 py-6 border-b border-gray-200">
      <form action="{{ route('classrooms.subjects.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-6 mt-4">
          <div>
            <x-label for="name" :value="__('Nama')" />
            <x-input type="text" name="name" id="name" value="{{ old('name') }}" required />
          </div>

          <div>
            <x-label for="classroom_id" :value="__('Kelas')" />
            <select name="classroom_id" id="classroom_id"
              class="block mt-1 w-full rounded-md form-select focus:border-indigo-600">
              @foreach ($classrooms as $classroom)
                <option @selected(old('classroom_id') === $classroom->id) value="{{ $classroom->id }}">{{ $classroom->grade }}</option>
              @endforeach
            </select>
          </div>

          <div>
            <x-label for="teacher_id" :value="__('Guru')" />
            <select name="teacher_id" id="teacher_id"
              class="block mt-1 w-full rounded-md form-select focus:border-indigo-600">
              @foreach ($teachers as $teacher)
                <option @selected(old('teacher_id') === $teacher->id) value="{{ $teacher->id }}">{{ $teacher->name }}</option>
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
    const classroom = document.getElementById('classroom_id');
    const classroomChoices = new Choices(classroom, {
      renderChoiceLimit: 3
    });

    const teacher = document.getElementById('teacher_id');
    const teacherChoices = new Choices(teacher, {
      renderChoiceLimit: 3
    });
  </script>
</x-app-layout>
