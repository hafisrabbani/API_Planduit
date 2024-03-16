<?php

namespace App\DTO\Admin;

class BlogCategoryDTO
{
    public $title;

    public function __construct($title)
    {
        $this->title = $title;
    }
}
