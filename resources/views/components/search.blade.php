@props(['route'])

<div class="mb-3 flex justify-center flex-1 shadow">
  <form action="{{ $route }}" class="relative w-full">
    <button type="submit" class="absolute inset-y-0 flex items-center pl-2">
      <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
          clip-rule="evenodd"></path>
      </svg>
    </button>
    <input name="search" value="{{ request()->input('search') ?? '' }}"
      class="w-full pl-8 pr-2 text-sm text-gray-700 border-0 placeholder-gray-600 bg-gray-50 rounded-md focus:bg-white focus:border-gray-300 focus:outline-none form-input"
      type="text" placeholder="Search" aria-label="Search" />
  </form>
</div>
