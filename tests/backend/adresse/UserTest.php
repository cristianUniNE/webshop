<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends BrowserKitTest {

    use DatabaseTransactions;

    protected $adresse;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        DB::beginTransaction();
    }

    public function tearDown()
    {
        Mockery::close();
        DB::rollBack();
        parent::tearDown();
    }

    public function testCreateNewUser()
    {
         $user = factory(App\Droit\User\Entities\User::class)->create();

        $user->roles()->attach(1);
        $this->actingAs($user);

        $this->assertTrue(Auth::check());

        $this->visit(url('admin/user/create'));

        // Create new user
        $this->type('Terry', 'first_name');
        $this->type('Jonesy', 'last_name');
        $this->type('terry.jonesy@domain.ch', 'email');
        $this->type('123456', 'password');

        $this->press('Envoyer');

        $this->seeInDatabase('users', [
            'first_name' => 'Terry',
            'last_name' => 'Jonesy',
            'email' => 'terry.jonesy@domain.ch'
        ]);
    }

    public function testDeleteThenCreateUserWithSameEmail()
    {
        $admin = factory(App\Droit\User\Entities\User::class)->create();
        $admin->roles()->attach(1);
        $this->actingAs($admin);

        $user = factory(App\Droit\User\Entities\User::class)->create([
            'email' => 'terry.jonesy@domain.ch'
        ]);

        $this->visit(url('admin/user/'.$user->id));
        // delete user
        $this->press('deleteUser_'.$user->id);

        $this->notSeeInDatabase('users', [
            'id'         => $user->id,
            'deleted_at' => null
        ]);

        $this->visit(url('admin/user/create'));

        // Create new user
        $this->type('Terry', 'first_name');
        $this->type('Jonesy', 'last_name');
        $this->type('terry.jonesy@domain.ch', 'email');
        $this->type('123456', 'password');

        $this->press('Envoyer');

        $this->seeInDatabase('users', [
            'first_name' => 'Terry',
            'last_name'  => 'Jonesy',
            'email'      => 'terry.jonesy@domain.ch'
        ]);
    }

    public function testUpdateUser()
    {
        $user = factory(App\Droit\User\Entities\User::class)->create();

        $user->roles()->attach(1);

        $this->actingAs($user);

        $this->assertTrue(Auth::check());

        $this->visit(url('admin/user/'.$user->id));
        $this->seePageIs(url('admin/user/'.$user->id));
        $this->assertViewHas('user');

        $this->type('Terry', 'first_name');

        $this->press('Enregistrer');

        $this->seeInDatabase('users', [
            'id'         => $user->id,
            'first_name' => 'Terry'
        ]);
    }

}
