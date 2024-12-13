<?php

/**
 * @see https://github.com/pestphp/pest/blob/3.x/src/ArchPresets/Php.php
 */
arch()->preset()->php();

/**
 * @see https://github.com/pestphp/pest/blob/3.x/src/ArchPresets/Security.php
 */
arch()->preset()->security();

arch('globals')
    ->expect(['dd', 'sleep', 'usleep'])
    ->not->toBeUsed();
