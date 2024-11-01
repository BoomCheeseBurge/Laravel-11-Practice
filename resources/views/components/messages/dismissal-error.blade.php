<div id="alert-{{ $errorID }}" class="flex items-center px-4 py-2 my-1 text-red-800 bg-red-50 rounded-lg dark:text-red-400 dark:bg-gray-800" role="alert">
    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <span class="sr-only">Info</span>
    <div class="ms-3 text-sm font-medium">
        {{ $message }}
    </div>
    <button type="button" class="-mx-1.5 -my-1.5 ms-auto w-8 h-8 inline-flex justify-center items-center p-1.5 text-red-500 bg-red-50 rounded-lg dark:text-red-400 dark:bg-gray-800 dark:hover:bg-gray-700 focus:ring-2 focus:ring-red-400 hover:bg-red-200" data-dismiss-target="#alert-{{ $errorID }}" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
      </svg>
    </button>
</div>