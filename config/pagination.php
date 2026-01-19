<?php

return [
    'per_page' => env('PAGINATION_PER_PAGE', 15),
    'method' => env('PAGINATION_METHOD', 'paginate'), // Options: 'paginate', 'simplePaginate', 'cursorPaginate'
];
