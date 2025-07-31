<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();
        return view('backend.author.list',compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('backend.author.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //return 'store';
        // var_dump($request->all());
        // die();
        $request->validate([
            'authorName' => 'min:3|required',
        ]);


        $authorName = $request->authorName;

        Author::create([
            'name' => $authorName,
        ]);

        //return $authorName;
       
        return redirect()->route('authors.index');


    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
       
        return view('backend.author.detail',compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        
      // $author = Author::find($id);
       return view('backend.author.edit',compact('author'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        // var_dump($request->all());
        // die();
        $request->validate([
            'authorName' => 'required|min:3',
        ]);

        $authorName = $request->authorName;

        // update into database table
       // $author = Author::find($id);
        $author->name = $authorName;
        $author->save();

        // redirect to list page
        return redirect()->route('authors.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
       // $author = Author::find($id);
        $author->delete();
        return redirect()->route('authors.index');
    }
}
