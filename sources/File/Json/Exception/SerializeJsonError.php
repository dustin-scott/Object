<?php

namespace ObjectStream\File\Json\Exception;

use Exception;
use ObjectStream\File\Exception\Error;

class SerializeJsonError extends Exception implements Error
{
    public function __construct(array $record)
    {
        parent::__construct("Failed to serialize record: " . print_r($record, true));
    }
}
