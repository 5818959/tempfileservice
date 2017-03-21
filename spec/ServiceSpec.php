<?php

namespace spec\TempFileService;

use TempFileService\Service;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Service::class);
    }

    function it_can_create_a_temp_file()
    {
        self::create()->shouldHaveType('\TempFileService\TempFile');
    }

    function it_can_create_a_temp_file_with_content()
    {
        $exampleContent = 'some text data';
        self::create($exampleContent)->shouldHaveType('\TempFileService\TempFile');
    }
}
