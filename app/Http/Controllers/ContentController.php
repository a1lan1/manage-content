<?php

namespace App\Http\Controllers;

use App\Services\ContentService;

class ContentController extends Controller
{
    /**
     * @var ContentService
     */
    private $contentService;

    /**
     * ContentController constructor.
     * @param ContentService $contentService
     */
    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Contents
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContents()
    {
        return response()->json($this->contentService->getContents());
    }
}
