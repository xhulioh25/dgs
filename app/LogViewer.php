<?php

/*
 * This file is part of Laravel LogViewer.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use App\Log\Data;
use App\Log\Factory;
use App\Log\Filesystem;

class LogViewer
{
    /**
     * The factory instance.
     *
     */
    protected $factory;

    /**
     * The filesystem instance.
     *
     */
    protected $filesystem;

    /**
     * The data instance.
     *
     */
    protected $data;

    /**
     * Create a new instance
     *
     * @return void
     */
    public function __construct(Factory $factory, Filesystem $filesystem, Data $data)
    {
        $this->factory = $factory;
        $this->filesystem = $filesystem;
        $this->data = $data;
    }

    /**
     * Get the log data.
     *
     * @param string $date
     * @param string $level
     *
     * @return array
     */
    public function data($date, $level = 'all')
    {
        return $this->factory->make($date, $level)->data();
    }

    /**
     * Delete the log.
     *
     * @param string $date
     *
     * @return void
     */
    public function delete($date)
    {
        return $this->filesystem->delete($date);
    }

    /**
     * List the log files.
     *
     * @return string[]
     */
    public function logs()
    {
        $logs = array_reverse($this->filesystem->files());

        foreach ($logs as $index => $file) {
            $logs[$index] = preg_replace('/.*(\d{4}-\d{2}-\d{2}).*/', '$1', basename($file));
        }

        return $logs;
    }

    /**
     * Get the log levels.
     *
     * @return string[]
     */
    public function levels()
    {
        return $this->data->levels();
    }

    /**
     * Get the factory instance.
     *
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Get the filesystem instance.
     *
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * Get the data instance.
     *
     */
    public function getData()
    {
        return $this->data;
    }
}
