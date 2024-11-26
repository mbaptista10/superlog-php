<?php

namespace Superlog\Contracts;

use Superlog\Data\SuperlogData;

interface LoggerObserverContract
{
    /**
     * Before logging the data.
     */
    public function logging(SuperlogData $logData): void;

    /**
     * After logging the data.
     */
    public function logged(SuperlogData $logData): void;
}
