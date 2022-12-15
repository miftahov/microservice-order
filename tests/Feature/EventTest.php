<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Models\Order;
use App\Domain\Order\Event\OrderCreated;
use App\Domain\Order\Event\OrderDeleted;
use App\Domain\Order\Event\OrderUpdated;
use App\Domain\Order\DTO\OrderCreatedDTO;
use App\Domain\Order\DTO\OrderDeletedDTO;
use App\Domain\Order\DTO\OrderUpdatedDTO;

class EventTest extends TestCase
{
    public function test_event_order_created()
    {
        Queue::fake();
        $order = new Order();
        $data = $order->toArray();
        $dto = new OrderCreatedDTO($data);
        OrderCreated::dispatch($dto);
        Queue::assertPushed(OrderCreated::class);
    }

    public function test_event_order_deleted()
    {
        Queue::fake();
        $order = new Order();
        $data = $order->toArray();
        $dto = new OrderDeletedDTO($data);
        OrderDeleted::dispatch($dto);
        Queue::assertPushed(OrderDeleted::class);
    }

    public function test_event_order_updated()
    {
        Queue::fake();
        $order = new Order();
        $data = $order->toArray();
        $dto = new OrderUpdatedDTO($data);
        OrderUpdated::dispatch($dto);
        Queue::assertPushed(OrderUpdated::class);
    }
}
