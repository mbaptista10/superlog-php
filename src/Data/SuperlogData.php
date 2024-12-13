<?php

declare(strict_types=1);

namespace Superlog\Data;

use DateTime;
use DateTimeZone;
use Ramsey\Uuid\Uuid;

final class SuperlogData
{
    /**
     * The log id
     */
    public string $logId;

    /**
     * The timestamp log
     */
    public string $timestamp;

    /**
     * The message to log
     *
     * @var array<mixed>
     */
    public array $message;

    /**
     * Create a new instance of the class
     *
     * @param  array<mixed>  $message
     */
    public function __construct(
        /** @var string|array<mixed> */
        string|array $message,
        /** @var array<mixed, string> */
        public readonly array $tags,
        public readonly string $level,
        public readonly string $channel,
        public readonly string $application,
        public readonly string $environment,
    ) {
        $this->logId = Uuid::uuid4()->toString();
        $now = new DateTime('now', new DateTimeZone('UTC'));
        $this->timestamp = $now->format(DATE_RFC3339_EXTENDED);
        $this->message = $this->formatMessage($message);
    }

    /**
     * The factory method of this DTO
     *
     * @param  string|array<mixed>  $message
     * @param  array<mixed, string>  $tags
     * @param  string|resource  $channel
     */
    public static function from(
        string|array $message,
        array $tags,
        string $level,
        $channel,
        string $application,
        string $environment,
    ): self {
        return new self(
            message: $message,
            tags: $tags,
            level: $level,
            channel: "{$channel}",
            application: $application,
            environment: $environment,
        );
    }

    /**
     * Transform the object in a JSON string
     */
    public function toJson(): bool|string
    {
        $tags = [
            ...$this->tags,
            'log_id' => $this->logId,
        ];

        return json_encode(
            value: [
                'timestamp' => $this->timestamp,
                'level' => $this->level,
                'channel' => $this->channel,
                'application' => $this->application,
                'environment' => $this->environment,
                'message' => json_encode(value: $this->message, depth: 1024),
                'tags' => $tags,
            ],
            depth: 1024
        );
    }

    /**
     * Format a message into an array.
     *
     * @param  string|array<mixed>  $message
     * @return array<mixed>
     */
    private function formatMessage(string|array $message): array
    {
        if (is_string($message)) {
            return [
                'description' => $message,
            ];
        }

        return $message;
    }

    /**
     * Append a message to the current message.
     *
     * @param  string|array<mixed>  $message
     */
    public function appendToMessage(string|array $message): void
    {
        $message = is_string($message) ? ["{$message}" => $message] : $message;

        $this->message = [
            ...$this->message,
            ...$message,
        ];
    }
}
