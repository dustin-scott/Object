<?php

namespace ObjectStream\File\Exception;

use Exception;

class SaveError extends Exception implements Error
{
    public function __construct(string $file, string $directory)
    {
        parent::__construct("File $file failed to save to $directory.");
    }
}
