<?php

namespace Illuminate\Concurrency;

use Closure;
use Illuminate\Support\Arr;
use Spatie\Fork\Fork;

class ForkDriver
{
    /**
     * Run the given tasks concurrently and return an array containing the results.
     */
    public function run(Closure|array $tasks): array
    {
        return Fork::new()->run(...Arr::wrap($tasks));
    }

    /**
     * Start the given tasks in the background.
     */
    public function background(Closure|array $tasks): void
    {
        $this->run($tasks);
    }
}
