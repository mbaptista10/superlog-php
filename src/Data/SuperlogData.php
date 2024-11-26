<?php

declare(strict_types=1);

namespace Superlog\Data;

use Ramsey\Uuid\Uuid;

final readonly class SuperlogData
{
    /**
     * The log id
     */
    private string $logId;

    /**
     * The timestamp log
     */
    private string $timestamp;

    /**
     * Create a new instance of the class
     */
    public function __construct(
        /** @var string|array<mixed> */
        public string|array $message,
        /** @var array<int, string> */
        public array $tags,
        private string $level,
        public string $channel,
        public string $application,
        public string $environment,
    ) {
        $this->logId = Uuid::uuid4()->toString();
        $this->timestamp = date(DATE_ATOM);
    }

    /**
     * The factory method of this DTO
     *
     * @param  string|array<mixed>  $message
     * @param  array<int, string>  $tags
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
            'log_id:' . $this->logId,
        ];

        return json_encode(
            value: [
                'timestamp' => $this->timestamp,
                'level' => $this->level,
                'channel' => "{$this->channel}",
                'application' => $this->application,
                'environment' => $this->environment,
                'message' => $this->message,
                'log_id' => $this->logId,
                'tags' => $tags,
            ],
            depth: 1024
        );
    }
}
