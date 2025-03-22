<?php

declare(strict_types=1);

namespace Superlog;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use RuntimeException;
use Superlog\Contracts\LoggerObserverContract;
use Superlog\Observers\CustomTracerObserver;
use Superlog\Observers\DatadogTracerObserver;

final class SuperlogSettings
{
    /**
     * Log level of the application.
     */
    private static string $logLevel = 'debug';

    /**
     * Application name.
     */
    private static string $application = '';

    /**
     * Environment name.
     */
    private static string $environment = '';

    /**
     * Indicates if the logger is disabled.
     */
    private static bool $disabled = false;

    /**
     * Observers for the logger.
     *
     * @var array<LoggerObserverContract>
     */
    private static array $observers = [];

    /**
     * The stream resource for the logger.
     *
     * @var resource|string
     */
    private static $stream = 'stdout';

    /**
     * Set the log level.
     */
    public static function setLogLevel(string $logLevel): void
    {
        self::$logLevel = mb_strtolower($logLevel);
    }

    /**
     * Get the log level.
     */
    public static function getLogLevel(): string
    {
        return self::$logLevel;
    }

    /**
     * Set the application name.
     */
    public static function setApplication(string $application): void
    {
        self::$application = $application;
    }

    /**
     * Get the application name.
     */
    public static function getApplication(): string
    {
        return self::$application;
    }

    /**
     * Set the environment name.
     */
    public static function setEnvironment(string $environment): void
    {
        self::$environment = $environment;
    }

    /**
     * Get the environment name.
     */
    public static function getEnvironment(): string
    {
        return self::$environment;
    }

    /**
     * Get the stream resource
     *
     * @return resource|string
     */
    public static function getStream()
    {
        if (is_resource(self::$stream)) {
            return self::$stream;
        }

        if (self::$stream === 'stdout') {
            return 'php://stdout';
        }

        if (self::$stream === 'stderr') {
            return 'php://stderr';
        }

        return self::$stream;
    }

    /**
     * Set the stream resource
     *
     * @param  resource|string  $stream
     */
    public static function setStream($stream): void
    {
        self::$stream = $stream;
    }

    /**
     * Returns the configured logger instance.
     * Creates the logger if it has not been initialized yet.
     */
    public static function getNewLogger(string $level): Logger
    {
        self::validate();
        self::validateLogLevel($level);
        $loggerName = self::getApplication().'-'.'logger';
        $logger = new Logger($loggerName);

        $logger->pushHandler(self::getNewStreamHandler($level));

        return $logger;
    }

    /**
     * Set the stream handler for the logger.
     */
    private static function getNewStreamHandler(string $level): StreamHandler
    {
        self::validateLogLevel($level);

        $monologLogLevel = match ($level) {
            'alert' => Level::Alert,
            'critical' => Level::Critical,
            'error' => Level::Error,
            'warning' => Level::Warning,
            'info' => Level::Info,
            default => Level::Debug,
        };

        if (in_array(self::getStream(), ['php://stdout', 'php://stderr'])) {
            match ($level) {
                'info', 'warning' => self::setStream('php://stdout'),
                'error', 'critical','alert' => self::setStream('php://stderr'),
                default => self::setStream('php://stdout'),
            };
        }

        $streamHandler = new StreamHandler(self::getStream(), $monologLogLevel);
        $streamHandler->setFormatter(new LineFormatter("%message%\n"));

        return $streamHandler;
    }

    /**
     * Validate the settings.
     *
     * @throws RuntimeException
     */
    private static function validate(): void
    {
        if (! isset(self::$application) || empty(self::$application)) {
            throw new RuntimeException('Application not set');
        }

        if (! isset(self::$environment) || empty(self::$environment)) {
            throw new RuntimeException('Environment not set');
        }

        if (! is_resource(self::$stream) && ! is_string(self::$stream)) {
            throw new RuntimeException('Stream not set or invalid');
        }

        self::validateLogLevel(self::getLogLevel());
    }

    /**
     * Validate the given log level.
     */
    private static function validateLogLevel(string $level): void
    {
        if (! in_array($level, ['debug', 'info', 'warning', 'error', 'critical', 'alert'])) {
            throw new RuntimeException('Invalid log level');
        }
    }

    /**
     * Validate and check if the configured log level is allowed.
     *
     * @param  array<string>  $allowedLevels
     */
    public static function levelIsAllowed(array $allowedLevels): bool
    {
        self::validateLogLevel(self::getLogLevel());

        return in_array(self::getLogLevel(), $allowedLevels);
    }

    /**
     * Add observer to the logger.
     */
    public static function addObserver(LoggerObserverContract $observer): void
    {
        self::$observers[] = $observer;
    }

    /**
     * Clear the observers
     */
    public static function clearObservers(): void
    {
        self::$observers = [];
    }

    /**
     * Get the observers for the logger.
     *
     * @return array<LoggerObserverContract>
     */
    public static function getObservers(): array
    {
        return self::$observers;
    }

    /**
     * Add the custom tracer observer.
     */
    public static function useCustomTracerObserver(): void
    {
        $observer = new CustomTracerObserver;
        self::addObserver($observer);
    }

    /**
     * Add the datadog tracer observer.
     */
    public static function useDatadogTracerObserver(): void
    {
        $observer = new DatadogTracerObserver;
        self::addObserver($observer);
    }

    /**
     * Disable the logger when the give expression is true
     */
    public static function disableWhen(bool $disabled): void
    {
        self::$disabled = $disabled;
    }

    /**
     * Check if the logger is disabled.
     */
    public static function isDisabled(): bool
    {
        return self::$disabled;
    }
}
