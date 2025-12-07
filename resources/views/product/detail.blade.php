<x-layouts.app>
<div class="bg-white text-gray-900 min-h-screen flex items-center justify-center p-8">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl w-full items-start">
    <!-- Product Images -->
    <div class="flex flex-col md:flex-row gap-4">
      <div class="flex md:flex-col gap-2">
        @foreach ( $product->gallery as $image )
        <img src="{{ $image }}"
             class="w-20 h-20 object-cover rounded-lg border border-gray-700 cursor-pointer" />
         @endforeach
      </div>
      <div class="flex-1">
        <img src="{{ $product->media_url }}"
             class="w-full h-112 object-cover rounded-xl border border-gray-700" />

             <nav class="relative z-0 flex border border-gray-200 rounded-xl overflow-hidden dark:border-neutral-700" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
  <button type="button" class="hs-tab-active:border-b-blue-600 hs-tab-active:text-gray-900 dark:hs-tab-active:text-white relative dark:hs-tab-active:border-b-blue-600 min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 border-gray-200 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-l-neutral-700 dark:border-b-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-400 active" id="bar-with-underline-item-1" aria-selected="true" data-hs-tab="#bar-with-underline-1" aria-controls="bar-with-underline-1" role="tab">
    Deskripsi
  </button>
  <button type="button" class="hs-tab-active:border-b-blue-600 hs-tab-active:text-gray-900 dark:hs-tab-active:text-white relative dark:hs-tab-active:border-b-blue-600 min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 border-gray-200 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-l-neutral-700 dark:border-b-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-400" id="bar-with-underline-item-2" aria-selected="false" data-hs-tab="#bar-with-underline-2" aria-controls="bar-with-underline-2" role="tab">
    Info Penting
  </button>
</nav>

<div class="mt-3">
  <div id="bar-with-underline-1" role="tabpanel" aria-labelledby="bar-with-underline-item-1">
    <div class="text-gray-500 dark:text-neutral-400 prose dark:prose-invert max-w-none">
      {!! nl2br(e($product->deskripsi)) !!}
    </div>
  </div>
  <div id="bar-with-underline-2" class="hidden" role="tabpanel" aria-labelledby="bar-with-underline-item-2">
    <p class="text-gray-500 dark:text-neutral-400">
     
    </p>
  </div>
</div>
      </div>
    </div>
    

    <!-- Product Info -->
    <div class="space-y-6 rounded-lg border border-gray-300 bg-gray-100 p-6 shadow-sm">
      <h2 class="text-lg font-semibold leading-tight text-gray-900 hover:underline">
        {{ $product->name }}
      </h2>
      
      <div class="flex items-center gap-2">
        <span class="bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded">
          the last 2 products
        </span>
        <div class="flex items-center text-yellow-400">
          ★★★★★
        </div>
        <a href="#" class="text-sm underline hover:text-blue-400">345 Reviews</a>
      </div>

      <div class="flex justify-between">
        <p class="text-2xl font-semibold leading-tight text-gray-900">{{ $product->price_formated }}</p>
      </div>

      <!-- Buttons -->
       <livewire:add-to-cart :product="$product"/>

      <!-- Variants -->
      <div class="space-y-4">
        <div>
          
<h4 class="font-semibold mb-2">Color</h4>
<ul class="w-full flex-wrap gap-3 flex">
    <li>
        <input type="radio" id="hs-horizontal-list-group-item-radio-1" name="hs-horizontal-list-group-item-radio" class="hidden peer" required />
        <label for="hs-horizontal-list-group-item-radio-1" class="inline-flex items-center justify-between w-full py-1 px-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                <span class="">Blue</span>
        </label>
    </li>
    <li>
        <input type="radio" id="hs-horizontal-list-group-item-radio-2" name="hs-horizontal-list-group-item-radio" class="hidden peer" required />
        <label for="hs-horizontal-list-group-item-radio-2" class="inline-flex items-center justify-between w-full py-1 px-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                <span class="">White</span>
        </label>
    </li>
    <li>
        <input type="radio" id="hs-horizontal-list-group-item-radio-3" name="hs-horizontal-list-group-item-radio" class="hidden peer" required />
        <label for="hs-horizontal-list-group-item-radio-3" class="inline-flex items-center justify-between w-full py-1 px-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                <span class="">Black</span>
        </label>
    </li>
</ul>
        </div>
      </div>
    </div>
  </div>
</div>

</x-layouts.app>
