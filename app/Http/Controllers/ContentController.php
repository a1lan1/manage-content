<?php

namespace App\Http\Controllers;

use App\Services\ContentService;
use Illuminate\Http\Request;

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
        $contents = $this->contentService->getContents();

        return response()->json($contents);
    }
}
