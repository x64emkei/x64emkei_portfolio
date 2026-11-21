<?php
declare(strict_types=1);

namespace App\Services;

use RuntimeException;
use Throwable;

class HttpException extends RuntimeException
{
    private int $statusCode;

    public function __construct(int $statusCode = 500, string $message = '', ?Throwable $previous = null)
    {
        $this->statusCode = $statusCode;
        parent::__construct($message, $statusCode, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
