<?php
namespace Framy\Routing;

class Test
{
    private $test2;

    public function __construct(Test2 $test2)
    {
        $this->test2 = $test2;
        echo "Test";
    }
}