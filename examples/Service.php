<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'support.php';

echo 'Create a temporary file:' . PHP_EOL;

$tempFile = \TempFileService\Service::create();

dumpTempFileStat($tempFile);

unset($tempFile);

echo 'Create a temporary file with content:' . PHP_EOL;

$exampleData = 'some test text';

$tempFile = \TempFileService\Service::create(array('content' => $exampleData));

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

unset($tempFile);

$fileName = 'spec' . uniqid(mt_rand(), true);
echo 'Create a temporary file with specified name (' . $fileName . '):' . PHP_EOL;

$tempFile = \TempFileService\Service::create(array('name' => $fileName));

echo 'Temp file name is "' . $tempFile->getName() . '" and its '
   . ($tempFile->getName() === $fileName ? '' : 'NOT ') . 'match.' . PHP_EOL;
