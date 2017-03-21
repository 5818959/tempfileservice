<?php

/**
 * Dump temp file parameters.
 *
 * @param \TempFileService\TempFile $tempFile A temp file
 */
function dumpTempFileStat(\TempFileService\TempFile $tempFile)
{
    echo 'Temp file name: ' . $tempFile->getName() . PHP_EOL;
    echo 'Temp file dir: ' . $tempFile->getDir() . PHP_EOL;
    echo 'Temp file path: ' . $tempFile->getPath() . PHP_EOL;
    echo '---' . PHP_EOL;
}
