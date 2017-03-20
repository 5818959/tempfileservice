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
     * @return TempFile Returns new temp file
     */
    public static function create()
    {
        $file = new TempFile();

        return $file;
    }
}
