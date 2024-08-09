<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\CategoryProduct;
use App\Models\Vendor;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assuming you have some categories already created
        $categories = CategoryProduct::all();

        // Define product data
        $offers = [
            [
                'name' => 'Product 1',
                'description' => 'Description for product 1',
                'stock' => 10,
                'price' => 100.00,
                'owner_type'=> get_class(Admin::first()),
                'owner_id' => 1,
                'discount_percentage' => 10,
                'fixed_discount' => null,
                'price_after_discount' => 90.00,
                'img' => "images/1.png",
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description for product 2',
                'stock' => 20,
                'price' => 200.00,
                'discount_percentage' => null,
                'fixed_discount' => 20.00,
                'price_after_discount' => 180.00,
                'img' => "images/2.png",
                'owner_type'=> get_class(Admin::first()),
                'owner_id' => 1,
            ],
            // Add more offers as needed
        ];

        // Create offers and associate categories
        foreach ($offers as $productData) {
            $product = Product::create($productData);

            // Attach random categories to each product
            $product->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            // Create and attach attributes
            $this->createAttributesForProduct($product);
        }

        for ($i = 1; $i < 11; $i++) {
            $product = Product::create([
                'name' => "Product $i",
                "description" => "Description for product $i",
                "stock" => 20,
                "price" => 200.00,
                "discount_percentage" => null,
                "fixed_discount" => null,
                "price_after_discount" => 0,
                "img" => "images/$i.png",
                "owner_type"=> get_class(Admin::first()),
                "owner_id" => 1,
            ]);
            $product->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            // Create and attach attributes
            $this->createAttributesForProduct($product);
        }
    }

    private function createAttributesForProduct($product)
    {
        $attributes = [
            'Color' => ['#9c1c1c', '#1d5991', '#000000'],
            'Size' => ['S', 'M', 'L', 'XL']
        ];

        foreach ($attributes as $name => $values) {
            $attribute = Attribute::create([
                'name' => $name,
                'product_id' => $product->id,
            ]);

            foreach ($values as $value) {
                ProductAttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value' => $value,
                    'price' => rand(0, 5), // Random price for attribute value
                    'color' => $name == 'Color' ? strtolower($value) : null, // Set color for color attributes
                ]);
            }
        }
    }
}
