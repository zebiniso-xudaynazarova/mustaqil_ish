<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Category;

use App\Book;

use Illuminate\Support\Facades\Auth;


class BooksController extends Controller
{
    public function show($slug)
    {
    	$book = Book::where('slug', $slug)->first();
//    	dd($book);
    	if (!is_null($book)) {
    		return view('frontend.pages.books.show', compact('book'));
    	}
    	return redirect()->route('index');
    }    

    public function create()
    {
    	$categories = Category::all();

        $books = Book::where('is_approved', 1)->get();

        return view('frontend.pages.books.create', compact('categories', 'books'));
    }

    public function index()
    {
//        $curl = curl_init();

        $books = Book::orderBy('id', 'desc')->where('is_approved', 1)->paginate(10);
//        dd($books);
        return view('frontend.pages.books.index', compact('books'));

    }

    public function search(Request $request)
    {
        $searched = $request->s;
        if (empty($searched)) {
            return $this->index();
        }

        $books = Book::orderBy('id', 'desc')->where('is_approved', 1)
        ->where('title', 'like', '%'.$searched.'%')
        ->paginate(10);

        foreach ($books as $book) {
            $book->increment('total_search');
        }

        return view('frontend.pages.books.index', compact('books', 'searched'));
    }

    public function advanceSearch(Request $request)
    {

        $searched_category = $request->c;
        if ( empty($searched_category)) {
            return $this->index();
        }
        else if (empty($searched_category)) {
            $books = Book::orderBy('id', 'desc')->where('is_approved', 1)
            ->where('category_id', $searched_category)
            ->paginate(10);
        }else{
            $books = Book::orderBy('id', 'desc')->where('is_approved', 1)
            ->Where('category_id', $searched_category)
            ->paginate(10);
        }

        

        foreach ($books as $book) {
            $book->increment('total_search');
        }

        return view('frontend.pages.books.index', compact('books'));
    }

    public function store(Request $request)
    {
//        dd($request);
    	if (!Auth::check()) {
    		abort(403, 'Unauthorized action');
    	}

        $request->validate([
            'title' => 'required|max:50',
            'category_id' => 'required',
            'slug' => 'nullable|unique:books',


        ],
        [
            'title.required' => 'Please give book title',

        ]);

        $book = new Book();
        $book->title = $request->title;
        if (empty($request->slug)) {
            $book->slug = str_slug($request->title);
        }else{
            $book->slug = $request->slug;
        }
        $book->is_approved=1;
        $book->category_id = $request->category_id;

        $book->user_id = Auth::id();
        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/books/'), $filename);
            $book['file'] = $filename;
        }
        $book->save();
//dd($book);
        // Image Upload


        // Book Authors
//        foreach ($request->author_ids as $id) {
//            $book_author = new BookAuthor();
//            $book_author->book_id = $book->id;
//            $book_author->author_id = $id;
//            $book_author->save();
//        }
        

        session()->flash('success', 'Kitob yaratildi!!');
        return redirect()->route('index');
    }
    public function download(Request $request,$file){

        return response()->download(public_path('assets/images/books/'.$file));


    }

}
