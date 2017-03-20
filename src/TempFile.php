<?php

namespace TempFileService;

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
    private $name;

    /**
     * Constructor.
     *
     * @param string $fileDir Temp file directory
     */
    public function __construct($fileDir = '')
    {
        if (empty($fileDir)) {
            $fileDir = sys_get_temp_dir();
        }

        $file = $this->createFile($fileDir);

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
     * @throws \RuntimeException Can't create a temp file
     */
    public function write($data)
    {
        if (file_put_contents($this->getPath(), $data) !== false) {
            return true;
        }

        throw new \RuntimeException('Can\'t write to a temp file.');
    }

    /**
     * Read data from file.
     *
     * @return string File content
     *
     * @throws \RuntimeException Can't read from a temp file
     */
    public function read()
    {
        $data = file_get_contents($this->getPath());
        if ($data !== false) {
            return $data;
        }

        throw new \RuntimeException('Can\'t read from a temp file.');
    }

    /**
     * Destructor.
     *
     * @throws \RuntimeException Can't destroy a temp file
     */
    public function __destruct()
    {
        $this->destroyFile();
    }

    /**
     * Create file.
     *
     * @param string $dir File directory
     *
     * @return string Full path to file, including its name
     *
     * @throws \RuntimeException Can't create a temp file
     */
    private function createFile($dir)
    {
        $file = tempnam($dir, '');

        if (!file_exists($file)) {
            throw new \RuntimeException('Can\'t create a temp file.');
        }

        return $file;
    }

    /**
     * Destroy file.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     *
     * @throws \RuntimeException Can't destroy a temp file
     */
    private function destroyFile()
    {
        if (unlink($this->getPath()) === true) {
            return true;
        }

        throw new \RuntimeException('Can\'t destroy a temp file.');
    }
}
