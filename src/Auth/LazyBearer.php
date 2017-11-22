<?php

namespace Resilient\MiddleWare\Auth;

class LazyBearer
{
    protected $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function __invoke()
    {
        return $this->callable();
    }
}
