<?php

namespace App\GraphQL\Queries;

class Resolver
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        return 'resolver!';
    }
}
