<x-app-layout>
    @section('assets')
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css"/>
        <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    @endsection

    <x-slot name="header">
        {{ __('Edit User') }}
    </x-slot>

    <x-errors class="mb-4" :errors="$errors"/>

    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="px-12 py-6 border-b border-gray-200">
            <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 mt-4">
                    <div>
                        <x-label for="name" :value="__('Name')"/>
                        <x-input type="text" name="first_name" id="first_name"
                                 value="{{ old('first_name', $user->first_name) }}" required/>
                    </div>

                    <div>
                        <x-label for="username" :value="__('Username')"/>
                        <x-input type="username" name="username" id="username"
                                 value="{{ old('username', $user->username) }}"
                                 required/>
                    </div>

                    <div>
                        <x-label for="groups" :value="__('Role')"/>
                        <select multiple name="groups[]" id="groups"
                                class="block mt-1 w-full rounded-md form-select focus:border-indigo-600">
                            @foreach (App\Models\User::ROLE_SELECT as $key => $group)
                                <option
                                    @selected(in_array($key, $user->groups->pluck('name')->toArray())) value="{{ $key }}">{{ $group }}</option>
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
        const groups = document.getElementById('groups');
        const groupsChoices = new Choices(groups, {
            removeItemButton: true,
        });
    </script>
</x-app-layout>
