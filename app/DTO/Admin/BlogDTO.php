<?php

namespace App\DTO\Admin;

class BlogDTO
{
    public $title;
    public $description;
    public $blog_category_id;
    public $thumbnail;
    public $slug;
    public $status;

    const LIST_STATUS = ['draft', 'published'];

    public function __construct($title, $description, $blog_category_id, $thumbnail, $slug = null, $status = 'draft')
    {
        if (!in_array($status, self::LIST_STATUS)) {
            throw new \Exception('Status not valid');
        }
        $this->title = $title;
        $this->description = $description;
        $this->blog_category_id = $blog_category_id;
        $this->thumbnail = $thumbnail;
        $this->slug = $slug;
        $this->status = $status;
    }
}
