<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'support.php';

echo 'Create a temporary file through the service:' . PHP_EOL;

$tempFile = \TempFileService\Service::create();

dumpTempFileStat($tempFile);

unset($tempFile);

echo 'Create a temporary file with content through the service:' . PHP_EOL;

$exampleData = 'some test text';

$tempFile = \TempFileService\Service::create($exampleData);

echo 'Read data from temp file:' . PHP_EOL;

if ($data = $tempFile->read()) {
    echo '  done.' . PHP_EOL;
    if ($data === $exampleData) {
        echo 'Sample data match.' . PHP_EOL;
    } else {
        echo 'Sample data NOT match.' . PHP_EOL;
    }
} else {
    echo '  ERROR.' . PHP_EOL;
}
echo '---' . PHP_EOL;
