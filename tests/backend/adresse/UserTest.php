<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase {

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
    
    public function testChangeFirstName()
    {
        $user = factory(App\Droit\User\Entities\User::class,'admin')->create();

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

    public function testNewAdresse()
    {
        $user = factory(App\Droit\User\Entities\User::class,'admin')->create();

        $user->roles()->attach(1);

        $this->actingAs($user);

        $this->visit(url('admin/adresse/create'));

        $this->type('Terry', 'first_name');
        $this->type('Jones', 'last_name');
        $this->type('terry.jones@gmail.com', 'email');
        $this->type('Rue du test 23', 'adresse');
        $this->type('1234', 'npa');
        $this->type('Bienne', 'ville');
        $this->press('Enregistrer');

        $this->seeInDatabase('adresses', [
            'first_name' => 'Terry',
            'last_name'  => 'Jones',
            'email'      => 'terry.jones@gmail.com',
            'adresse'    => 'Rue du test 23',
            'npa'        => '1234',
            'ville'      => 'Bienne',
        ]);

    }
}
