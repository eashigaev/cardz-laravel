<?php

namespace CardzApp\Api\Shared\Transformers;

use Illuminate\Pagination\AbstractPaginator;

class PaginatorTransformer
{
    public function transform(AbstractPaginator $paginator, callable $itemTransformer): array
    {
        return [
            'items' => $paginator->map($itemTransformer),
            'meta' => [
                'page' => $paginator->currentPage(),
                'count_items' => $paginator->total(),
                'count_pages' => $paginator->count(),
                'per_page' => $paginator->perPage()
            ]
        ];
    }
}
