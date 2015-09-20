<?php

namespace App\Log;

class Factory
{
    /**
     * The filesystem instance.
     *
     */
    protected $filesystem;

    /**
     * The log levels.
     *
     * @var array
     */
    protected $levels;

    /**
     * Create a new instance.
     *
     * @param string[]                                 $levels
     */
    public function __construct(Filesystem $filesystem, array $levels)
    {
        $this->filesystem = $filesystem;
        $this->levels = $levels;
    }

    /**
     * Get the log instance.
     *
     * @param string $date
     * @param string $level
     *
     */
    public function make($date, $level = 'all')
    {
        $raw = $this->filesystem->read($date);
        $levels = $this->levels;

        return new Log($raw, $levels, $level);
    }

    /**
     * Get the filesystem instance.
     *
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }
}
