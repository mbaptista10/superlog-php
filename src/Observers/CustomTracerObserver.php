<?php

namespace Superlog\Observers;

use Ramsey\Uuid\Uuid;
use Superlog\Contracts\LoggerObserverContract;
use Superlog\Data\SuperlogData;

class CustomTracerObserver implements LoggerObserverContract
{
    /**
     * {@inheritdoc}
     */
    public function logging(SuperlogData $logData): void
    {
        $logData->addSpanId(Uuid::uuid4()->toString());
        $logData->addTraceId(Uuid::uuid4()->toString());
    }

    /**
     * {@inheritdoc}
     */
    public function logged(SuperlogData $logData): void
    {
        //
    }
}
