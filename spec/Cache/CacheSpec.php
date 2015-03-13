<?php

namespace spec\Cache;

use Cache\AdapterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CacheSpec extends ObjectBehavior
{
    function let(AdapterInterface $adapter)
    {
        $adapter->setItem('test_data', [], 3600)->willReturn(true);

        $this->setAdapter($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Cache\Cache');
    }

    function it_should_be_able_to_set_cache_adapter()
    {
        // should return $this
        $this->getAdapter()->shouldBeAnInstanceOf('Cache\AdapterInterface');
    }
    
    function it_should_be_able_to_set_cache_namespace()
    {
        $namespace = 'test_namespace';

        // should return $this
        $this->setNamespace($namespace)->shouldBeAnInstanceOf('Cache\Cache');
    }
    
    function it_should_not_be_able_to_set_empty_namespace()
    {
        $this->shouldThrow('\UnexpectedValueException')->duringSetNamespace('');
    }

    function it_should_be_able_to_add_item_to_cache()
    {
        $key = 'test_data';
        $data = [

        ];
        $ttl = 3600;

        $itemForCache = $this->addItem($key, $data, $ttl);

        $itemForCache->shouldBeBool();
        $itemForCache->shouldReturn(true);
    }
//
    function it_should_be_able_to_get_item_from_cache(AdapterInterface $adapter)
    {
        $key = 'test_data';
        $data = [
            'some data',
            'some other data'
        ];

        $adapter->getItem($key)->willReturn([
            'some data',
            'some other data'
        ]);

        $item = $this->getItem($key);

        $item->shouldBeArray();
        $item->shouldReturn($data);
    }
//
    function it_should_not_be_able_to_get_item_from_cache(AdapterInterface $adapter)
    {
        $key = 'fail_data';

        $adapter->getItem($key)->willReturn(false);

        $this->getItem($key)->shouldBeBool();
        $this->getItem($key)->shouldReturn(false);
    }
}
