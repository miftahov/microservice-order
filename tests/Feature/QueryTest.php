<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Models\Order;
use App\Domain\Order\Query\OrderQuery;
use App\Domain\Order\DTO\OrderQueryDTO;

class QueryTest extends TestCase
{
    public function test_query_order()
    {
        Queue::fake();
        $order = new Order();
        $data = $order->toArray();
        $dto = new OrderQueryDTO($data);
        OrderQuery::dispatch($dto);
        Queue::assertPushed(OrderQuery::class);
    }
}
