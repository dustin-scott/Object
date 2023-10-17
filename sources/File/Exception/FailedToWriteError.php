<?php

namespace ObjectStream\File\Exception;

use Exception;

class FailedToWriteError extends Exception implements Error
{
    public function __construct(string $filePath)
    {
        parent::__construct("Failed to write to file: $filePath.");
    }
}
