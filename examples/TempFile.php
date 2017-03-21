<?php

namespace TempFileService;

require_once __DIR__ . '/../vendor/autoload.php';

function dumpTempFileStat(TempFile $tempFile)
{
    echo 'Temp file name: ' . $tempFile->getName() . PHP_EOL;
    echo 'Temp file dir: ' . $tempFile->getDir() . PHP_EOL;
    echo 'Temp file path: ' . $tempFile->getPath() . PHP_EOL;
}

// create a temp file

$tempFile = new TempFile();

dumpTempFileStat($tempFile);

// write some data to it

$exampleData = 'some test text';

echo 'Write sample data to temp file "' . $exampleData . '":' . PHP_EOL;
if ($tempFile->write($exampleData)) {
    echo '  done.' . PHP_EOL;
} else {
    echo '  ERROR.' . PHP_EOL;
}

// read data

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

// destroy temp file

unset($tempFile);

// сreate a temp file in the specified directory (use current directory)

$tempFile = new TempFile(__DIR__);

dumpTempFileStat($tempFile);
