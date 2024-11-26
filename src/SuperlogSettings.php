<?php

declare(strict_types=1);

namespace Superlog;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use RuntimeException;

final class SuperlogSettings
{
    /**
     * Log level of the application.
     */
    private static string $logLevel = 'debug';

    /**
     * Channel name for the logger.
     *
     * @var string|resource
     */
    private static $channel = 'stdout';

    /**
     * Application name.
     */
    private static string $application = '';

    /**
     * Environment name.
     */
    private static string $environment = '';

    /**
     * Set the log level.
     */
    public static function setLogLevel(string $logLevel): void
    {
        self::$logLevel = $logLevel;
    }

    /**
     * Get the log level.
     */
    public static function getLogLevel(): string
    {
        return self::$logLevel;
    }

    /**
     * Set the channel.
     *
     * @param  string|resource  $channel
     */
    public static function setChannel($channel): void
    {
        self::$channel = $channel;
    }

    /**
     * Get the channel.
     *
     * @return string|resource
     */
    public static function getChannel()
    {
        return self::$channel;
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
     * Returns the configured logger instance.
     * Creates the logger if it has not been initialized yet.
     */
    public static function getNewLogger(): Logger
    {
        self::validate();
        $loggerName = self::getApplication() . '-' . 'logger';
        $logger = new Logger($loggerName);

        $logger->pushHandler(self::getNewStreamHandler());

        return $logger;
    }

    /**
     * Set the stream handler for the logger.
     */
    private static function getNewStreamHandler(): StreamHandler
    {
        $stream = self::getChannel() === 'stdout' ? 'php://stdout' : self::getChannel();
        $level = match (self::getLogLevel()) {
            'debug' => Level::Debug,
            'info' => Level::Info,
            'warning' => Level::Warning,
            'error' => Level::Error,
            default => Level::Critical,
        };

        $streamHandler = new StreamHandler($stream, $level);
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
        if (empty(self::$channel)) {
            throw new RuntimeException('Channel not set');
        }

        if (! isset(self::$application) || empty(self::$application)) {
            throw new RuntimeException('Application not set');
        }

        if (! isset(self::$environment) || empty(self::$environment)) {
            throw new RuntimeException('Environment not set');
        }
    }
}
