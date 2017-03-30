<?php

namespace TempFileService;

use TempFileService\Exception\Exception;

/**
 * Service to create a temp file.
 */
class Service
{
    /**
     * Create new temp file.
     *
     * @param string $content Content to write to file
     *
     * @return TempFile Returns new temp file
     *
     * @throws Exception Can't get a temp file
     */
    public static function create($content = '')
    {
        try {
            $file = new TempFile();

            if (!empty($content)) {
                $file->write($content);
            }
        } catch (TempFileException $e) {
            throw new Exception($e->getMessage());
        }

        return $file;
    }
}
