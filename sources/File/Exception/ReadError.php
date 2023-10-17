<?php

namespace ObjectStream\File\Exception;

use Exception;

class ReadError extends Exception implements Error
{
    public function __construct(string $filePath)
    {
        parent::__construct("Failed to read file: $filePath.");
    }
}
