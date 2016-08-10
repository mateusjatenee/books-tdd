<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function findByEmail_should_find_an_user_by_its_email()
    {
        factory(User::class, 3)->create()->each(function ($user) {
            $found_user = User::findByEmail($user->email);
            $this->assertEquals($found_user->name, $user->name);
            $this->assertEquals($found_user->email, $user->email);
            $this->assertEquals($found_user->password, $user->password);
        });

    }
}
