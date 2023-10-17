<?php

namespace ObjectStream\File\Json\Exception;

use Exception;
use ObjectStream\File;

class DecodeJsonError extends Exception implements File\Exception\Error
{
    public function __construct(File $jsonFile)
    {
        parent::__construct("Failed to decode json from file: " . $jsonFile->getFullPath() . '.');
    }
}
