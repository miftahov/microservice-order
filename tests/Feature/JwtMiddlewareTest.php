<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Mockery;
use Mockery\MockInterface;
use Illuminate\Http\Request;
use App\Http\Middleware\JwtMiddleware;

class JwtMiddlewareTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTokenNotFound()
    {
        $request = new Request;
        $middleware = new JwtMiddleware();
        $result = $middleware->handle($request, function(){});
        $data = $result->getData();
        $this->assertEquals('Authorization Token not found', $data->message);
    }

    //Token Is Invalid
    public function testTokenIsInvalid()
    {
        $request = new Request;
        $request->headers->add(['Authorization' => 'Bearer invalidtoken']);
        $middleware = new JwtMiddleware();
        $result = $middleware->handle($request, function(){});
        $data = $result->getData();
        $this->assertEquals('Authorization Token not found', $data->message);
    }
}
