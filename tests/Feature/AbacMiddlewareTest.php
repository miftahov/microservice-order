<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;
use Illuminate\Http\Request;
use App\Http\Middleware\AbacMiddleware;

class AbacMiddlewareTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAttributesNotFound()
    {
        $request = new Request;
        $payload = array();
        $mock = $this->partialMock(AbacMiddleware::class);
        $mock->shouldReceive('getPayload')->andReturn($payload);
        $result = $mock->handle($request, function(){});
        $data = $result->getData();
        $this->assertEquals('attributes not found', $data->message);
    }

    public function testGraphqlQueryNotFound()
    {
        $request = new Request;
        $payload = array(
            'attributes'    => array(),
            'policy_groups' => array(),
        );
        $mock = $this->partialMock(AbacMiddleware::class);
        $mock->shouldReceive('getPayload')->andReturn($payload);
        $result = $mock->handle($request, function(){});
        $data = $result->getData();
        $this->assertEquals('query not found', $data->message);
    }

    public function testAccessDenied()
    {
        $request = new Request;
        $request->merge(['query' => '']);
        $payload = array(
            'attributes'    => array(),
            'policy_groups' => array(),
        );
        $mock = $this->partialMock(AbacMiddleware::class);
        $mock->shouldReceive('getPayload')->andReturn($payload);
        $result = $mock->handle($request, function(){});
        $data = $result->getData();
        $this->assertEquals('Access denied', $data->message);
    }

    public function testAccessDenied2()
    {
        $request = new Request;
        $request->merge(['query' => '']);
        $attributes = $this->attributes();
        $attributes['user']['active'] = false;
        $payload = array(
            'attributes'    => $attributes,
            'policy_groups' => $this->policygroups(),
        );
        $mock = $this->partialMock(AbacMiddleware::class);
        $mock->shouldReceive('getPayload')->andReturn($payload);
        $result = $mock->handle($request, function(){});
        $data = $result->getData();
        $this->assertEquals('Access denied', $data->message);
    }

    public function testAccessAllowed()
    {
        $request = new Request;
        $request->merge(['query' => '']);
        $payload = array(
            'attributes'    => $this->attributes(),
            'policy_groups' => $this->policygroups(),
        );
        $mock = $this->partialMock(AbacMiddleware::class);
        $mock->shouldReceive('getPayload')->andReturn($payload);
        $result = $mock->handle($request, function(){ return 'ok';});
        $this->assertEquals('ok', $result);
    }

    private function attributes()
    {
        $user = array(
            'id'     => 1,
            'name'   => 'Пётр',
            'role'   => 'cook',
            'active' => true,
        );
        $resource = array(
            'resource' => 'query {orders {id status}}',
        );
        $attributes = array(
            'user'     => $user,     // Атрибуты пользователя
            'resource' => $resource, // Атрибуты ресурса
        );
        return $attributes;
    }

    public function policygroups()
    {
        $condition = array(
            'attr_group' => 'user',
            'attribute'  => 'active',
            'value'      => true,
        );
        $rule[]          = $condition;
        $policy[]        = $rule;
        $policy_group[]  = $policy;
        $policy_groups[] = $policy_group;
        return $policy_groups;
    }
}
