<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewsController extends Controller
{
    public function index()
    {
        return view('reviews.index');
    }

    public function review_campanhas()
    {
        return view('reviews.index');
    }
}
