<?php

namespace spec\Cache\Adapter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Szymon Skirgajllo <szymon.skirgajllo@gmail.com>
 */
class FileSpec extends ObjectBehavior
{
    private $existingKey = 'some_existing_phpspec:key';
    private $existingNamespace = 'some_existing_phpspec';
    private $nonExistingKey = 'some_non_existing_phpspec:key';
    private $nonExistingNamespace = 'some_non_existing_phpspec';

    function it_is_initializable()
    {
        $this->shouldHaveType('Cache\Adapter\File');
    }

    function it_should_be_able_to_add_item_to_cache()
    {
        $this->setItem($this->existingKey, ['some_content_specified_for_file'], 300)->shouldReturn(true);
    }

    function it_should_be_able_to_get_item_from_cache()
    {
        $result = $this->getItem($this->existingKey);

        $result->shouldBeArray();
        $result->shouldContain('some_content_specified_for_file');
    }

    function it_should_not_be_able_to_get_item_from_cache()
    {
        $result = $this->getItem($this->nonExistingKey);

        $result->shouldBeBoolean();
        $result->shouldReturn(false);
    }

    function it_should_not_be_able_to_get_item_from_cache_with_empty_key()
    {
        $this->shouldThrow('\Exception')->duringGetItem('');
    }

    function it_should_return_whether_given_key_exists_in_cache()
    {
        $this->hasItem($this->existingKey)->shouldReturn(true);
        $this->hasItem($this->nonExistingKey)->shouldReturn(false);
    }

    function it_should_remove_existing_key()
    {
        $this->removeItem($this->existingKey)->shouldReturn(true);
    }

    function it_should_not_remove_non_existing_key()
    {
        $this->removeItem($this->nonExistingKey)->shouldReturn(false);
    }

    function it_should_be_able_to_drop_cache_by_given_namespace()
    {
        $this->dropItems($this->existingNamespace)->shouldReturn(true);
        $this->dropItems($this->nonExistingNamespace)->shouldReturn(false);
    }

    function it_should_throw_exception_when_namespace_is_empty()
    {
        $this->shouldThrow('\Exception')->duringDropItems('');
    }
}
