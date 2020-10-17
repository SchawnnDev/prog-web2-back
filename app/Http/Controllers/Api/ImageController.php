<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageCollection;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image as Img;

class ImageController extends Controller
{

    private $photos_path;

    public function __construct()
    {
        $this->photos_path = storage_path('app/images/events');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ImageCollection
     */
    public function index(Request $request)
    {
        $images = Image::paginate($request->has('per_page') ? intval($request->get('per_page')) : 15);
        return new ImageCollection($images);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required|string|max:64',
            'description' => 'required|string',
            'image' => 'required|image'
        ]);

        $image = $request->file('image');
        $name = sha1(date('YmdHis') . Str::random(32));
        $save_name = $name . '.' . $image->getClientOriginalExtension();

        Img::make($image)->orientate()->save($this->photos_path . '/' . $save_name);

        //'id', 'title', 'description', 'old_name', 'path'
        $upload = new Image();
        $upload->id = sha1(date('YmdHis') . Str::random(32));
        $upload->title = $attributes['title'];
        $upload->description = $attributes['description'];
        $upload->name = $save_name;
        $upload->old_name = basename($image->getClientOriginalName());
        $upload->save();

        return new ImageResource($upload);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
