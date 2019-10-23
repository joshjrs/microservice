<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Services\BookService;
use App\Traits\ApiResponser;
use App\Book;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the books microservice
     */
    public $bookService;

    /**
     * The service to consume the authors microservice
     */
    public $authorService;

    public function __construct(BookService $bookService, AuthorService $authorService) {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * Return the list of books
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse($this->bookService->obtainBooks());
    }

    /**
     * Create one new book
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorService->obtainAuthor($request->author_id);
        return $this->successResponse($this->bookService->createBook($request->all(), Response::HTTP_CREATED));
    }

    /**
     * Show one book
     * @return Illuminate\Http\Response
     */
    public function show($book)
    {
        return $this->successResponse($this->bookService->obtainBook($book));
    }

    /**
     * Update an existing book
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $book)
    {
        return $this->successResponse($this->bookService->editBook($request->all(), $book));
    }

    /**
     * Remove an existing book
     * @return Illuminate\Http\Response
     */
    public function destroy($book)
    {
        return $this->successResponse($this->bookService->deleteBook($book));
    }
}
