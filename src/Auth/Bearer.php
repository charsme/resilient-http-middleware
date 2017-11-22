<?php

namespace Resilient\MiddleWare\Auth;

use Resilient\MiddleWare\Auth\BearerInterface;
use Resilient\MiddleWare\Auth\BearerTraits;

class Bearer implements BearerInterface
{
    use BearerTraits;
}
