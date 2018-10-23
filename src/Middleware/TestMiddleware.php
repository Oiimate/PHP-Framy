<?php

namespace Framy\Middleware;

class TestMiddleware extends Middleware
{
    public function run()
    {
        echo "Test from TestMiddleware ";
    }
}