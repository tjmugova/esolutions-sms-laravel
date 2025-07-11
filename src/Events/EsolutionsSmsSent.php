<?php

namespace Tjmugova\EsolutionsSms\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Collection;

class EsolutionsSmsSent
{
    use Dispatchable, SerializesModels;

    public array $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }
}