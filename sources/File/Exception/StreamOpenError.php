<?php

namespace ObjectStream\File\Exception;

use Exception;

class StreamOpenError extends Exception implements Error
{
    public function __construct(string $filePath)
    {
        parent::__construct("Failed to open stream: $filePath.");
    }
}
