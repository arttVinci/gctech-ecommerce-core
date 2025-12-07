<div>
    <div class="container mx-auto max-w-[85rem] w-full">
        <x-feature-section />
        <x-product-category :product_kategori="$product_kategori"/>
        <div class="mt-10">
            <x-product-sections :products="$feature_products" title="Feature Product" :url="route('product-catalog')" />
            <x-featured-icon />
            <x-product-sections :products="$latest_products" title="Latest Products" :url="route('product-catalog')" />
        </div>
    </div>
</div>
