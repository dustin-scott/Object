<?php

namespace ObjectStream\File;

use ObjectStream\File;
use ObjectStream\File\Exception\ReadError;
use ObjectStream\File\Json\Exception\DecodeJsonError;
use ObjectStream\File\Json\Exception\SerializeJsonError;

class Json extends File
{
    /**
     * @throws DecodeJsonError
     * @throws ReadError
     */
    final public function decode(): array
    {
        $rawData = $this->readAll();
        $jsonData = json_decode($rawData, true);
        if ($jsonData === null) {
            throw new DecodeJsonError($this);
        }

        return $jsonData;
    }

    /**
     * @throws SerializeJsonError
     */
    final public function encode(array $data, int $flags = 0): string
    {
        $jsonString = json_encode($data, $flags);
        if ($jsonString === false) {
            throw new SerializeJsonError($data);
        }

        return $jsonString;
    }
}
