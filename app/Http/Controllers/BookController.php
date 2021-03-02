<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\UserActionLog;
use App\Rules\ISBN;
use Exception;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return response([
            'books' => $books
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => ['required', new ISBN],
            'published_at' => 'required|date_format:Y-m-d',
            'status' => 'required|in:'. implode(',', [Book::AVAILABLE, Book::CHECKED_OUT]),
        ]);

        try {
            $book = new Book();
            $book->fill($request->all());
            $book->save();
            return response([
                'message' => "Book: $book->title, was successfully created."
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);

        return response([
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'string|max:255',
            'isbn' => [new ISBN],
            'published_at' => 'date_format:Y-m-d',
            'status' => 'in:'. implode(',', [Book::AVAILABLE, Book::CHECKED_OUT]),
        ]);

        $book = Book::findOrFail($id);
        $book->fill($request->all());
        $book->save();


        return response([
            'message' => "Book: $book->title updated successfully",
            'book' => $book
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            return response([
                'message' => 'Book deleted successfully'
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function checkIn(Request $request, $bookID)
    {
        $book = Book::findOrFail($bookID);
        $user = $request->user();

        if ($book->status === Book::AVAILABLE) {
            return response([
                'message' => 'This book has already been checked in.',
                'book' => $book
            ], 422);
        }

        $userAction = new UserActionLog();
        $book->status = Book::AVAILABLE;

        $userAction->action = UserActionLog::CHECKIN;
        $userAction->book()->associate($book);
        $userAction->user()->associate($user);

        $book->save();
        $userAction->save();

        return response([
            'message' => 'Book checked in successfully',
            'book' => $book
        ]);
    }

    public function checkOut(Request $request, $bookID)
    {
        $book = Book::findOrFail($bookID);
        $user = $request->user();

        if ($book->status === Book::CHECKED_OUT) {
            return response([
                'message' => 'This book has already been checked out.',
                'book' => $book
            ], 422);
        }

        $userAction = new UserActionLog();
        $book->status = Book::CHECKED_OUT;

        $userAction->action = UserActionLog::CHECKOUT;
        $userAction->book()->associate($book);
        $userAction->user()->associate($user);

        $book->save();
        $userAction->save();

        return response([
            'message' => "Book checked out successfully",
            'book' => $book
        ]);
    }
}
