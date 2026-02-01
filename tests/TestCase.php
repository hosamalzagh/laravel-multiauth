<?php

namespace CobraProjects\Multiauth\Tests;

use CobraProjects\Multiauth\Model\Role;
use CobraProjects\Multiauth\Model\Admin;
use CobraProjects\Multiauth\Model\Permission;
use CobraProjects\Multiauth\MultiauthServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setup(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->artisan('migrate', ['--database' => 'testing']);
        $this->loadLaravelMigrations(['--database' => 'testing']);
        $this->loadMigrationsFrom(__DIR__ . '/../src/database/migrations');
        // Manually create password_resets table for legacy compatibility in tests
        $this->app['db']->connection()->getSchemaBuilder()->create('password_resets', function ($table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('multiauth.registration_notification_email', false);
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [MultiauthServiceProvider::class];
    }

    public function logInAdmin($args = [])
    {
        $admin = $this->createAdmin($args);
        $this->actingAs($admin, 'admin');

        return $admin;
    }

    public function createAdmin($args = [])
    {
        return Admin::factory()->create($args);
    }

    public function create_permission($args = [], $num = null)
    {
        return Permission::factory($num)->create($args);
    }

    public function loginSuperAdmin($args = [])
    {
        $super = Admin::factory()->create($args);
        $role = Role::factory()->create(['name' => 'super']);
        $this->createAndLinkPermissionsTo($role);
        $super->roles()->attach($role);
        $this->actingAs($super, 'admin');

        return $super;
    }

    protected function createAndLinkPermissionsTo($role)
    {
        $models = ['Admin', 'Role'];
        $tasks = ['Create', 'Read', 'Update', 'Delete'];
        foreach ($tasks as $task) {
            foreach ($models as $model) {
                $name = "{$task}{$model}";
                $permission = Permission::create(['name' => $name, 'parent' => $model]);
                $role->addPermission([$permission->id]);
            }
        }
    }
}
