<?php

/**
 * "Software entities ... should be open for extension, but closed for modification."
 *  - Wikipedia
 */

// Breaching Open Closed Principle

namespace Fmo\Solid\Breach;

class OrderRepository {
    private array $orders = [];

    public function getOrders(): array
    {
        return $this->orders;
    }

    public function save(Order $order): void
    {
        $this->orders[] = $order;
    }
}
class Order
{
    public function __construct(
        private array $items,
        private int $amount)
    {
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }
    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}

class NotifyViaEmail
{
    public function __invoke(string $msg): void
    {
        print_r($msg);
    }
}

class NotifyViaSms
{
    public function __invoke(string $msg): void
    {
        print_r($msg);
    }
}

class Purchase
{
    const NOTIFICATION = 'email';
    private OrderRepository $orderRepository;
    private NotifyViaEmail $notifyViaEmail;

    private NotifyViaSms $notifyViaSms;
    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->notifyViaSms = new NotifyViaSms();
        $this->notifyViaEmail = new NotifyViaEmail();
    }

    public function __invoke($items, $amount): void
    {
        $this->orderRepository->save(new Order($items, $amount));

        if (self::NOTIFICATION === 'email') {
            ($this->notifyViaEmail)('PURCHASE IS DONE');
        } elseif (self::NOTIFICATION === 'sms') {
            ($this->notifyViaSms)('PURCHASE IS DONE');
        }
    }
}

// Fixing Open Closed Principle

namespace Fmo\Solid\Fix;

use Fmo\Solid\Breach\Order;
use Fmo\Solid\Breach\OrderRepository;

interface NotifyInterface
{
    public function __invoke(string $msg): void;
}
class NotifyViaEmail implements NotifyInterface
{
    public function __invoke(string $msg): void
    {
        print_r($msg);
    }
}

class NotifyViaSms implements NotifyInterface
{
    public function __invoke(string $msg): void
    {
        print_r($msg);
    }
}

class Purchase
{
    private OrderRepository $orderRepository;
    private NotifyInterface $notify;
    public function __construct(NotifyInterface $notify)
    {
        $this->orderRepository = new OrderRepository();
        $this->notify = $notify;
    }

    public function __invoke($items, $amount): void
    {
        $this->orderRepository->save(new Order($items, $amount));

        ($this->notify)('PURCHASE IS DONE');
    }
}

(new Purchase(new NotifyViaEmail()))(
    ["item-1923", "item-1924"],
    "1000"
);
