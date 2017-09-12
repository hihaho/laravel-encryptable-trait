<?php

namespace HiHaHo\EncryptableTrait\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
        // migrations only for testing purpose
        $this->loadMigrationsFrom([
            '--database' => 'testbench',
            '--realpath' => __DIR__.'/migrations',
        ]);
        // Laravel is dumb. It calls boot only for the first test but wipes out the observers for others
        // So we call boot ourselves to make event observing work.
        // On the first test, we've already booted, so clear out the listeners. If we haven't booted
        // already, this is a no-op.
        // https://github.com/laravel/framework/issues/1181#issuecomment-51627220
        $models = [
            \HiHaHo\EncryptableTrait\Tests\Fixtures\Payment::class
        ];
        // Reset each model event listeners.
        foreach ($models as $model) {
            // Flush any existing listeners.
            call_user_func([$model, 'flushEventListeners']);
            // Reregister them.
            call_user_func([$model, 'boot']);
        }
    }
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // reset base path to point to our package's src directory
        $app['path.base'] = __DIR__.'/../src';
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('app.cipher', 'AES-256-CBC');
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
    }
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application @app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Orchestra\Database\ConsoleServiceProvider::class,
        ];
    }
}
