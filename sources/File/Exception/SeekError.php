<?php

namespace ObjectStream\File\Exception;

use Exception;

class SeekError extends Exception implements Error
{
    public function __construct(int $position)
    {
        parent::__construct("Failed to seek to position: $position.");
    }
}
