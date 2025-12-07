<div>
    <button wire:loading.attr="disabled" wire:click="remove" type="button" class="cursor-pointer inline-flex w-full items-center justify-center rounded-lg bg-red-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-900 focus:outline-none">
        <svg class="-ms-2 me-2 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
        </svg>
            Remove
        <div wire:loading class="ml-2 animate-spin inline-block size-4 border-3 border-current border-t-transparent text-gray-400 rounded-full" role="status" aria-label="loading">
            <span class="sr-only">Loading...</span>
        </div>
    </button>
</div>
