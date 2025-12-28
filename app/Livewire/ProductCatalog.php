<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Tag;
use App\Models\Product;
use Livewire\Component;
use App\Data\ProductData;
use Livewire\WithPagination;
use App\Data\ProductCollectionData;
use Illuminate\Database\Eloquent\Builder;

class ProductCatalog extends Component
{
    use WithPagination;

    public $category = '';
    public $queryString = [
        'select_collections'   =>   ['except' => []],
        'search'               =>   ['except' => []],
        'sortBy'               =>   ['except' => 'newest'],
        'category'             =>   ['except' => '']
    ];

    public array $select_collections = [];
    public string $search = '';
    public string $sortBy = 'newest';
    public function render()
    {
        $query = Product::query();

        if ($this->search) {
            $query->where('name', 'LIKE', "%{$this->search}%");
        }

        if ($this->category) {
            $query->whereHas('tags', function (Builder $q) {
                $q->where('slug->en', $this->category);
            });
        }

        if (!empty($this->select_collections)) {
            $query->whereHas('tags', function ($query) {
                $query->whereIn('id', $this->select_collections);
            });
        }

        switch ($this->sortBy) {
            case 'latest':
                $query->oldest();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
            default:
                $query->latest();
                break;
        }

        $collectionQuery = Tag::query()->withType('collection');

        if ($this->category) {
            $collectionQuery->whereHas('products', function ($q) {
                $q->whereHas('tags', function ($t) {
                    $t->where('slug->en', $this->category);
                });
            });
        }

        $collection_result = $collectionQuery->withCount('products')->get();

        $products = ProductData::collect($query->paginate(9));
        $collections = ProductCollectionData::collect($collection_result);

        return view('livewire.product-catalog', compact([
            'products',
            'collections'
        ]));
    }

    public function applyFilter()
    {
        $this->resetPage();
    }

    public function resetButton()
    {
        $this->reset(['select_collections', 'sortBy', 'search']);
    }
}
