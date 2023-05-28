<?php

namespace App;
use Barryvdh\DomPDF\PDF;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function category()
    {
    	return $this->belongsTo(Category::class);
    }    

    public function user()
    {
    	return $this->belongsTo(User::class);
    }


    /**
     * isAuthorSelected
     * 
     * @param  integer  $book_id   
     * @param  integer  $author_id 
     * @return boolean            Return true if the author written the book, false otherwise
     */
    public static function isAuthorSelected($book_id, $author_id)
    {
        $book_author = BookAuthor::where('book_id', $book_id)->where('author_id', $author_id)->first();
        if (!is_null($book_author)) {
            return true;
        }
        return false;
    }
}
