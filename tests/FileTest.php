<?php

declare(strict_types=1);

namespace Test\FileTest;

use ObjectStream\File as ObjectStreamFile;
use ObjectStream\File\Exception\PathInvalidError;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testInvalidPath(): void
    {
        $error = null;
        try {
            $file = new ObjectStreamFile('');
        } catch (PathInvalidError $e) {
            $error = $e;
        }
        $this->assertNotNull($error);
        $this->assertInstanceOf(PathInvalidError::class, $error);
    }
}
