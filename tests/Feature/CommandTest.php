<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Models\Order;
use App\Domain\Order\Command\OrderCancel;
use App\Domain\Order\Command\OrderCreate;
use App\Domain\Order\Command\OrderUpdate;
use App\Domain\Order\DTO\OrderCancelDTO;
use App\Domain\Order\DTO\OrderCreateDTO;
use App\Domain\Order\DTO\OrderUpdateDTO;

class CommandTest extends TestCase
{
    public function test_command_order_cancel()
    {
        Queue::fake();
        $order = new Order();
        $data = $order->toArray();
        $dto = new OrderCancelDTO($data);
        OrderCancel::dispatch($dto);
        Queue::assertPushed(OrderCancel::class);
    }

    public function test_command_order_create()
    {
        Queue::fake();
        $order = new Order();
        $data = $order->toArray();
        $dto = new OrderCreateDTO($data);
        OrderCreate::dispatch($dto);
        Queue::assertPushed(OrderCreate::class);
    }

    public function test_command_order_update()
    {
        Queue::fake();
        $order = new Order();
        $data = $order->toArray();
        $dto = new OrderUpdateDTO($data);
        OrderUpdate::dispatch($dto);
        Queue::assertPushed(OrderUpdate::class);
    }
}
