<?php

namespace TempFileService;

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
     */
    public static function create($content = '')
    {
        $file = new TempFile();

        if (!empty($content)) {
            $file->write($content);
        }

        return $file;
    }
}
