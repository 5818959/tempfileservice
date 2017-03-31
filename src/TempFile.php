<?php

namespace TempFileService;

use TempFileService\Exception\CreateTempFileException;
use TempFileService\Exception\WriteTempFileException;
use TempFileService\Exception\ReadTempFileException;
use TempFileService\Exception\DestroyTempFileException;

/**
 * Temp file.
 */
class TempFile
{
    /**
     * File dir.
     *
     * @var string
     */
    private $dir;
    /**
     * File name.
     *
     * @var string
     */
    private $name = '';

    /**
     * Constructor.
     *
     * @param string $fileDir  Temp file directory
     * @param string $fileName Temp file name
     */
    public function __construct($fileDir = '', $fileName = '')
    {
        if (empty($fileDir)) {
            $fileDir = sys_get_temp_dir();
        }

        $fileName = (string) $fileName;
        $file = empty($fileName)
                ? $this->createFileWithTempName($fileDir)
                : $this->createFile($fileDir, $fileName);

        $this->dir = dirname($file);
        $this->name = basename($file);
    }

    /**
     * Return file name.
     *
     * @return string File name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return dir name.
     *
     * @return string Dir name
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * Return the full path to file, including its name.
     *
     * @return string Full path to file, including its name.
     */
    public function getPath()
    {
        return $this->dir . '/' . $this->name;
    }

    /**
     * Write data to file.
     *
     * @param string $data The data to write
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     *
     * @throws WriteTempFileException Can't create a temp file
     */
    public function write($data)
    {
        if (@file_put_contents($this->getPath(), $data) === false) {
            throw new WriteTempFileException('Can\'t write to a temp file.');
        }

        return true;
    }

    /**
     * Read data from file.
     *
     * @return string File content
     *
     * @throws ReadTempFileException Can't read from a temp file
     */
    public function read()
    {
        $data = @file_get_contents($this->getPath());
        if ($data === false) {
            throw new ReadTempFileException('Can\'t read from a temp file.');
        }

        return $data;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->destroyFile();
    }

    /**
     * Create a temp file.
     *
     * @param string $dir File directory
     *
     * @return string Full path to file, including its name
     *
     * @throws CreateTempFileException Can't create a temp file
     */
    private function createFileWithTempName($dir)
    {
        $file = @tempnam($dir, '');
        if ($file === false) {
            throw new CreateTempFileException('Can\'t create a temp file.');
        }

        return $file;
    }

    /**
     * Create a file with the specified name.
     *
     * @param string $dir  File directory
     * @param string $name File name
     *
     * @return string Full path to file, including its name
     *
     * @throws CreateTempFileException Can't create a temp file
     */
    private function createFile($dir, $name)
    {
        $file = $dir . '/' . $name;

        if (@file_exists($file) === true) {
            throw new CreateTempFileException(
                'Can\'t create a temp file because it already exists'
            );
        }

        if (@touch($file) === false) {
            throw new CreateTempFileException('Can\'t create a temp file.');
        }

        return $file;
    }

    /**
     * Destroy file.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     *
     * @throws DestroyTempFileException Can't destroy a temp file
     */
    private function destroyFile()
    {
        if (!empty($this->name)) {
            if (@unlink($this->getPath()) === false) {
                throw new DestroyTempFileException('Can\'t destroy a temp file.');
            }
        }

        return true;
    }
}
