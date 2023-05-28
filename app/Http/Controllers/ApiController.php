<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
//        $books=file_get_contents('https://openlibrary.org/isbn/9780140328721.json');
        $url = 'https://openlibrary.org/isbn/9780140328721.json
'; // path to your JSON file
//        $data = file_get_contents($url); // put the contents of the file into a variable
        $characters = json_decode($url);
        dd($characters);
    }
}
