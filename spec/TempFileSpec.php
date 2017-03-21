<?php

namespace spec\TempFileService;

use TempFileService\TempFile;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TempFileSpec extends ObjectBehavior
{
    function it_can_create_tmp_file_in_system_dir()
    {
        $this->beConstructedWith('');

        $this->getDir()->shouldBe(realpath(sys_get_temp_dir()));
    }

    function it_can_create_tmp_file_in_specified_directory()
    {
        $this->beConstructedWith(__DIR__);

        $this->getDir()->shouldBe(realpath(__DIR__));
    }

    function it_should_return_dir()
    {
        $this->getDir()->shouldBeString();
    }

    function it_should_return_name()
    {
        $this->getName()->shouldBeString();
    }

    function it_should_return_valid_path()
    {
        $this->getPath()->shouldBeString();
    }

    function it_can_write_content_to_file()
    {
        $sampleContent = 'some text string';

        $this->write($sampleContent)->shouldReturn(true);
        $this->read()->shouldReturn($sampleContent);
    }

    function it_can_read_content_from_file()
    {
        // running right after temp file was created
        $this->read()->shouldReturn('');
    }

    function it_should_create_a_temp_file_even_if_the_specified_directory_does_not_exist()
    {
        $folder = __DIR__ . '/folder_does_not_exist';

        $this->beConstructedWith($folder);

        $this->getDir()->shouldBeString();
        $this->getName()->shouldBeString();
    }
}
