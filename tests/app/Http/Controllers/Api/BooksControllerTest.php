<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class BooksControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function test_index_method_returns_all_books()
    {
        $user = factory(App\User::class)->create();

        $books = factory(App\Book::class, 2)->create(['user_id' => $user->id]);

        $this
            ->get(route('api.books.index'))
            ->seeStatusCode(200);

        foreach ($books as $book) {
            $this->seeJson([
                'name' => $book->name,
                'price' => $book->price,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
        }

    }

    public function test_show_method_returns_a_particular_book()
    {
        $this->disableExceptionHandling();

        $user = factory(App\User::class)->create();

        $book = factory(App\Book::class)->create(['user_id' => $user->id]);

        $this
            ->get(route('api.books.show', [$book->id]))
            ->seeStatusCode(200)
            ->seeJson([
                'name' => $book->name,
                'price' => $book->price,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);

    }

}
