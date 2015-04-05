<?php

namespace spec\Cache\Adapter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Szymon Skirgajllo <szymon.skirgajllo@gmail.com>
 */
class MemcachedSpec extends ObjectBehavior
{
    private $existingKey = 'some_existing_phpspec:key';
    private $existingNamespace = 'some_existing_phpspec';
    private $nonExistingKey = 'some_non_existing_phpspec:key';
    private $nonExistingNamespace = 'some_non_existing_phpspec';

    function let()
    {
        $this->beConstructedWith([
            ['localhost', 11211]
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Cache\Adapter\Memcached');
    }

    function it_should_be_able_to_add_item_to_cache()
    {
        $this->setItem($this->existingKey, ['some_content_specified_for_memcached'], 300)->shouldReturn(true);
    }

    function it_should_be_able_to_get_item_from_cache()
    {
        $result = $this->getItem($this->existingKey);

        $result->shouldBeArray();
        $result->shouldContain('some_content_specified_for_memcached');
    }

    function it_should_be_able_to_get_item_from_cache_with_non_existing_key()
    {
        $result = $this->getItem($this->nonExistingKey);

        $result->shouldBeBoolean();
        $result->shouldReturn(false);
    }

    function it_should_throw_exception_while_receiving_data_from_cache_with_empty_key()
    {
        $this->shouldThrow('\Exception')->duringGetItem('');
    }

    function it_should_return_whether_given_key_exists_in_cache()
    {
        $result = $this->hasItem($this->existingKey);
        $result->shouldBeBoolean();
        $result->shouldReturn(true);

        $result = $this->hasItem($this->nonExistingKey);
        $result->shouldBeBoolean();
        $result->shouldReturn(false);
    }

    function it_should_throw_exception_while_checking_whether_given_empty_key_exist_in_cache()
    {
        $this->shouldThrow('\Exception')->duringHasItem('');
    }

    function it_should_be_able_to_remove_existing_key_from_cache()
    {
        $result = $this->removeItem($this->existingKey);
        
        $result->shouldBeBoolean();
        $result->shouldReturn(true);
    }

    function it_should_not_be_able_to_remove_non_existing_key_from_cache()
    {
        $result = $this->removeItem($this->nonExistingKey);

        $result->shouldBeBoolean();
        $result->shouldReturn(false);
    }

    function it_should_be_able_to_drop_cache_with_existing_namespace()
    {
        $result = $this->dropItems($this->existingNamespace);

        $result->shouldBeBoolean();
        $result->shouldReturn(true);
    }

    function it_should_not_be_able_to_drop_cache_with_non_existing_namespace()
    {
        $result = $this->dropItems($this->nonExistingNamespace);

        $result->shouldBeBoolean();
        $result->shouldReturn(false);
    }

    function it_should_throw_exception_when_namespace_is_empty_while_dropping_cache()
    {
        $this->shouldThrow('\Exception')->duringDropItems('');
    }
}
