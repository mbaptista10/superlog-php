<?php

declare(strict_types=1);

namespace Superlog\Contracts;

interface LoggerContract
{
    /**
     * Handle logic logging with "alert" level
     *
     * @param  string|array<mixed>  $message
     * @param  array<mixed, string>  $tags
     */
    public static function alert(string|array $message, array $tags = []): void;

    /**
     * Handle logic logging with "critical" level
     *
     * @param  string|array<mixed>  $message
     * @param  array<mixed, string>  $tags
     */
    public static function critical(string|array $message, array $tags = []): void;

    /**
     * Handle logic logging with "error" level
     *
     * @param  string|array<mixed>  $message
     * @param  array<mixed, string>  $tags
     */
    public static function error(string|array $message, array $tags = []): void;

    /**
     * Handle logic logging with "warning" leve
     *
     * @param  string|array<mixed>  $message
     * @param  array<mixed, string>  $tags
     */
    public static function warning(string|array $message, array $tags = []): void;

    /**
     * Handle logic logging with "info" level
     *
     * @param  string|array<mixed>  $message
     * @param  array<mixed, string>  $tags
     */
    public static function info(string|array $message, array $tags = []): void;

    /**
     * Handle logic logging with "debug" level
     *
     * @param  string|array<mixed>  $message
     * @param  array<mixed, string>  $tags
     */
    public static function debug(string|array $message, array $tags = []): void;

    /**
     * Logs a message with a specified log level.
     *
     * This method allows logging messages dynamically by specifying the log level
     * as a parameter. It routes the message to the appropriate static method
     * (`alert`, `critical`, `error`, `warning`, `info`, or `debug`) based on the level
     * provided. If an unsupported log level is specified, it defaults to the
     * `critical` level.
     *
     * @param  string|array<mixed>  $message
     * @param  array<mixed,  string>  $tags
     */
    public static function raw(string $level, string|array $message, array $tags = []): void;
}
