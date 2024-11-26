<?php

declare(strict_types=1);

namespace Superlog;

use Superlog\Contracts\LoggerContract;
use Superlog\Data\SuperlogData;

class Superlog implements LoggerContract
{
    /**
     * Superlog constructor.
     *
     * Initializes the logger with the provided SuperlogData.
     */
    public function __construct(
        private readonly SuperlogData $logData
    ) {
        //
    }

    /**
     * Logs a message based on its specified level.
     *
     * This method routes the log data to the appropriate logging method
     * according to the level defined in the SuperlogData object. Before and
     * after the logging process, it notifies registered observers about the
     * logging lifecycle through `logging` and `logged` events, respectively.
     */
    public function log(SuperlogData $logData): void
    {
        foreach (SuperlogSettings::getObservers() as $observer) {
            $observer->logging($logData);
        }

        match ($logData->level) {
            'critical' => SuperlogSettings::getNewLogger()->critical((string) $logData->toJson()),
            'error' => SuperlogSettings::getNewLogger()->error((string) $logData->toJson()),
            'warning' => SuperlogSettings::getNewLogger()->warning((string) $logData->toJson()),
            'info' => SuperlogSettings::getNewLogger()->info((string) $logData->toJson()),
            'debug' => SuperlogSettings::getNewLogger()->debug((string) $logData->toJson()),
        };

        foreach (SuperlogSettings::getObservers() as $observer) {
            $observer->logged($logData);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function critical(string|array $message, array $tags = []): void
    {
        $formattedMessage = self::formatMessage($message);

        $logData = SuperlogData::from(
            message: $formattedMessage,
            tags: $tags,
            level: __FUNCTION__,
            channel: SuperlogSettings::getChannel(),
            application: SuperlogSettings::getApplication(),
            environment: SuperlogSettings::getEnvironment()
        );

        (new self($logData))->log($logData);
    }

    /**
     * {@inheritdoc}
     */
    public static function error(string|array $message, array $tags = []): void
    {
        $allowedLevels = ['debug', 'info', 'warning', __FUNCTION__];
        if (! in_array(SuperlogSettings::getLogLevel(), $allowedLevels)) {
            return;
        }

        $formattedMessage = self::formatMessage($message);

        $logData = SuperlogData::from(
            message: $formattedMessage,
            tags: $tags,
            level: __FUNCTION__,
            channel: SuperlogSettings::getChannel(),
            application: SuperlogSettings::getApplication(),
            environment: SuperlogSettings::getEnvironment()
        );

        (new self($logData))->log($logData);
    }

    /**
     * {@inheritdoc}
     */
    public static function warning(string|array $message, array $tags = []): void
    {
        $allowedLevels = ['debug', 'info', __FUNCTION__];
        if (! in_array(SuperlogSettings::getLogLevel(), $allowedLevels)) {
            return;
        }

        $formattedMessage = self::formatMessage($message);

        $logData = SuperlogData::from(
            message: $formattedMessage,
            tags: $tags,
            level: __FUNCTION__,
            channel: SuperlogSettings::getChannel(),
            application: SuperlogSettings::getApplication(),
            environment: SuperlogSettings::getEnvironment()
        );

        (new self($logData))->log($logData);
    }

    /**
     * {@inheritdoc}
     */
    public static function info(string|array $message, array $tags = []): void
    {
        $allowedLevels = ['debug', __FUNCTION__];
        if (! in_array(SuperlogSettings::getLogLevel(), $allowedLevels)) {
            return;
        }

        $formattedMessage = self::formatMessage($message);

        $logData = SuperlogData::from(
            message: $formattedMessage,
            tags: $tags,
            level: __FUNCTION__,
            channel: SuperlogSettings::getChannel(),
            application: SuperlogSettings::getApplication(),
            environment: SuperlogSettings::getEnvironment()
        );

        (new self($logData))->log($logData);
    }

    /**
     * {@inheritdoc}
     */
    public static function debug(string|array $message, array $tags = []): void
    {
        $allowedLevels = [__FUNCTION__];
        if (! in_array(SuperlogSettings::getLogLevel(), $allowedLevels)) {
            return;
        }

        $formattedMessage = self::formatMessage($message);

        $logData = SuperlogData::from(
            message: $formattedMessage,
            tags: $tags,
            level: __FUNCTION__,
            channel: SuperlogSettings::getChannel(),
            application: SuperlogSettings::getApplication(),
            environment: SuperlogSettings::getEnvironment()
        );

        (new self($logData))->log($logData);
    }

    /**
     * Format a message into an array.
     *
     * @param  string|array<mixed>  $message  The message to format.
     * @return array<mixed> The formatted message.
     */
    private static function formatMessage(string|array $message): array
    {
        if (is_string($message)) {
            return [
                'description' => $message,
            ];
        }

        return $message;
    }
}
