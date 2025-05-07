<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Repository;

use Exception;
use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Domain\Cart;
use Raketa\BackendTestTask\Infrastructure\ConnectorFacade;

class CartManager extends ConnectorFacade
{
    public $logger;

    public function __construct($host, $port, $password)
    {
        parent::__construct($host, $port, $password, 1);
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public function saveCart(Cart $cart): void
    {
        try {
            $this->getConnector()->set(session_id(), $cart);
        } catch (Exception $e) {
            $this->logger->error('Error');
        }
    }

    /**
     * @return ?Cart
     */
    public function getCart(): ?Cart
    {
        try {
            return $this->getConnector()->get(session_id());
        } catch (Exception $e) {
            $this->logger->error('Error');
        }

        return null;
    }
}
