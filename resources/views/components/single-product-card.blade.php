<div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <div class="h-56 w-full">
          <a href="{{ route('product', $product->slug) }}">
            <img class="mx-auto h-full dark:hidden" src="{{ $product->media_url }}" alt="" />
            <img class="mx-auto hidden h-full dark:block" src="{{ $product->media_url }}" alt="" />
          </a>
        </div>
        <div class="pt-6">
          <a href="{{ route('product', $product->slug) }}" class="line-clamp-3 text-lg font-semibold leading-tight text-gray-900 hover:underline">{{ $product->name }}</a>

          <div class="mt-4 flex items-center justify-between gap-4">
            <p class="text-sm font-medium leading-tight text-gray-900">{{ $product->price_formated }}</p>

            <a href="{{ route('product', $product->slug) }}" class="inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 cursor-pointer">
              <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
              </svg>
              + Cart
            </a>
          </div>
        </div>
    </div>