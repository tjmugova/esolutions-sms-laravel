<?php

namespace Tjmugova\EsolutionsSms\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Collection;

class EsolutionsSmsSent
{
    use Dispatchable, SerializesModels;

    public Collection $response;

    public function __construct(Collection $response)
    {
        $this->response = $response;
    }
}