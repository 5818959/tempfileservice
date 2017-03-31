<?php

namespace TempFileService;

use TempFileService\Exception\Exception;

/**
 * Service to create a temp file.
 */
class Service
{
    /**
     * Attempts quantity to generate unique file name.
     */
    const UNIQ_FILE_ATTEMPTS = 10;

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
            $fileNamePrefix = isset($options['prefix']) ? (string) $options['prefix'] : '';
            $fileNamePostfix = isset($options['postfix']) ? (string) $options['postfix'] : '';

            $fileName = self::prepareFileName($fileDir, $fileName, $fileNamePrefix, $fileNamePostfix);

            $file = new TempFile($fileDir, $fileName);

            if (isset($options['content']) && !empty($options['content'])) {
                $file->write($options['content']);
            }
        } catch (TempFileException $e) {
            throw new Exception($e->getMessage());
        }

        return $file;
    }

    /**
     * Generate unique file name in specified directory.
     *
     * @param string $dir     File directory
     * @param string $prefix  File name prefix
     * @param string $postfix File name postfix
     *
     * @return string Unique file name in specified directory
     *
     * @throws Exception Can't generate unique file name
     */
    public static function generateUniqueFileName($dir = '', $prefix = '', $postfix = '')
    {
        if (empty($dir)) {
            $dir = sys_get_temp_dir();
        }

        for ($i = 0; $i < self::UNIQ_FILE_ATTEMPTS; ++$i) {
            $name = $prefix . uniqid(mt_rand(), true) . $postfix;
            $file = $dir . '/' . $name;

            if (@file_exists($file) === false) {
                return $name;
            }
        }

        throw new Exception('Can\'t generate unique file name.');
    }

    /**
     * Prepare file name.
     *
     * @param string $dir     File directory
     * @param string $name    File name
     * @param string $prefix  File name prefix
     * @param string $postfix File name postfix
     *
     * @return string Prepared file name
     **/
    private static function prepareFileName($dir, $name, $prefix, $postfix)
    {
        if (empty($name) && (!empty($prefix) || !empty($postfix))) {
            return self::generateUniqueFileName($dir, $prefix, $postfix);
        }

        return $prefix . $name . $postfix;
    }
}
