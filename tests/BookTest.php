<?php

use App\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BookTest extends TestCase
{
    use DatabaseMigrations;

    public function testBooksCanBeDeleted()
    {
        $user = factory(App\User::class)->create();

        $book = $user->books()->create([
            'name' => 'The Hobbit',
            'price' => 10,
        ]);

        $book->delete();

        $this->notSeeInDatabase('books', ['id' => 1, 'name' => 'The Hobbit', 'price' => 10]);
    }

    public function testBooksCanBeCreated()
    {
        $user = factory(App\User::class)->create();

        $book = $user->books()->create([
            'name' => 'The Hobbit',
            'price' => 10,
        ]);

        $found_book = Book::find(1);

        $this->assertEquals($found_book->name, 'The Hobbit');
        $this->assertEquals($found_book->price, 10);

        $this->seeInDatabase('books', ['id' => 1, 'name' => 'The Hobbit', 'price' => 10]);
    }
}
