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
        return view('reviews.campanhas');
    }
    public function review_perguntas()
    {
        return view('reviews.perguntas');
    }
    public function review_avaliacao()
    {
        return view('reviews.avaliacao');
    }
    public function review_perguntas_respostas()
    {
        return view('reviews.perguntas_respostas');
    }
    public function review_extracao()
    {
        return view('reviews.extracao');
    }
}
