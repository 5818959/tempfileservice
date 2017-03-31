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
     * @param array $options Temp file options
     *
     * @return TempFile Returns new temp file
     *
     * @throws Exception Can't get a temp file
     */
    public static function create(array $options = array())
    {
        try {
            $fileDir = isset($options['dir']) ? (string) $options['dir'] : '';
            $fileName = isset($options['name']) ? (string) $options['name'] : '';
            $file = new TempFile($fileDir, $fileName);

            if (isset($options['content']) && !empty($options['content'])) {
                $file->write($options['content']);
            }
        } catch (TempFileException $e) {
            throw new Exception($e->getMessage());
        }

        return $file;
    }
}
