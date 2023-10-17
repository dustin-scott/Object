<?php

namespace ObjectStream\File\Exception;

use Exception;

class StreamMustBeOpenError extends Exception implements Error
{
    public function __construct()
    {
        parent::__construct("File stream must be opened.");
    }
}
