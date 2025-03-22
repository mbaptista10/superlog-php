<?php

namespace Superlog\Observers;

use Superlog\Contracts\LoggerObserverContract;
use Superlog\Data\SuperlogData;

class DatadogTracerObserver implements LoggerObserverContract
{
    /**
     * {@inheritdoc}
     */
    public function logging(SuperlogData $logData): void
    {
        $logData->addSpanId(\dd_trace_peek_span_id());
        $logData->addTraceId(\DDTrace\logs_correlation_trace_id());
    }

    /**
     * {@inheritdoc}
     */
    public function logged(SuperlogData $logData): void
    {
        //
    }
}
