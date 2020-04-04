<?php


namespace App\Actions;


class Result
{
    public array $body;

    public ?\Throwable $exception = null;

    private function __construct(array $body, ?\Throwable $exception = null)
    {
        $this->body = $body;
        $this->exception = $exception;
    }

    public static function success(array $body = [])
    {
        return new self($body);
    }

    public static function error(\Throwable $e)
    {
        return new self([], $e);
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getException(): ?\Throwable
    {
        return $this->exception;
    }
}
