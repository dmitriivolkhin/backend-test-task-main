<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure;

class ConnectorException extends \Exception
{
    public function __construct(
        protected           $message,
        protected           $code,
        private ?\Throwable $previous,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string
    {
        return sprintf(
            '[%s] %s in %s on line %d',
            $this->getCode(),
            $this->getMessage(),
            $this->getFile(),
            $this->getLine(),
        );
    }
}
