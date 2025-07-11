<?php

declare(strict_types=1);

namespace Tjmugova\EsolutionsSms\Exceptions;

class InvalidConfigException extends \Exception
{
    public static function missingConfig(): self
    {
        return new self('Missing config. You must set either the api username & password or sender id');
    }
}