<x-app-layout>
    @section('assets')
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css"/>
        <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    @endsection

    <x-slot name="header">
        {{ __('Tambah Kelas') }}
    </x-slot>

    <x-errors class="mb-4" :errors="$errors"/>

    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="px-12 py-6 border-b border-gray-200">
            <form action="{{ route('classrooms.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-6 mt-4">
                    <div>
                        <x-label for="grade" :value="__('Nama')"/>
                        <x-input type="text" name="grade" id="grade" value="{{ old('grade') }}" required/>
                    </div>

                    <div>
                        <x-label for="homeroom_teacher_id" :value="__('Wali Kelas')"/>
                        <select name="homeroom_teacher_id" id="homeroom_teacher_id"
                                class="block mt-1 w-full rounded-md form-select focus:border-indigo-600">
                            <option></option>
                            @foreach ($teachers as $teacher)
                                <option
                                    @selected(old('homeroom_teacher_id') === $teacher->id) value="{{ $teacher->id }}">{{ $teacher->first_name }}</option>
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
        const homeroomTeacher = document.getElementById('homeroom_teacher_id');
        const homeroomTeacherChoices = new Choices(homeroomTeacher, {
            renderChoiceLimit: 3
        });
    </script>
</x-app-layout>
