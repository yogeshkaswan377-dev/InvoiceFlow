<?php

namespace App\Http\Resources;

trait PaginatedResourceTrait
{
    /**
     * Create a paginated JSON response.
     */
    public static function paginated($resource, string $wrapper = 'data'): array
    {
        return [
            'success' => true,
            $wrapper => $resource->items(),
            'meta' => [
                'current_page' => $resource->currentPage(),
                'last_page' => $resource->lastPage(),
                'per_page' => $resource->perPage(),
                'total' => $resource->total(),
                'from' => $resource->firstItem(),
                'to' => $resource->lastItem(),
            ],
            'links' => [
                'first' => $resource->url(1),
                'last' => $resource->url($resource->lastPage()),
                'prev' => $resource->previousPageUrl(),
                'next' => $resource->nextPageUrl(),
            ],
        ];
    }
}
