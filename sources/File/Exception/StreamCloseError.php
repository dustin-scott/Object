<?php

namespace ObjectStream\File\Exception;

use Exception;

class StreamCloseError extends Exception implements Error
{
    public function __construct(string $filePath)
    {
        parent::__construct("Failed to close stream to file: $filePath.");
    }
}
