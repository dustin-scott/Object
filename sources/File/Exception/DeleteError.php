<?php

namespace ObjectStream\File\Exception;

use Exception;

class DeleteError extends Exception implements Error
{
    public function __construct(string $filePath)
    {
        parent::__construct("Failed to delete: $filePath.");
    }
}
