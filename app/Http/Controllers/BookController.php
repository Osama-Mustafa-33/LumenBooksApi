<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $books = Book::all();
        return $this->successResponse($books);
    }

    public function store(Request $request)
    {
        $rules = [
            'title'         => 'required|max:255',
            'description'   => 'required|max:255',
            'price'         => 'required|integer',
            'author_id'     => 'required|integer'
        ];
        $this->validate($request, $rules);
        $book = Book::create($request->all());
        return $this->successResponse($book, Response::HTTP_CREATED);
    }

    public function show($book)
    {
        $book = Book::findOrFail($book);
        return $this->successResponse($book);

    }

    public function update(Request $request, $book)
    {
        $rules = [
            'title'         => 'required|max:255',
            'description'   => 'required|max:255',
            'price'         => 'required|integer',
            'author_id'     => 'required|integer'
        ];
        $this->validate($request, $rules);
        $book = Book::findOrFail($book);
        $book->fill($request->all());
        if ($book->isClean()) {
            return $this->errorResponse('You must edit at least one field',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $book->save();
        return $this->successResponse($book);
    }

    public function destroy($book)
    {
        $book = Book::findOrFail($book);
        $book->delete();
        return $this->successResponse($book);
    }
}
