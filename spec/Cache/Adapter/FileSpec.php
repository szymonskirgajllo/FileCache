<?php

namespace spec\Cache\Adapter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cache\Adapter\File');
    }
}
