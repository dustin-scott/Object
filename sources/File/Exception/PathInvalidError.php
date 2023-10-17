<?php

namespace ObjectStream\File\Exception;

use Exception;

class PathInvalidError extends Exception implements Error
{
    public function __construct(string $filePath)
    {
        parent::__construct("An invalid file path was provided: $filePath.");
    }
}
