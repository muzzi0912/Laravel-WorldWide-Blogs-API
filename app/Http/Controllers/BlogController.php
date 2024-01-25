<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

// ========== MODELS ========== //
use App\Models\Blogs;


// ========== MODELS ========== //


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Blogs::all();
        
        // $blogs =  Blogs::all();

        // return view('welcome' , compact('blogs'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:2000', // Maximum 2000 characters for content
            'author' => 'required|string|max:255',
        ]);

        $blog =  Blogs::create($request->all());

        return ['message' => 'Blog  Created successfully', $blog];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Blogs::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = Blogs::find($id);

        $blog->update($request->all());

        return ['message' => 'Blog  Updated successfully'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete_blog = Blogs::find($id);

        $delete_blog->delete();

        return ['message' => 'Blog  deleted successfully'];
    }

    /**
     * Search based on author and title 
     */
    public function search($author)
    {
        return Blogs::where('author', $author)->get();
    }
}