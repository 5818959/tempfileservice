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
        $options = array(
            'content' => $exampleContent,
        );

        $tmpFile = self::create($options);

        $tmpFile->shouldHaveType('\TempFileService\TempFile');
        $tmpFile->read()->shouldBe($exampleContent);
    }

    function it_can_create_a_temp_file_in_the_specified_directory()
    {
        $fileDir = __DIR__;
        $options = array(
            'dir' => $fileDir,
        );

        $tmpFile = self::create($options);

        $tmpFile->getDir()->shouldBe(realpath($fileDir));
    }

    function it_can_create_a_temp_file_with_the_specified_name()
    {
        $fileName = 'spec' . uniqid(mt_rand(), true);
        $options = array(
            'name' => $fileName,
        );

        $tmpFile = self::create($options);
        $tmpFile->getName()->shouldBe($fileName);
    }

    function it_can_create_a_temp_file_with_a_name_prefix()
    {
        $fileName = uniqid(mt_rand(), true);
        $fileNamePrefix = 'spec';
        $options = array(
            'name' => $fileName,
            'prefix' => $fileNamePrefix,
        );

        $tmpFile = self::create($options);
        $tmpFile->getName()->shouldBe($fileNamePrefix . $fileName);
    }

    function it_can_create_a_temp_file_with_a_name_postfix()
    {
        $fileName = 'spec' . uniqid(mt_rand(), true);
        $fileNamePostfix = '_a';
        $options = array(
            'name' => $fileName,
            'postfix' => $fileNamePostfix,
        );

        $tmpFile = self::create($options);
        $tmpFile->getName()->shouldBe($fileName . $fileNamePostfix);
    }

    function it_can_create_a_temp_file_with_a_prefix_and_postfix_without_specified_name()
    {
        $fileNamePrefix = 'spec';
        $fileNamePostfix = '.spc';
        $options = array(
            'prefix' => $fileNamePrefix,
            'postfix' => $fileNamePostfix,
        );

        $tmpFile = self::create($options);
        $tmpFile->getName()->shouldStartWith($fileNamePrefix);
        $tmpFile->getName()->shouldEndWith($fileNamePostfix);
    }
}
