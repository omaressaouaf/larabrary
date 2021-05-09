<?php

namespace App\Http\Controllers\API;

use App\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Genre::orderBy('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:genres',
            'slug' => 'required|unique:genres'
        ]);
        $genre = new Genre();
        $genre->name = $request->name;
        $genre->slug = $request->slug;
        $genre->save();

        return response()->json([
            'message' => 'genre has been created',
            'genre' => $genre
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        $this->validate($request, [
            'name' => 'required|unique:genres,name,' . $genre->id,
            'slug' => 'required|unique:genres,slug,' . $genre->id,
        ]);
        $genre->name = $request->name;
        $genre->slug = $request->slug;
        $genre->save();
        return response()->json([
            'message' => 'genre has been updated',
            'genre' => $genre
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $genre = Genre::find($id);
        $genre->delete();
        return response()->json([
            'message' => "genre has been deleted",
        ], 200);
    }
}
