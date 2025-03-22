<?php

/**
 * For full stub file:
 *
 * @see https://raw.githubusercontent.com/DataDog/dd-trace-php/refs/heads/master/ext/ddtrace.stub.php
 */

namespace DDTrace {
    /**
     * Formatted trace id to be used for logs correlation.
     *
     * This function handles 128-bit trace ids and 64-bit trace ids. More specifically, if
     * DD_TRACE_128_BIT_TRACEID_LOGGING_ENABLED is set to true and the current trace id is 128-bit, then the trace id
     * will be returned as a 32-character hexadecimal string. Otherwise, the trace id will be returned as the
     * decimal representation of the 64-bit trace id.
     *
     * @return string The formatted id of the current trace
     */
    function logs_correlation_trace_id(): string {}

}

namespace {
    /**
     * Get the currently active span id, or the distributed parent trace id if there is no currently active span
     *
     * @return string Currently active span/trace unique identifier
     */
    function dd_trace_peek_span_id(): string {}
}
