<?php

declare(strict_types=1);

namespace Superlog;

use Superlog\Contracts\LoggerContract;
use Superlog\Data\SuperlogData;

class Superlog implements LoggerContract
{
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

        SuperlogSettings::getNewLogger()->critical((string) $logData->toJson());
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

        SuperlogSettings::getNewLogger()->error((string) $logData->toJson());
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

        SuperlogSettings::getNewLogger()->warning((string) $logData->toJson());
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

        SuperlogSettings::getNewLogger()->info((string) $logData->toJson());
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

        SuperlogSettings::getNewLogger()->debug((string) $logData->toJson());
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
