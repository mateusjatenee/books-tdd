<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function loginShouldReturnATokenWhenItReceivesValidCredentials()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create(['password' => bcrypt('admin')]);

        $this
            ->post(route('api.auth.login'), [
                'email' => $user->email,
                'password' => 'admin',
            ])
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'token',
            ]);

    }

    /** @test */
    public function loginShouldReturnAnErrorWhenItReceivesInvalidCredentials()
    {
        $this->disableExceptionHandling();

        $this
            ->post(route('api.auth.login'), [
                'email' => 'foo@bar.baz',
                'password' => 'dumb',
            ])
            ->seeStatusCode(422)
            ->seeJson([
                'error' => 'user_not_found',
            ]);
    }

    /** @test */
    public function registerReturnsATokenIfEmailDoesNotExists()
    {
        $this->disableExceptionHandling();

        $this
            ->post(route('api.auth.register'), [
                'name' => 'John Doe',
                'email' => 'john@foo.com',
                'password' => 'dumb123',
            ])
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'token',
            ]);
    }

    /** @test */
    public function registerReturnsAnErrorIfEmailAlreadyExists()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create();

        $this
            ->post(route('api.auth.register'), [
                'email' => $user->email,
                'name' => 'whatever',
                'password' => 'foo',
            ])
            ->seeStatusCode(422)
            ->seeJson([
                'error' => 'emails_already_been_used',
            ]);

    }
}
