<x-app-layout>
    @section('assets')
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css"/>
        <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    @endsection

    <x-slot name="header">
        {{ __('Import User') }}
    </x-slot>

    <x-errors class="mb-4" :errors="$errors"/>

    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="px-12 py-6 border-b border-gray-200">
            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 gap-6 mt-4">
                    <div>
                        <x-label for="role" :value="__('Role')"/>
                        <select name="role" id="role"
                                class="block mt-1 w-full rounded-md form-select focus:border-indigo-600">
                            @foreach (App\Models\User::ROLE_SELECT as $key => $group)
                                <option @selected(old('role') === $key) value="{{ $key }}">{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-label for="file" :value="__('File untuk di-import')"/>
                        <x-input type="file" name="file" id="file" required/>
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
        const roles = document.getElementById('role');
        const rolesChoices = new Choices(roles, {
            removeItemButton: true,
        });
    </script>
</x-app-layout>
