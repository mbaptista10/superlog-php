<?php

use Superlog\Superlog;
use Superlog\SuperlogSettings;

$getLogOutput = function ($logCallback): array {
    $channel = fopen('php://memory', 'a+');
    SuperlogSettings::setEnvironment('testing');
    SuperlogSettings::setApplication('application');
    SuperlogSettings::setChannel($channel);

    $logCallback();

    fseek($channel, 0);
    $stringOutput = fread($channel, 1024);
    $jsonOutput = json_decode($stringOutput, true);
    fclose($channel);

    return [
        'string_output' => $stringOutput,
        'json_output' => $jsonOutput,
    ];
};

describe('validate', function (): void {
    it('should throw exception when channel is empty with critical level', function (): void {
        SuperlogSettings::setChannel(null);
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::critical('foo'))->toThrow(RuntimeException::class, 'Channel not set');
    });

    it('should throw exception when application is empty with critical level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::critical('foo'))->toThrow(RuntimeException::class, 'Application not set');
    });

    it('should throw exception when environment is empty with critical level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('');

        expect(fn() => Superlog::critical('foo'))->toThrow(RuntimeException::class, 'Environment not set');
    });

    it('should throw exception when channel is empty with error level', function (): void {
        SuperlogSettings::setChannel(null);
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::error('foo'))->toThrow(RuntimeException::class, 'Channel not set');
    });

    it('should throw exception when application is empty with error level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::error('foo'))->toThrow(RuntimeException::class, 'Application not set');
    });

    it('should throw exception when environment is empty with error level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('');

        expect(fn() => Superlog::error('foo'))->toThrow(RuntimeException::class, 'Environment not set');
    });

    it('should throw exception when channel is empty with warning level', function (): void {
        SuperlogSettings::setChannel(null);
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::warning('foo'))->toThrow(RuntimeException::class, 'Channel not set');
    });

    it('should throw exception when application is empty with warning level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::warning('foo'))->toThrow(RuntimeException::class, 'Application not set');
    });

    it('should throw exception when environment is empty with warning level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('');

        expect(fn() => Superlog::warning('foo'))->toThrow(RuntimeException::class, 'Environment not set');
    });

    it('should throw exception when channel is empty with info level', function (): void {
        SuperlogSettings::setChannel(null);
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::info('foo'))->toThrow(RuntimeException::class, 'Channel not set');
    });

    it('should throw exception when application is empty with info level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::info('foo'))->toThrow(RuntimeException::class, 'Application not set');
    });

    it('should throw exception when environment is empty with info level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('');

        expect(fn() => Superlog::info('foo'))->toThrow(RuntimeException::class, 'Environment not set');
    });

    it('should throw exception when channel is empty with debug level', function (): void {
        SuperlogSettings::setChannel(null);
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::debug('foo'))->toThrow(RuntimeException::class, 'Channel not set');
    });

    it('should throw exception when application is empty with debug level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::debug('foo'))->toThrow(RuntimeException::class, 'Application not set');
    });

    it('should throw exception when environment is empty with debug level', function (): void {
        SuperlogSettings::setChannel('channel');
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('');

        expect(fn() => Superlog::debug('foo'))->toThrow(RuntimeException::class, 'Environment not set');
    });

    it('not throw exception when channel, application and environment is not empty with critical level', function (): void {
        SuperlogSettings::setChannel(fopen('php://memory', 'a+'));
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::critical('foo'))->not->toThrow(RuntimeException::class);
    });

    it('not throw exception when channel, application and environment is not empty with error level', function (): void {
        SuperlogSettings::setChannel(fopen('php://memory', 'a+'));
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::error('foo'))->not->toThrow(RuntimeException::class);
    });

    it('not throw exception when channel, application and environment is not empty with warning level', function (): void {
        SuperlogSettings::setChannel(fopen('php://memory', 'a+'));
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::warning('foo'))->not->toThrow(RuntimeException::class);
    });

    it('not throw exception when channel, application and environment is not empty with info level', function (): void {
        SuperlogSettings::setChannel(fopen('php://memory', 'a+'));
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::info('foo'))->not->toThrow(RuntimeException::class);
    });

    it('not throw exception when channel, application and environment is not empty with debug level', function (): void {
        SuperlogSettings::setChannel(fopen('php://memory', 'a+'));
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('environment');

        expect(fn() => Superlog::debug('foo'))->not->toThrow(RuntimeException::class);
    });
});

describe('rfc', function () use ($getLogOutput): void {
    it('should be rfc compliant with level critical', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::critical('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'log_id', 'tags']);
    });

    it('should be rfc compliant with level error', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::error('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'log_id', 'tags']);
    });

    it('should be rfc compliant with level warning', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::warning('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'log_id', 'tags']);
    });

    it('should be rfc compliant with level info', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::info('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'log_id', 'tags']);
    });

    it('should be rfc compliant with level debug', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::debug('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput)->toHaveKeys(['timestamp', 'level', 'channel', 'application', 'environment', 'message', 'log_id', 'tags']);
    });
});

describe('log level', function () use ($getLogOutput): void {
    it('logs with critical level', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::critical('foo'));

        expect($output['json_output']['level'])->toBe('critical');
    });

    it('logs with error level', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::error('foo'));

        expect($output['json_output']['level'])->toBe('error');
    });

    it('logs with warning level', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::warning('foo'));

        expect($output['json_output']['level'])->toBe('warning');
    });

    it('logs with info level', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::info('foo'));

        expect($output['json_output']['level'])->toBe('info');
    });

    it('logs with debug level', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::debug('foo'));

        expect($output['json_output']['level'])->toBe('debug');
    });
});

describe('log id', function () use ($getLogOutput): void {
    it('logs with critical level should have a log id', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::critical('foo'));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($jsonOutput['log_id'])->toBeUuid();
        expect($tags)->toContain('log_id:' . $jsonOutput['log_id']);
    });

    it('logs with error level should have a log id', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::error('foo'));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($jsonOutput['log_id'])->toBeUuid();
        expect($tags)->toContain('log_id:' . $jsonOutput['log_id']);
    });

    it('logs with warning level should have a log id', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::warning('foo'));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($jsonOutput['log_id'])->toBeUuid();
        expect($tags)->toContain('log_id:' . $jsonOutput['log_id']);
    });

    it('logs with info level should have a log id', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::info('foo'));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($jsonOutput['log_id'])->toBeUuid();
        expect($tags)->toContain('log_id:' . $jsonOutput['log_id']);
    });

    it('logs with debug level should have a log id', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::debug('foo'));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($jsonOutput['log_id'])->toBeUuid();
        expect($tags)->toContain('log_id:' . $jsonOutput['log_id']);
    });
});

describe('log message', function () use ($getLogOutput): void {
    it('logs with critical level should have a message in description key', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::critical('foo'));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message['description'])->toBe('foo');
    });

    it('logs with error level should have a message in description key', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::error('foo'));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message['description'])->toBe('foo');
    });

    it('logs with warning level should have a message in description key', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::warning('foo'));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message['description'])->toBe('foo');
    });

    it('logs with info level should have a message in description key', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::info('foo'));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message['description'])->toBe('foo');
    });

    it('logs with debug level should have a message in description key', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::debug('foo'));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message['description'])->toBe('foo');
    });
});

describe('log tags', function () use ($getLogOutput): void {
    it('logs with critical level should have a log id', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::critical('foo', ['foo', 'bar']));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($tags)->toMatchArray(['foo', 'bar']);
    });

    it('logs with error level should have a log id', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::error('foo', ['foo', 'bar']));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($tags)->toMatchArray(['foo', 'bar']);
    });

    it('logs with warning level should have a log id', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::warning('foo', ['foo', 'bar']));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($tags)->toMatchArray(['foo', 'bar']);
    });

    it('logs with info level should have a log id', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::info('foo', ['foo', 'bar']));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($tags)->toMatchArray(['foo', 'bar']);
    });

    it('logs with debug level should have a log id', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::debug('foo', ['foo', 'bar']));
        $jsonOutput = $output['json_output'];
        $tags = $jsonOutput['tags'];

        expect($tags)->toMatchArray(['foo', 'bar']);
    });
});

describe('log level filter', function () use ($getLogOutput): void {
    it('should only show critical logs when the level is critical', function () use ($getLogOutput): void {
        SuperlogSettings::setLogLevel('critical');
        $outputCritical = $getLogOutput(fn() => Superlog::critical('foo'));
        $outputError = $getLogOutput(fn() => Superlog::error('foo'));
        $outputWarning = $getLogOutput(fn() => Superlog::warning('foo'));
        $outputInfo = $getLogOutput(fn() => Superlog::info('foo'));
        $outputDebug = $getLogOutput(fn() => Superlog::debug('foo'));

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

    it('should only show critical and error logs when the level is error', function () use ($getLogOutput): void {
        SuperlogSettings::setLogLevel('error');
        $outputCritical = $getLogOutput(fn() => Superlog::critical('foo'));
        $outputError = $getLogOutput(fn() => Superlog::error('foo'));
        $outputWarning = $getLogOutput(fn() => Superlog::warning('foo'));
        $outputInfo = $getLogOutput(fn() => Superlog::info('foo'));
        $outputDebug = $getLogOutput(fn() => Superlog::debug('foo'));

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

    it('should only show critical, error and warning logs when the level is warning', function () use ($getLogOutput): void {
        SuperlogSettings::setLogLevel('warning');
        $outputCritical = $getLogOutput(fn() => Superlog::critical('foo'));
        $outputError = $getLogOutput(fn() => Superlog::error('foo'));
        $outputWarning = $getLogOutput(fn() => Superlog::warning('foo'));
        $outputInfo = $getLogOutput(fn() => Superlog::info('foo'));
        $outputDebug = $getLogOutput(fn() => Superlog::debug('foo'));

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

    it('should only show critical, error, warning and info logs when the level is info', function () use ($getLogOutput): void {
        SuperlogSettings::setLogLevel('info');
        $outputCritical = $getLogOutput(fn() => Superlog::critical('foo'));
        $outputError = $getLogOutput(fn() => Superlog::error('foo'));
        $outputWarning = $getLogOutput(fn() => Superlog::warning('foo'));
        $outputInfo = $getLogOutput(fn() => Superlog::info('foo'));
        $outputDebug = $getLogOutput(fn() => Superlog::debug('foo'));

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

    it('should show all levels logs when the level is debug', function () use ($getLogOutput): void {
        SuperlogSettings::setLogLevel('debug');
        $outputCritical = $getLogOutput(fn() => Superlog::critical('foo'));
        $outputError = $getLogOutput(fn() => Superlog::error('foo'));
        $outputWarning = $getLogOutput(fn() => Superlog::warning('foo'));
        $outputInfo = $getLogOutput(fn() => Superlog::info('foo'));
        $outputDebug = $getLogOutput(fn() => Superlog::debug('foo'));

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

describe('default values', function () use ($getLogOutput): void {
    beforeEach(function (): void {
        SuperlogSettings::setApplication('application');
        SuperlogSettings::setEnvironment('testing');
    });

    it('should have default values when level is critical', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::critical('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput['channel'])->toContain('Resource id');
        expect($jsonOutput['application'])->toBe('application');
        expect($jsonOutput['environment'])->toBe('testing');
    });

    it('should have default values when level is error', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::error('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput['channel'])->toContain('Resource id');
        expect($jsonOutput['application'])->toBe('application');
        expect($jsonOutput['environment'])->toBe('testing');
    });

    it('should have default values when level is warning', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::warning('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput['channel'])->toContain('Resource id');
        expect($jsonOutput['application'])->toBe('application');
        expect($jsonOutput['environment'])->toBe('testing');
    });

    it('should have default values when level is info', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::info('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput['channel'])->toContain('Resource id');
        expect($jsonOutput['application'])->toBe('application');
        expect($jsonOutput['environment'])->toBe('testing');
    });

    it('should have default values when level is debug', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::debug('foo'));
        $jsonOutput = $output['json_output'];

        expect($jsonOutput['channel'])->toContain('Resource id');
        expect($jsonOutput['application'])->toBe('application');
        expect($jsonOutput['environment'])->toBe('testing');
    });
});

describe('log message with object', function () use ($getLogOutput): void {
    it('should be able to log message object with critical level', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::critical([
            'any_data' => 'foo',
            'any_other_data' => 'bar',
            'nested_data' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toHaveKeys(['any_data', 'any_other_data', 'nested_data.foo', 'nested_data.baz']);
        expect($message['any_data'])->toBe('foo');
        expect($message['any_other_data'])->toBe('bar');
        expect($message['nested_data']['foo'])->toBe('bar');
        expect($message['nested_data']['baz'])->toBe('qux');
    });

    it('should be able to log message object with error level', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::error([
            'any_data' => 'foo',
            'any_other_data' => 'bar',
            'nested_data' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toHaveKeys(['any_data', 'any_other_data', 'nested_data.foo', 'nested_data.baz']);
        expect($message['any_data'])->toBe('foo');
        expect($message['any_other_data'])->toBe('bar');
        expect($message['nested_data']['foo'])->toBe('bar');
        expect($message['nested_data']['baz'])->toBe('qux');
    });

    it('should be able to log message object with warning level', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::warning([
            'any_data' => 'foo',
            'any_other_data' => 'bar',
            'nested_data' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toHaveKeys(['any_data', 'any_other_data', 'nested_data.foo', 'nested_data.baz']);
        expect($message['any_data'])->toBe('foo');
        expect($message['any_other_data'])->toBe('bar');
        expect($message['nested_data']['foo'])->toBe('bar');
        expect($message['nested_data']['baz'])->toBe('qux');
    });

    it('should be able to log message object with info level', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::info([
            'any_data' => 'foo',
            'any_other_data' => 'bar',
            'nested_data' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toHaveKeys(['any_data', 'any_other_data', 'nested_data.foo', 'nested_data.baz']);
        expect($message['any_data'])->toBe('foo');
        expect($message['any_other_data'])->toBe('bar');
        expect($message['nested_data']['foo'])->toBe('bar');
        expect($message['nested_data']['baz'])->toBe('qux');
    });

    it('should be able to log message object with debug level', function () use ($getLogOutput): void {
        $output = $getLogOutput(fn() => Superlog::debug([
            'any_data' => 'foo',
            'any_other_data' => 'bar',
            'nested_data' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]));
        $jsonOutput = $output['json_output'];
        $message = $jsonOutput['message'];

        expect($message)->toHaveKeys(['any_data', 'any_other_data', 'nested_data.foo', 'nested_data.baz']);
        expect($message['any_data'])->toBe('foo');
        expect($message['any_other_data'])->toBe('bar');
        expect($message['nested_data']['foo'])->toBe('bar');
        expect($message['nested_data']['baz'])->toBe('qux');
    });
});
