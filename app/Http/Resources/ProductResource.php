<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = json_decode($this->images,true);
        // Ensure authorsfile and authorsLName are arrays
        if (is_array($images)) {
            // Combine authorsfile and authorsLName into an array of objects
            $authorsData = [];
            for ($i = 0; $i < count($images); $i++) {
                $authorsData[] = url("storage/".$images[$i]);
            }
            // Add the modified files to the array
            $this->images = $authorsData;
        }else{
            $this->images = [];
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'price_after_discount' => $this->price_after_discount,
            'discount_percentage' => $this->discount_percentage,
            'images' => $this->images,
            'stock' => $this->stock,
            'fixed_discount' => $this->fixed_discount,
            'img'   => $this->img ? url("storage/".$this->img) : null,
            'category' =>CategoryResource::collection($this->categories),
            'attributes' => $this->attributeValues->map(function ($attributeValue) {
                return [
                    'id' => $attributeValue->id,
                    'attribute_name' => $attributeValue->attribute->name,
                    'value' => $attributeValue->value,
                    'color' => $attributeValue->color,
                    'type' => $attributeValue->color?"color":"text",
                ];
            })
            // Add other fields as needed
        ];
    }
}
