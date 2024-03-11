<?php

namespace App\DTO\Admin;
class InfoProductDTO
{
    public string $product_name;
    public string $product_key;
    public string $image;
    public string $description;

    public function __construct(string $product_name, string $product_key, string $image, string $description)
    {
        $this->product_name = $product_name;
        $this->product_key = $product_key;
        $this->image = $image;
        $this->description = $description;
    }
}
