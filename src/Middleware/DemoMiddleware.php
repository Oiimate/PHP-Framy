<?php

namespace Framy\Middleware;

class DemoMiddleware extends Middleware
{
    public function run()
    {
        echo "Test from DemoMiddleware ";
    }
}