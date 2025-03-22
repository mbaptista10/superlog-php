<?php

declare(strict_types=1);

namespace Superlog;

use Superlog\Contracts\LoggerContract;
use Superlog\Data\SuperlogData;

class Superlog implements LoggerContract
{
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

        match ($logData->level()) {
            'alert' => SuperlogSettings::getNewLogger('alert')->alert((string) $logData->toJson()),
            'critical' => SuperlogSettings::getNewLogger('critical')->critical((string) $logData->toJson()),
            'error' => SuperlogSettings::getNewLogger('error')->error((string) $logData->toJson()),
            'warning' => SuperlogSettings::getNewLogger('warning')->warning((string) $logData->toJson()),
            'info' => SuperlogSettings::getNewLogger('info')->info((string) $logData->toJson()),
            default => SuperlogSettings::getNewLogger('debug')->debug((string) $logData->toJson()),
        };

        foreach (SuperlogSettings::getObservers() as $observer) {
            $observer->logged($logData);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function alert(string|array $message, array $tags = []): void
    {
        if (SuperlogSettings::isDisabled()) {
            return;
        }

        $logData = SuperlogData::from(
            message: $message,
            tags: $tags,
            level: __FUNCTION__,
            application: SuperlogSettings::getApplication(),
            environment: SuperlogSettings::getEnvironment()
        );

        (new self)->log($logData);
    }

    /**
     * {@inheritdoc}
     */
    public static function critical(string|array $message, array $tags = []): void
    {
        if (SuperlogSettings::isDisabled()) {
            return;
        }

        $allowedLevels = ['debug', 'info', 'warning', 'error', __FUNCTION__];
        if (! SuperlogSettings::levelIsAllowed($allowedLevels)) {
            return;
        }

        $logData = SuperlogData::from(
            message: $message,
            tags: $tags,
            level: __FUNCTION__,
            application: SuperlogSettings::getApplication(),
            environment: SuperlogSettings::getEnvironment()
        );

        (new self)->log($logData);
    }

    /**
     * {@inheritdoc}
     */
    public static function error(string|array $message, array $tags = []): void
    {
        if (SuperlogSettings::isDisabled()) {
            return;
        }

        $allowedLevels = ['debug', 'info', 'warning', __FUNCTION__];
        if (! SuperlogSettings::levelIsAllowed($allowedLevels)) {
            return;
        }

        $logData = SuperlogData::from(
            message: $message,
            tags: $tags,
            level: __FUNCTION__,
            application: SuperlogSettings::getApplication(),
            environment: SuperlogSettings::getEnvironment()
        );

        (new self)->log($logData);
    }

    /**
     * {@inheritdoc}
     */
    public static function warning(string|array $message, array $tags = []): void
    {
        if (SuperlogSettings::isDisabled()) {
            return;
        }

        $allowedLevels = ['debug', 'info', __FUNCTION__];
        if (! SuperlogSettings::levelIsAllowed($allowedLevels)) {
            return;
        }

        $logData = SuperlogData::from(
            message: $message,
            tags: $tags,
            level: __FUNCTION__,
            application: SuperlogSettings::getApplication(),
            environment: SuperlogSettings::getEnvironment()
        );

        (new self)->log($logData);
    }

    /**
     * {@inheritdoc}
     */
    public static function info(string|array $message, array $tags = []): void
    {
        if (SuperlogSettings::isDisabled()) {
            return;
        }

        $allowedLevels = ['debug', __FUNCTION__];
        if (! SuperlogSettings::levelIsAllowed($allowedLevels)) {
            return;
        }

        $logData = SuperlogData::from(
            message: $message,
            tags: $tags,
            level: __FUNCTION__,
            application: SuperlogSettings::getApplication(),
            environment: SuperlogSettings::getEnvironment()
        );

        (new self)->log($logData);
    }

    /**
     * {@inheritdoc}
     */
    public static function debug(string|array $message, array $tags = []): void
    {
        if (SuperlogSettings::isDisabled()) {
            return;
        }

        $allowedLevels = [__FUNCTION__];
        if (! SuperlogSettings::levelIsAllowed($allowedLevels)) {
            return;
        }

        $logData = SuperlogData::from(
            message: $message,
            tags: $tags,
            level: __FUNCTION__,
            application: SuperlogSettings::getApplication(),
            environment: SuperlogSettings::getEnvironment()
        );

        (new self)->log($logData);
    }

    /**
     * {@inheritdoc}
     */
    public static function raw(string $level, string|array $message, array $tags = []): void
    {
        if (SuperlogSettings::isDisabled()) {
            return;
        }

        match ($level) {
            'alert' => self::alert($message, $tags),
            'critical' => self::critical($message, $tags),
            'error' => self::error($message, $tags),
            'warning' => self::warning($message, $tags),
            'info' => self::info($message, $tags),
            default => self::debug($message, $tags),
        };
    }
}
