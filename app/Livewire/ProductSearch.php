<?php

namespace App\Livewire;

use App\Models\CategoryProduct;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductSearch extends Component
{

    use WithPagination;

    public $search = '';
    public $category_id = '';
    public $initialCategoryId;

    public function mount($initialCategoryId = null)
    {
        if ($initialCategoryId) {
            $this->category_id = $initialCategoryId;
        }
    }
    public function render()
    {
        $query = Product::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
            $query->orWhereHas('categories', function ($q) {
                $q->where('name','like', '%' . $this->search . '%');
            });
        }

        if ($this->category_id) {
            $query->whereHas('categories', function ($q) {
                $q->where('category_product_id', $this->category_id);
            });
        }

        $products = $query->paginate(10);
        $categories = CategoryProduct::all();

        return view('livewire.product-search', compact('products', 'categories'));
    }
}
