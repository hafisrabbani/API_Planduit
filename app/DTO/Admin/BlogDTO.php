<?php

namespace App\DTO\Admin;

class BlogDTO
{
    public $title;
    public $description;
    public $blog_category_id;
    public $thumbnail;
    public $slug;

    public function __construct($title, $description, $blog_category_id, $thumbnail, $slug = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->blog_category_id = $blog_category_id;
        $this->thumbnail = $thumbnail;
        $this->slug = $slug;
    }
}
