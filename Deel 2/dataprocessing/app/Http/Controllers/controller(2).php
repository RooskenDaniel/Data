<?php

namespace App\Http\Controllers;

class PlayersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index() {
       
        return "Hello From Index";
    }

    public function show() {
       
        return "Hello From Show";
    }
    
    public function store() {
       
        return "Hello From Store";
    }

    public function update() {
       
        return "Hello From Update";
    }

    public function destroy() {
       
        return "Hello From Delete";
    }
}