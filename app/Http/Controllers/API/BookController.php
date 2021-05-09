<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\User;
use App\Genre;
use App\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::orderBy('id', 'desc')->with(['genres', 'user', 'images'])->get();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'bail|required|min:4|max:255',
            'slug' => 'bail|required|max:255|unique:books',
            'description' => 'bail|required|min:4',
            'price' => 'bail|required|numeric',
            'stock' => 'bail|required|integer|min:0',
            'user_id' => 'bail|required|integer',
            'genres' => 'required',
            'newImages' => 'nullable|array',
            'newImages.*' => 'bail|base64image|base64max:9999'
        ]);
        $book = new Book();
        $book->title = $request->title;
        $book->slug = $request->slug;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->stock = $request->stock;
        $book->user_id = $request->user_id;
        $book->save();
        foreach ($request->genres as $genre) {
            $genreDB = Genre::find($genre['id']);
            $book->genres()->attach($genreDB);
        }
        if (!empty($request->newImages)) {
            foreach ($request->newImages as $newImage) {
                $exploded = explode(',', $newImage);
                $decoded = base64_decode($exploded[1]);
                if (str_contains($exploded[0], 'jpeg')) {
                    $extension = "jpeg";
                } else if (str_contains($exploded[0], 'png')) {
                    $extension = "png";
                } else if (str_contains($exploded[0], 'jpg')) {
                    $extension = "jpg";
                }
                $fileNameToStore = Str::random(10) . '_' . time() . '.' . $extension;
                $path = '\\public\\images\\books\\' . $book->id . '\\' . $fileNameToStore;
                $fileNameToDB = '/storage/images/books/' . $book->id . '/' . $fileNameToStore;
                Storage::put($path, $decoded);
                $image = new Image();
                $image->name = $fileNameToDB;
                $image->book_id = $book->id;
                $image->save();
            }
        }
        return response()->json([
            'message' => 'book has been created',
            'book' => $book
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
        $book = Book::with(['genres', 'user', 'images'])->findOrFail($id);
        return response()->json([
            'book' => $book,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $book = Book::findOrFail($id);
        $this->validate($request, [
            'title' => 'bail|required|min:4|max:255',
            'slug' => 'bail|required|max:255|unique:books,slug,' . $book->id,
            'description' => 'bail|required|min:4',
            'price' => 'bail|required|numeric',
            'stock' => 'bail|required|integer|min:0',
            'user_id' => 'bail|required|integer',
            'genres' => 'required',
            'newImages' => 'nullable|array',
            'newImages.*' => 'bail|base64image|base64max:9999'
        ]);

        $book->title = $request->title;
        $book->slug = $request->slug;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->stock = $request->stock;
        $book->user_id = $request->user_id;
        $book->save();
        $book->genres()->detach();
        foreach ($request->genres as $genre) {
            $genreDB = Genre::find($genre['id']);
            $book->genres()->attach($genreDB);
        }
        if (!empty($request->newImages)) {
            foreach ($request->newImages as $newImage) {
                $exploded = explode(',', $newImage);
                $decoded = base64_decode($exploded[1]);
                if (str_contains($exploded[0], 'jpeg')) {
                    $extension = "jpeg";
                } else if (str_contains($exploded[0], 'png')) {
                    $extension = "png";
                } else if (str_contains($exploded[0], 'jpg')) {
                    $extension = "jpg";
                }
                $fileNameToStore = Str::random(10) . '_' . time() . '.' . $extension;
                $path = '\\public\\images\\books\\' . $book->id . '\\' . $fileNameToStore;
                $fileNameToDB = '/storage/images/books/' . $book->id . '/' . $fileNameToStore;
                Storage::put($path, $decoded);
                $image = new Image();
                $image->name = $fileNameToDB;
                $image->book_id = $book->id;
                $image->save();
            }
        }
        if (!empty($request->deletedImages)) {
            foreach ($request->deletedImages as $deletedImg) {
                Image::find($deletedImg['id'])->delete();
                $bookImg = explode('/storage/images/books/', $deletedImg['name']);
                $path =  "/public/images/books/" . $bookImg[1];
                Storage::delete($path);
            }
        }

        return response()->json([
            'message' => 'book has been updated',
            'book' => $book
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
        $book = Book::findOrFail($id);
        $book->delete();
        Storage::deleteDirectory('/public/images/books/' . $book->id);
        return response()->json([
            'message' => "book has been deleted",
        ], 200);
    }
    public function bulk_destroy($ids)
    {
        
        $idsExploded = explode(',', $ids);
        foreach ($idsExploded as $id) {
            $book =  Book::findOrFail($id);
            $book->delete();
            Storage::deleteDirectory('/public/images/books/' . $book->id);
        }
        return response()->json([
            'message' => "books have been deleted",
        ], 200);
    }
}
