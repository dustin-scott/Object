<?php

namespace ObjectStream;

use ObjectStream\File\Exception\DeleteError;
use ObjectStream\File\Exception\FailedToWriteError;
use ObjectStream\File\Exception\PathInvalidError;
use ObjectStream\File\Exception\ReadError;
use ObjectStream\File\Exception\SaveError;
use ObjectStream\File\Exception\SeekError;
use ObjectStream\File\Exception\StreamCloseError;
use ObjectStream\File\Exception\StreamMustBeOpenError;
use ObjectStream\File\Exception\StreamOpenError;

class File
{
    private string $name;
    private string $directory;
    private mixed $stream = null;

    /**
     * @throws PathInvalidError
     */
    public function __construct(string $filePath)
    {
        $this->name = basename($filePath);
        $this->directory = dirname($filePath);

        if (empty($this->name)) {
            throw new PathInvalidError($filePath);
        }
    }

    final public function getFullPath(): string
    {
        return $this->directory . '/' . $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throws ReadError
     */
    final public function readAll(): string
    {
        $rawData = file_get_contents($this->getFullPath());
        if ($rawData === false) {
            throw new ReadError($this->getFullPath());
        }

        return $rawData;
    }

    /**
     * @throws SaveError
     */
    final public function save(string $data): void
    {
        if (file_put_contents($this->getFullPath(), $data) === false) {
            throw new SaveError($this->name, $this->directory);
        }
    }

    /**
     * @throws DeleteError
     */
    final public function delete(): void
    {
        $path = $this->getFullPath();
        if (file_exists($path)) {
            if (!unlink($path)) {
                throw new DeleteError($path);
            }
        }
    }

    /**
     * @throws StreamOpenError
     */
    final public function open(string $mode = 'r+'): void
    {
        $path = $this->getFullPath();
        if (touch($path) === false) {
            throw new StreamOpenError($path);
        }
        $this->stream = fopen($path, $mode);
        if ($this->stream === false) {
            throw new StreamOpenError($path);
        }
    }

    private function isStreamOpen(): bool
    {
        return $this->stream !== null;
    }

    /**
     * @throws StreamMustBeOpenError
     */
    private function assertOpenStream(): void
    {
        if (!$this->isStreamOpen()) {
            throw new StreamMustBeOpenError();
        }
    }

    /**
     * @throws StreamMustBeOpenError
     * @throws FailedToWriteError
     */
    public function write(string $data): void
    {
        $this->assertOpenStream();
        if (fputs($this->stream, $data) === false) {
            throw new FailedToWriteError($this->getFullPath());
        }
    }

    /**
     * @throws StreamMustBeOpenError
     * @throws SeekError
     */
    public function seek(int $position): void
    {
        $this->assertOpenStream();
        if (fseek($this->stream, $position) < 0) {
            throw new SeekError($position);
        }
    }

    /**
     * @throws StreamMustBeOpenError
     * @throws ReadError
     */
    public function read(int $maxBytes = (1000 * 1000)): ?string
    {
        $this->assertOpenStream();
        if (feof($this->stream)) {
            return null;
        }

        $data = fread($this->stream, $maxBytes);
        if ($data === false) {
            throw new ReadError($this->getFullPath());
        }
        return $data;
    }

    /**
     * @throws StreamMustBeOpenError
     * @throws ReadError
     */
    public function readLine(): ?string
    {
        $this->assertOpenStream();
        if (feof($this->stream)) {
            return null;
        }

        $data = fgets($this->stream);
        if ($data === false) {
            throw new ReadError($this->getFullPath());
        }
        return str_replace("\n", "", $data);
    }

    /**
     * @throws StreamCloseError
     */
    final public function close(): void
    {
        if ($this->stream === null) {
            return;
        }
        if (fclose($this->stream) === false) {
            throw new StreamCloseError($this->getFullPath());
        }
        $this->stream = null;
    }

    final public function exists(): bool
    {
        return file_exists($this->getFullPath());
    }

    final public function size(): int
    {
        $size = filesize($this->getFullPath());
        if ($size === false) {
            return 0;
        }

        return $size;
    }


    public function __destruct()
    {
        if ($this->stream !== null) {
            try {
                $this->close();
            } catch (StreamCloseError $e) {
                error_log($e);
            }
        }
    }
}
