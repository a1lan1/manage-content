<?php

namespace App\Services;

use App\Content;

class ContentService
{
    /**
     * @var Content
     */
    private $content;

    /**
     * ContentService constructor.
     * @param Content $content
     */
    public function __construct(Content $content)
    {
        $this->content = $content;
    }

    /**
     * Contents
     *
     * @return content
     */
    public function getContents()
    {
        return $this->content->inRandomOrder()->get();
    }
}