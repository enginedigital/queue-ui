<?php

namespace EngineDigital\QueueUi\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RouteTest extends TestCase
{
    use InteractsWithSession;

    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \EngineDigital\QueueUi\QueueUiServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('queue-ui.route_middleware', null);
        $app['config']->set('queue-ui.command_whitelist', ['cache:clear']);
    }

    /** @test */
    public function it_can_load_the_index_page()
    {
        DB::shouldReceive('table')
            ->once()
            ->with('jobs')
            ->andReturnSelf();
        DB::shouldReceive('links')
            ->once()
            ->andReturnSelf();
        DB::shouldReceive('count')
            ->once()
            ->andReturn(1);
        DB::shouldReceive('paginate')
            ->once()
            ->with(config('queue-ui.paginate_size'))
            ->andReturnSelf();
        $response = $this->call('GET', route('queue-ui.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_run_a_command()
    {
        $this->withSession([]);

        Artisan::shouldReceive('call')
            ->once()
            ->with('cache:clear', null)
            ->andReturn(0);
        $response = $this->call('GET', route('queue-ui.run'), [
            'command' => 'cache:clear',
            'arguments' => [],
        ]);
        $response
            ->assertStatus(302);
    }

    /** @test */
    public function it_cannot_run_a_command()
    {
        $this->withSession([]);

        $response = $this->call('GET', route('queue-ui.run'), [
            'command' => 'view:clear',
            'arguments' => [],
        ]);
        $response
            ->assertStatus(302);
    }
}
