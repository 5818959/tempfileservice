<?php

namespace spec\TempFileService;

use TempFileService\TempFile;
use TempFileService\Exception\CreateTempFileException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TempFileSpec extends ObjectBehavior
{
    function it_can_create_a_temp_file_in_system_dir()
    {
        $this->getDir()->shouldBe(realpath(sys_get_temp_dir()));
    }

    function it_can_create_a_temp_file_in_the_specified_directory()
    {
        $this->beConstructedWith(__DIR__);

        $this->getDir()->shouldBe(realpath(__DIR__));
    }

    function it_can_create_a_temp_file_with_the_specified_name()
    {
        $fileName = 'spec' . uniqid(mt_rand(), true);

        $this->beConstructedWith('', $fileName);

        $this->getName()->shouldBe($fileName);
    }

    function it_cant_create_a_temp_file_if_a_file_with_the_same_name_is_already_exists()
    {
        $fileName = 'spec' . uniqid(mt_rand(), true);
        $fileDir = sys_get_temp_dir();

        // create a file
        $filePath = $fileDir . '/' . $fileName;
        if (@file_exists($filePath) === false) {
            @touch($filePath);
        }

        $this->beConstructedWith($fileDir, $fileName);

        $exception = new CreateTempFileException(
            'Can\'t create a temp file because it already exists'
        );
        $this->shouldThrow($exception)->duringInstantiation();

        // clean up
        unlink($filePath);
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

    function it_can_write_and_read_content_to_and_from_a_file()
    {
        $sampleContent = 'some text string';

        $this->write($sampleContent)->shouldReturn(true);
        $this->read()->shouldReturn($sampleContent);
    }

    function it_should_create_a_temp_file_even_if_the_specified_directory_does_not_exist()
    {
        $folder = __DIR__ . '/folder_does_not_exist';

        $this->beConstructedWith($folder);

        $this->getDir()->shouldBeString();
        $this->getName()->shouldBeString();
    }
}
