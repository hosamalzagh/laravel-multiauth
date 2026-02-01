<?php

namespace CobraProjects\Multiauth\Tests\Unit;

use CobraProjects\Multiauth\Model\Role;
use CobraProjects\Multiauth\Model\Admin;
use CobraProjects\Multiauth\Tests\TestCase;
use CobraProjects\Multiauth\Model\Permission;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PermissionTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_belongs_to_many_role()
    {
        $role = Role::factory(2)->create();
        $permission = Permission::factory()->create();
        $permission->roles()->attach($role->pluck('id'));
        $this->assertInstanceOf(Role::class, $permission->roles->first());
    }

    /** @test */
    public function it_belongs_many_to_admin()
    {
        $admin = Admin::factory()->create();
        $permission = Permission::factory()->create();
        $permission->admins()->attach($admin->pluck('id'));
        $this->assertInstanceOf(Admin::class, $permission->admins->first());
    }
}
