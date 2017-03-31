<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'support.php';

echo 'Create a temp file:' . PHP_EOL;

$tempFile = new \TempFileService\TempFile();

dumpTempFileStat($tempFile);

echo 'Write some data to it:' . PHP_EOL;

$exampleData = 'some test text';

echo 'write "' . $exampleData . '"' . PHP_EOL;
if ($tempFile->write($exampleData)) {
    echo '  done.' . PHP_EOL;
} else {
    echo '  ERROR.' . PHP_EOL;
}

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

echo 'Destroy temp file:' . PHP_EOL;

$filePath = $tempFile->getPath();
unset($tempFile);
if (!file_exists($filePath)) {
    echo '  done.' . PHP_EOL;
} else {
    echo '  ERROR.';
}
echo '---' . PHP_EOL;

echo 'Create a temp file in the specified directory (use current directory):' . PHP_EOL;

$tempFile = new \TempFileService\TempFile(__DIR__);

dumpTempFileStat($tempFile);

unset($tempFile);

echo 'Create a temporary file in a non-existent directory:' . PHP_EOL;

$tempFile = new \TempFileService\TempFile(__DIR__ . '/non_existent');

dumpTempFileStat($tempFile);

unset($tempFile);

$fileName = 'example_' . uniqid(mt_rand(), true);

echo 'Create a temporary file with the specified name (' . $fileName . '):' . PHP_EOL;

// prepare
if (file_exists(__DIR__ . '/' . $fileName)) {
    unlink(__DIR__ . '/' . $fileName);
}

$tempFile = new \TempFileService\TempFile(__DIR__, 'testFileName');

dumpTempFileStat($tempFile);
