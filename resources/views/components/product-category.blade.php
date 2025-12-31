@props(['product_kategori' => []])

<section class="bg-white dark:bg-gray-900">
    <div class="container px-6 py-10 mx-auto">
        <h1 class="text-2xl font-semibold text-center text-gray-800 capitalize lg:text-3xl dark:text-white">Product Kategori</h1>

        <p class="max-w-2xl mx-auto my-6 text-center text-gray-500 dark:text-gray-300">
           Temukan produk-produk pilihan dari koleksi terlengkap kami. Mulai dari kebutuhan harian hingga gaya hidup modern, semua tersedia dalam berbagai kategori untuk memudahkan pengalaman belanja Anda.
        </p>

       
        <div class="flex flex-wrap justify-center gap-8 mt-8 xl:mt-16">
           @foreach ($product_kategori as $kategori )
            <div class="flex flex-col items-center p-4 w-40 h-40 transition-colors duration-300 transform border cursor-pointer rounded-xl hover:border-transparent shadow-sm group hover:bg-blue-100 border-gray-300 dark:hover:border-transparent">
                <img class="object-cover w-24 h-24 rounded-full ring-4 ring-gray-300" src="{{ $kategori['img_url'] }}" alt="">

                <h1 class="mt-4 text-lg font-semibold text-gray-700 capitalize dark:text-white group-hover:text-white">{{ $kategori['name'] }}</h1>
            </div>
          @endforeach
        </div>
      
       
    </div>
</section>