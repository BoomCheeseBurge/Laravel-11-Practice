<div {{ $attributes->whereStartsWith('wire:ignore') }} x-data="{ alertIsVisible: true }" x-show="alertIsVisible" 
    {{ $attributes->merge(['class' => 'overflow-hidden relative text-neutral-600 bg-white rounded-md border border-red-500 dark:text-neutral-300 dark:bg-neutral-950']) }} 
    role="alert" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
    <div class="bg-red-500/10 w-full flex items-center gap-2 p-4">
        <div class="bg-red-500/15 p-1 text-red-500 rounded-full" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-2">
            <h3 class="text-sm font-semibold text-red-500">{{ $message }}</h3>
        </div>
        <button type="button" @click="alertIsVisible = false" class="ml-auto" aria-label="dismiss alert">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2.5" class="w-4 h-4 shrink-0">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>