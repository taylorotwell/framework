<?php

namespace Illuminate\Tests\Integration\Console;

use Orchestra\Testbench\TestCase;

class ConcurrencyTest extends TestCase
{
    protected function setUp(): void
    {
        $this->defineCacheRoutes(<<<PHP
<?php

use Illuminate\Support\Facades\Concurrency;

Route::any('/concurrency', function () {
    return Concurrency::run([
        fn () => 1 + 1,
        fn () => 2 + 2,
    ]);
});
PHP);

        parent::setUp();
    }

    public function testWorkCanBeDistributed()
    {
        $response = $this->get('concurrency')
            ->assertOk();

        [$first, $second] = $response->original;

        $this->assertEquals(2, $first);
        $this->assertEquals(4, $second);
    }
}
