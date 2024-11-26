<?php

declare(strict_types=1);

namespace Superlog\Contracts;

interface LoggerContract
{
    /**
     * Handle logic logging with "critical" level
     *
     * @param  string|array<mixed>  $message
     * @param  array<int, string>  $tags
     */
    public static function critical(string|array $message, array $tags = []): void;

    /**
     * Handle logic logging with "error" level
     *
     * @param  string|array<mixed>  $message
     * @param  array<int, string>  $tags
     */
    public static function error(string|array $message, array $tags = []): void;

    /**
     * Handle logic logging with "warning" leve
     *
     * @param  string|array<mixed>  $message
     * @param  array<int, string>  $tags
     */
    public static function warning(string|array $message, array $tags = []): void;

    /**
     * Handle logic logging with "info" level
     *
     * @param  string|array<mixed>  $message
     * @param  array<int, string>  $tags
     */
    public static function info(string|array $message, array $tags = []): void;

    /**
     * Handle logic logging with "debug" level
     *
     * @param  string|array<mixed>  $message
     * @param  array<int, string>  $tags
     */
    public static function debug(string|array $message, array $tags = []): void;
}
