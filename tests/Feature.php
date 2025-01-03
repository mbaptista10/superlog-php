<?php

use Superlog\Contracts\LoggerObserverContract;
use Superlog\Data\SuperlogData;
use Superlog\Superlog;
use Superlog\SuperlogSettings;

$logInMemory = function ($logCallback): array {
    $stream = fopen('php://memory', 'a+');
    SuperlogSettings::setChannel('channel');
    SuperlogSettings::setEnvironment('testing');
    SuperlogSettings::setApplication('application');
    SuperlogSettings::setStream($stream);

    $logCallback();

    fseek($stream, 0);
    $stringOutput = fread($stream, 1024);
    $jsonOutput = json_decode($stringOutput, true);
    fclose($stream);

    return [
        'string_output' => $stringOutput,
        'json_output' => $jsonOutput,
    ];
};

describe('validate', function (): void {
    it('should throw exception when channel is empty with critical level', function (): void {
        SuperlogSettings::setChannel('');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::critical('foo'))->toThrow(RuntimeException::class, 'Channel not set');
    });

    it('should throw exception when application is empty with critical level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::critical('foo'))->toThrow(RuntimeException::class, 'Application not set');
    });

    it('should throw exception when environment is empty with critical level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::critical('foo'))->toThrow(RuntimeException::class, 'Environment not set');
    });

    it('should throw exception when channel is empty with error level', function (): void {
        SuperlogSettings::setChannel('');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::error('foo'))->toThrow(RuntimeException::class, 'Channel not set');
    });

    it('should throw exception when application is empty with error level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::error('foo'))->toThrow(RuntimeException::class, 'Application not set');
    });

    it('should throw exception when environment is empty with error level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::error('foo'))->toThrow(RuntimeException::class, 'Environment not set');
    });

    it('should throw exception when channel is empty with warning level', function (): void {
        SuperlogSettings::setChannel('');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::warning('foo'))->toThrow(RuntimeException::class, 'Channel not set');
    });

    it('should throw exception when application is empty with warning level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::warning('foo'))->toThrow(RuntimeException::class, 'Application not set');
    });

    it('should throw exception when environment is empty with warning level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::warning('foo'))->toThrow(RuntimeException::class, 'Environment not set');
    });

    it('should throw exception when channel is empty with info level', function (): void {
        SuperlogSettings::setChannel('');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::info('foo'))->toThrow(RuntimeException::class, 'Channel not set');
    });

    it('should throw exception when application is empty with info level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::info('foo'))->toThrow(RuntimeException::class, 'Application not set');
    });

    it('should throw exception when environment is empty with info level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::info('foo'))->toThrow(RuntimeException::class, 'Environment not set');
    });

    it('should throw exception when channel is empty with debug level', function (): void {
        SuperlogSettings::setChannel('');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::debug('foo'))->toThrow(RuntimeException::class, 'Channel not set');
    });

    it('should throw exception when application is empty with debug level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::debug('foo'))->toThrow(RuntimeException::class, 'Application not set');
    });

    it('should throw exception when environment is empty with debug level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::debug('foo'))->toThrow(RuntimeException::class, 'Environment not set');
    });

    it('should throw exception when stream is empty with critical level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(null);

        expect(fn () => Superlog::critical('foo'))->toThrow(RuntimeException::class, 'Stream not set');
    });

    it('should throw exception when stream is empty with error level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(null);

        expect(fn () => Superlog::error('foo'))->toThrow(RuntimeException::class, 'Stream not set');
    });

    it('should throw exception when stream is empty with warning level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(null);

        expect(fn () => Superlog::warning('foo'))->toThrow(RuntimeException::class, 'Stream not set');
    });

    it('should throw exception when stream is empty with info level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(null);

        expect(fn () => Superlog::info('foo'))->toThrow(RuntimeException::class, 'Stream not set');
    });

    it('should throw exception when stream is empty with debug level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(null);

        expect(fn () => Superlog::debug('foo'))->toThrow(RuntimeException::class, 'Stream not set');
    });

    it('not throw exception when channel, application, environment and stream is not empty with critical level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::critical('foo'))->not->toThrow(RuntimeException::class);
    });

    it('not throw exception when channel, application, environment and stream is not empty with error level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::error('foo'))->not->toThrow(RuntimeException::class);
    });

    it('not throw exception when channel, application, environment and stream is not empty with warning level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::warning('foo'))->not->toThrow(RuntimeException::class);
    });

    it('not throw exception when channel, application, environment and stream is not empty with info level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::info('foo'))->not->toThrow(RuntimeException::class);
    });

    it('not throw exception when channel, application, environment and stream is not empty with debug level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');
        SuperlogSettings::setStream(fopen('php://memory', '+a'));

        expect(fn () => Superlog::debug('foo'))->not->toThrow(RuntimeException::class);
    });
});

describe('rfc', function () use ($logInMemory): void {
    it('should be rfc compliant with level critical', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::critical('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'tags']);
    });

    it('should be rfc compliant with level error', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::error('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'tags']);
    });

    it('should be rfc compliant with level warning', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::warning('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'tags']);
    });

    it('should be rfc compliant with level info', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::info('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'tags']);
    });

    it('should be rfc compliant with level debug', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::debug('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'tags']);
    });
});

describe('log level', function () use ($logInMemory): void {
    it('logs with critical level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::critical('foo'));

        expect($output['json_output']['level'])->toBe('critical');
    });

    it('logs with error level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::error('foo'));

        expect($output['json_output']['level'])->toBe('error');
    });

    it('logs with warning level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::warning('foo'));

        expect($output['json_output']['level'])->toBe('warning');
    });

    it('logs with info level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::info('foo'));

        expect($output['json_output']['level'])->toBe('info');
    });

    it('logs with debug level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::debug('foo'));

        expect($output['json_output']['level'])->toBe('debug');
    });
});

describe('log id', function () use ($logInMemory): void {
    it('logs with critical level should have a log id', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::critical('foo'));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];
        $logId = current($tags);

        expect($logId)->toBeUuid();
        expect($tags)->toMatchArray(['log_id' => $logId]);
    });

    it('logs with error level should have a log id', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::error('foo'));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];
        $logId = current($tags);

        expect($logId)->toBeUuid();
        expect($tags)->toMatchArray(['log_id' => $logId]);
    });

    it('logs with warning level should have a log id', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::warning('foo'));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];
        $logId = current($tags);

        expect($logId)->toBeUuid();
        expect($tags)->toMatchArray(['log_id' => $logId]);
    });

    it('logs with info level should have a log id', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::info('foo'));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];
        $logId = current($tags);

        expect($logId)->toBeUuid();
        expect($tags)->toMatchArray(['log_id' => $logId]);
    });

    it('logs with debug level should have a log id', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::debug('foo'));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];
        $logId = current($tags);

        expect($logId)->toBeUuid();
        expect($tags)->toMatchArray(['log_id' => $logId]);
    });
});

describe('log message', function () use ($logInMemory): void {
    it('logs with critical level should have a message in description key', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::critical('foo'));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toBeJson();
        expect($message)->toBe('{"description":"foo"}');
    });

    it('logs with error level should have a message in description key', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::error('foo'));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toBeJson();
        expect($message)->toBe('{"description":"foo"}');
    });

    it('logs with warning level should have a message in description key', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::warning('foo'));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toBeJson();
        expect($message)->toContain('"description":"foo"');
    });

    it('logs with info level should have a message in description key', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::info('foo'));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toBeJson();
        expect($message)->toBe('{"description":"foo"}');
    });

    it('logs with debug level should have a message in description key', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::debug('foo'));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toBeJson();
        expect($message)->toBe('{"description":"foo"}');
    });
});

describe('log tags', function () use ($logInMemory): void {
    it('logs with critical level should have tags', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::critical('foo', ['foo' => 'bar', 'baz' => 'qux']));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($tags)->toMatchArray(['foo' => 'bar', 'baz' => 'qux']);
    });

    it('logs with error level should have tags', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::critical('foo', ['foo' => 'bar', 'baz' => 'qux']));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($tags)->toMatchArray(['foo' => 'bar', 'baz' => 'qux']);
    });

    it('logs with warning level should have tags', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::critical('foo', ['foo' => 'bar', 'baz' => 'qux']));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($tags)->toMatchArray(['foo' => 'bar', 'baz' => 'qux']);
    });

    it('logs with info level should have tags', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::critical('foo', ['foo' => 'bar', 'baz' => 'qux']));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($tags)->toMatchArray(['foo' => 'bar', 'baz' => 'qux']);
    });

    it('logs with debug level should have tags', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::critical('foo', ['foo' => 'bar', 'baz' => 'qux']));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($tags)->toMatchArray(['foo' => 'bar', 'baz' => 'qux']);
    });
});

describe('log level filter', function () use ($logInMemory): void {
    it('should only show critical logs when the level is critical', function () use ($logInMemory): void {
        SuperlogSettings::setLogLevel('critical');
        $outputCritical = $logInMemory(fn () => Superlog::critical('foo'));
        $outputError = $logInMemory(fn () => Superlog::error('foo'));
        $outputWarning = $logInMemory(fn () => Superlog::warning('foo'));
        $outputInfo = $logInMemory(fn () => Superlog::info('foo'));
        $outputDebug = $logInMemory(fn () => Superlog::debug('foo'));

        expect($outputCritical['json_output'])->not->toBeNull();
        expect($outputCritical['string_output'])->not->toBeNull();
        expect($outputError['json_output'])->toBeNull();
        expect($outputError['string_output'])->toBeEmpty();
        expect($outputWarning['json_output'])->toBeNull();
        expect($outputWarning['string_output'])->toBeEmpty();
        expect($outputInfo['json_output'])->toBeNull();
        expect($outputInfo['string_output'])->toBeEmpty();
        expect($outputDebug['json_output'])->toBeNull();
        expect($outputDebug['string_output'])->toBeEmpty();
    });

    it('should only show critical and error logs when the level is error', function () use ($logInMemory): void {
        SuperlogSettings::setLogLevel('error');
        $outputCritical = $logInMemory(fn () => Superlog::critical('foo'));
        $outputError = $logInMemory(fn () => Superlog::error('foo'));
        $outputWarning = $logInMemory(fn () => Superlog::warning('foo'));
        $outputInfo = $logInMemory(fn () => Superlog::info('foo'));
        $outputDebug = $logInMemory(fn () => Superlog::debug('foo'));

        expect($outputCritical['json_output'])->not->toBeNull();
        expect($outputCritical['string_output'])->not->toBeNull();
        expect($outputError['json_output'])->not->toBeNull();
        expect($outputError['string_output'])->not->toBeEmpty();
        expect($outputWarning['json_output'])->toBeNull();
        expect($outputWarning['string_output'])->toBeEmpty();
        expect($outputInfo['json_output'])->toBeNull();
        expect($outputInfo['string_output'])->toBeEmpty();
        expect($outputDebug['json_output'])->toBeNull();
        expect($outputDebug['string_output'])->toBeEmpty();
    });

    it('should only show critical, error and warning logs when the level is warning', function () use ($logInMemory): void {
        SuperlogSettings::setLogLevel('warning');
        $outputCritical = $logInMemory(fn () => Superlog::critical('foo'));
        $outputError = $logInMemory(fn () => Superlog::error('foo'));
        $outputWarning = $logInMemory(fn () => Superlog::warning('foo'));
        $outputInfo = $logInMemory(fn () => Superlog::info('foo'));
        $outputDebug = $logInMemory(fn () => Superlog::debug('foo'));

        expect($outputCritical['json_output'])->not->toBeNull();
        expect($outputCritical['string_output'])->not->toBeNull();
        expect($outputError['json_output'])->not->toBeNull();
        expect($outputError['string_output'])->not->toBeEmpty();
        expect($outputWarning['json_output'])->not->toBeNull();
        expect($outputWarning['string_output'])->not->toBeEmpty();
        expect($outputInfo['json_output'])->toBeNull();
        expect($outputInfo['string_output'])->toBeEmpty();
        expect($outputDebug['json_output'])->toBeNull();
        expect($outputDebug['string_output'])->toBeEmpty();
    });

    it('should only show critical, error, warning and info logs when the level is info', function () use ($logInMemory): void {
        SuperlogSettings::setLogLevel('info');
        $outputCritical = $logInMemory(fn () => Superlog::critical('foo'));
        $outputError = $logInMemory(fn () => Superlog::error('foo'));
        $outputWarning = $logInMemory(fn () => Superlog::warning('foo'));
        $outputInfo = $logInMemory(fn () => Superlog::info('foo'));
        $outputDebug = $logInMemory(fn () => Superlog::debug('foo'));

        expect($outputCritical['json_output'])->not->toBeNull();
        expect($outputCritical['string_output'])->not->toBeNull();
        expect($outputError['json_output'])->not->toBeNull();
        expect($outputError['string_output'])->not->toBeEmpty();
        expect($outputWarning['json_output'])->not->toBeNull();
        expect($outputWarning['string_output'])->not->toBeEmpty();
        expect($outputInfo['json_output'])->not->toBeNull();
        expect($outputInfo['string_output'])->not->toBeEmpty();
        expect($outputDebug['json_output'])->toBeNull();
        expect($outputDebug['string_output'])->toBeEmpty();
    });

    it('should show all levels logs when the level is debug', function () use ($logInMemory): void {
        SuperlogSettings::setLogLevel('debug');
        $outputCritical = $logInMemory(fn () => Superlog::critical('foo'));
        $outputError = $logInMemory(fn () => Superlog::error('foo'));
        $outputWarning = $logInMemory(fn () => Superlog::warning('foo'));
        $outputInfo = $logInMemory(fn () => Superlog::info('foo'));
        $outputDebug = $logInMemory(fn () => Superlog::debug('foo'));

        expect($outputCritical['json_output'])->not->toBeNull();
        expect($outputCritical['string_output'])->not->toBeNull();
        expect($outputError['json_output'])->not->toBeNull();
        expect($outputError['string_output'])->not->toBeEmpty();
        expect($outputWarning['json_output'])->not->toBeNull();
        expect($outputWarning['string_output'])->not->toBeEmpty();
        expect($outputInfo['json_output'])->not->toBeNull();
        expect($outputInfo['string_output'])->not->toBeEmpty();
        expect($outputDebug['json_output'])->not->toBeNull();
        expect($outputDebug['string_output'])->not->toBeEmpty();
    });
});

describe('default values', function () use ($logInMemory): void {
    beforeEach(function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
    });

    it('should have default values when level is critical', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::critical('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput['channel'])->toContain('channel');
        expect($jsonOutput['application'])->toBe('application');
        expect($jsonOutput['environment'])->toBe('testing');
    });

    it('should have default values when level is error', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::error('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput['channel'])->toContain('channel');
        expect($jsonOutput['application'])->toBe('application');
        expect($jsonOutput['environment'])->toBe('testing');
    });

    it('should have default values when level is warning', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::warning('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput['channel'])->toContain('channel');
        expect($jsonOutput['application'])->toBe('application');
        expect($jsonOutput['environment'])->toBe('testing');
    });

    it('should have default values when level is info', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::info('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput['channel'])->toContain('channel');
        expect($jsonOutput['application'])->toBe('application');
        expect($jsonOutput['environment'])->toBe('testing');
    });

    it('should have default values when level is debug', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::debug('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput['channel'])->toContain('channel');
        expect($jsonOutput['application'])->toBe('application');
        expect($jsonOutput['environment'])->toBe('testing');
    });
});

describe('log message with object', function () use ($logInMemory): void {
    it('should be able to log message object with critical level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::critical([
            'any_data' => 'foo',
            'any_other_data' => 'bar',
            'nested_data' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toBeJson();
        expect($message)->toBe('{"any_data":"foo","any_other_data":"bar","nested_data":{"foo":"bar","baz":"qux"}}');
    });

    it('should be able to log message object with error level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::error([
            'any_data' => 'foo',
            'any_other_data' => 'bar',
            'nested_data' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toBeJson();
        expect($message)->toBe('{"any_data":"foo","any_other_data":"bar","nested_data":{"foo":"bar","baz":"qux"}}');
    });

    it('should be able to log message object with warning level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::warning([
            'any_data' => 'foo',
            'any_other_data' => 'bar',
            'nested_data' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toBeJson();
        expect($message)->toBe('{"any_data":"foo","any_other_data":"bar","nested_data":{"foo":"bar","baz":"qux"}}');
    });

    it('should be able to log message object with info level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::info([
            'any_data' => 'foo',
            'any_other_data' => 'bar',
            'nested_data' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toBeJson();
        expect($message)->toBe('{"any_data":"foo","any_other_data":"bar","nested_data":{"foo":"bar","baz":"qux"}}');
    });

    it('should be able to log message object with debug level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::debug([
            'any_data' => 'foo',
            'any_other_data' => 'bar',
            'nested_data' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toBeJson();
        expect($message)->toBe('{"any_data":"foo","any_other_data":"bar","nested_data":{"foo":"bar","baz":"qux"}}');
    });
});

describe('observers', function () use ($logInMemory): void {
    it('notifies observers about the logging lifecycle with log level critical', function () use ($logInMemory): void {
        $observer = new class implements LoggerObserverContract
        {
            /** @var array<SuperlogData> */
            public array $loggingEvents = [];

            /** @var array<SuperlogData> */
            public array $loggedEvents = [];

            public function logging(SuperlogData $logData): void
            {
                $logData->appendToMessage([
                    'any_data' => [
                        'id' => 'any-id',
                        'name' => 'any-name',
                    ],
                ]);
                $logData->appendToMessage('bar');
                $this->loggingEvents[] = $logData;
            }

            public function logged(SuperlogData $logData): void
            {
                $this->loggedEvents[] = $logData;
            }
        };
        SuperlogSettings::addObserver($observer);

        $logInMemory(fn () => Superlog::critical('foo'));

        expect($observer->loggingEvents)->toHaveCount(1);
        expect($observer->loggedEvents)->toHaveCount(1);
        foreach ($observer->loggingEvents as $logData) {
            expect($logData->level)->toBe('critical');
            expect($logData->message)->toContain('foo');
            expect($logData->message)->toHaveKeys(['any_data', 'any_data.id', 'any_data.name', 'bar']);
            expect($logData->message['any_data']['id'])->toContain('any-id');
            expect($logData->message['any_data']['name'])->toContain('any-name');
            expect($logData->message['bar'])->toBe('bar');
            expect($logData)->toHaveProperties(['timestamp', 'channel', 'application', 'environment', 'logId', 'tags']);
        }
        foreach ($observer->loggedEvents as $logData) {
            expect($logData->level)->toBe('critical');
            expect($logData->message)->toContain('foo');
            expect($logData)->toHaveProperties(['timestamp', 'channel', 'application', 'environment', 'logId', 'tags']);
        }
    });

    it('notifies observers about the logging lifecycle with log level error', function () use ($logInMemory): void {
        $observer = new class implements LoggerObserverContract
        {
            /** @var array<SuperlogData> */
            public array $loggingEvents = [];

            /** @var array<SuperlogData> */
            public array $loggedEvents = [];

            public function logging(SuperlogData $logData): void
            {
                $logData->appendToMessage([
                    'any_data' => [
                        'id' => 'any-id',
                        'name' => 'any-name',
                    ],
                ]);
                $this->loggingEvents[] = $logData;
            }

            public function logged(SuperlogData $logData): void
            {
                $this->loggedEvents[] = $logData;
            }
        };
        SuperlogSettings::addObserver($observer);

        $logInMemory(fn () => Superlog::error('foo'));

        expect($observer->loggingEvents)->toHaveCount(1);
        expect($observer->loggedEvents)->toHaveCount(1);
        foreach ($observer->loggingEvents as $logData) {
            expect($logData->level)->toBe('error');
            expect($logData->message)->toContain('foo');
            expect($logData->message)->toHaveKeys(['any_data', 'any_data.id', 'any_data.name']);
            expect($logData->message['any_data']['id'])->toContain('any-id');
            expect($logData->message['any_data']['name'])->toContain('any-name');
            expect($logData)->toHaveProperties(['timestamp', 'channel', 'application', 'environment', 'logId', 'tags']);
        }
        foreach ($observer->loggedEvents as $logData) {
            expect($logData->level)->toBe('error');
            expect($logData->message)->toContain('foo');
            expect($logData)->toHaveProperties(['timestamp', 'channel', 'application', 'environment', 'logId', 'tags']);
        }
    });

    it('notifies observers about the logging lifecycle with log level warning', function () use ($logInMemory): void {
        $observer = new class implements LoggerObserverContract
        {
            /** @var array<SuperlogData> */
            public array $loggingEvents = [];

            /** @var array<SuperlogData> */
            public array $loggedEvents = [];

            public function logging(SuperlogData $logData): void
            {
                $logData->appendToMessage([
                    'any_data' => [
                        'id' => 'any-id',
                        'name' => 'any-name',
                    ],
                ]);
                $logData->appendToMessage('bar');
                $this->loggingEvents[] = $logData;
            }

            public function logged(SuperlogData $logData): void
            {
                $this->loggedEvents[] = $logData;
            }
        };
        SuperlogSettings::addObserver($observer);

        $logInMemory(fn () => Superlog::warning('foo'));

        expect($observer->loggingEvents)->toHaveCount(1);
        expect($observer->loggedEvents)->toHaveCount(1);
        foreach ($observer->loggingEvents as $logData) {
            expect($logData->level)->toBe('warning');
            expect($logData->message)->toContain('foo');
            expect($logData->message)->toHaveKeys(['any_data', 'any_data.id', 'any_data.name', 'bar']);
            expect($logData->message['any_data']['id'])->toContain('any-id');
            expect($logData->message['any_data']['name'])->toContain('any-name');
            expect($logData->message['bar'])->toBe('bar');
            expect($logData)->toHaveProperties(['timestamp', 'channel', 'application', 'environment', 'logId', 'tags']);
        }
        foreach ($observer->loggedEvents as $logData) {
            expect($logData->level)->toBe('warning');
            expect($logData->message)->toContain('foo');
            expect($logData)->toHaveProperties(['timestamp', 'channel', 'application', 'environment', 'logId', 'tags']);
        }
    });

    it('notifies observers about the logging lifecycle with log level info', function () use ($logInMemory): void {
        $observer = new class implements LoggerObserverContract
        {
            /** @var array<SuperlogData> */
            public array $loggingEvents = [];

            /** @var array<SuperlogData> */
            public array $loggedEvents = [];

            public function logging(SuperlogData $logData): void
            {
                $logData->appendToMessage([
                    'any_data' => [
                        'id' => 'any-id',
                        'name' => 'any-name',
                    ],
                ]);
                $logData->appendToMessage('bar');
                $this->loggingEvents[] = $logData;
            }

            public function logged(SuperlogData $logData): void
            {
                $this->loggedEvents[] = $logData;
            }
        };
        SuperlogSettings::addObserver($observer);

        $logInMemory(fn () => Superlog::info('foo'));

        expect($observer->loggingEvents)->toHaveCount(1);
        expect($observer->loggedEvents)->toHaveCount(1);
        foreach ($observer->loggingEvents as $logData) {
            expect($logData->level)->toBe('info');
            expect($logData->message)->toContain('foo');
            expect($logData->message)->toHaveKeys(['any_data', 'any_data.id', 'any_data.name', 'bar']);
            expect($logData->message['any_data']['id'])->toContain('any-id');
            expect($logData->message['any_data']['name'])->toContain('any-name');
            expect($logData->message['bar'])->toBe('bar');
            expect($logData)->toHaveProperties(['timestamp', 'channel', 'application', 'environment', 'logId', 'tags']);
        }
        foreach ($observer->loggedEvents as $logData) {
            expect($logData->level)->toBe('info');
            expect($logData->message)->toContain('foo');
            expect($logData)->toHaveProperties(['timestamp', 'channel', 'application', 'environment', 'logId', 'tags']);
        }
    });

    it('notifies observers about the logging lifecycle with log level debug', function () use ($logInMemory): void {
        $observer = new class implements LoggerObserverContract
        {
            /** @var array<SuperlogData> */
            public array $loggingEvents = [];

            /** @var array<SuperlogData> */
            public array $loggedEvents = [];

            public function logging(SuperlogData $logData): void
            {
                $logData->appendToMessage([
                    'any_data' => [
                        'id' => 'any-id',
                        'name' => 'any-name',
                    ],
                ]);
                $logData->appendToMessage('bar');
                $this->loggingEvents[] = $logData;
            }

            public function logged(SuperlogData $logData): void
            {
                $this->loggedEvents[] = $logData;
            }
        };
        SuperlogSettings::addObserver($observer);

        $logInMemory(fn () => Superlog::debug('foo'));

        expect($observer->loggingEvents)->toHaveCount(1);
        expect($observer->loggedEvents)->toHaveCount(1);
        foreach ($observer->loggingEvents as $logData) {
            expect($logData->level)->toBe('debug');
            expect($logData->message)->toContain('foo');
            expect($logData->message)->toHaveKeys(['any_data', 'any_data.id', 'any_data.name', 'bar']);
            expect($logData->message['any_data']['id'])->toContain('any-id');
            expect($logData->message['any_data']['name'])->toContain('any-name');
            expect($logData->message['bar'])->toBe('bar');
            expect($logData)->toHaveProperties(['timestamp', 'channel', 'application', 'environment', 'logId', 'tags']);
        }
        foreach ($observer->loggedEvents as $logData) {
            expect($logData->level)->toBe('debug');
            expect($logData->message)->toContain('foo');
            expect($logData)->toHaveProperties(['timestamp', 'channel', 'application', 'environment', 'logId', 'tags']);
        }
    });
});

describe('raw', function () use ($logInMemory): void {
    it('logs with critical level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::raw('critical', 'foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'tags']);
    });

    it('logs with error level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::raw('error', 'foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'tags']);
    });

    it('logs with warning level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::raw('warning', 'foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'tags']);
    });

    it('logs with info level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::raw('info', 'foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'tags']);
    });

    it('logs with debug level', function () use ($logInMemory): void {
        $output = $logInMemory(fn () => Superlog::raw('debug', 'foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'tags']);
    });
});

describe('log in stdout', function (): void {
    it('logs with critical level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('stdout');

        expect(fn () => Superlog::critical('foo'))->not->toThrow(Exception::class);
    });

    it('logs with error level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('stdout');

        expect(fn () => Superlog::error('foo'))->not->toThrow(Exception::class);
    });

    it('logs with warning level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('stdout');

        expect(fn () => Superlog::warning('foo'))->not->toThrow(Exception::class);
    });

    it('logs with info level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('stdout');

        expect(fn () => Superlog::info('foo'))->not->toThrow(Exception::class);
    });

    it('logs with debug level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('stdout');

        expect(fn () => Superlog::debug('foo'))->not->toThrow(Exception::class);
    });
});

describe('log in any-stream', function (): void {
    it('logs with critical level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('any-stream');

        expect(fn () => Superlog::critical('foo'))->not->toThrow(Exception::class);
    });

    it('logs with error level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('any-stream');

        expect(fn () => Superlog::error('foo'))->not->toThrow(Exception::class);
    });

    it('logs with warning level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('any-stream');

        expect(fn () => Superlog::warning('foo'))->not->toThrow(Exception::class);
    });

    it('logs with info level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('any-stream');

        expect(fn () => Superlog::info('foo'))->not->toThrow(Exception::class);
    });

    it('logs with debug level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('any-stream');

        expect(fn () => Superlog::debug('foo'))->not->toThrow(Exception::class);
    });
});

describe('disabled', function (): void {
    it('should not log when disabled with critical level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('any-stream');
        SuperlogSettings::disableWhen(true);

        expect(fn () => Superlog::critical('foo'))->not->toThrow(Exception::class);
    });

    it('should not log when disabled with error level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('any-stream');
        SuperlogSettings::disableWhen(true);

        expect(fn () => Superlog::error('foo'))->not->toThrow(Exception::class);
    });

    it('should not log when disabled with warning level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('any-stream');
        SuperlogSettings::disableWhen(true);

        expect(fn () => Superlog::warning('foo'))->not->toThrow(Exception::class);
    });

    it('should not log when disabled with info level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('any-stream');
        SuperlogSettings::disableWhen(true);

        expect(fn () => Superlog::info('foo'))->not->toThrow(Exception::class);
    });

    it('should not log when disabled with debug level', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('any-stream');
        SuperlogSettings::disableWhen(true);

        expect(fn () => Superlog::debug('foo'))->not->toThrow(Exception::class);
    });

    it('should not log when disabled with raw method', function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setStream('any-stream');
        SuperlogSettings::disableWhen(true);

        expect(fn () => Superlog::raw('info', 'foo'))->not->toThrow(Exception::class);
    });
});
