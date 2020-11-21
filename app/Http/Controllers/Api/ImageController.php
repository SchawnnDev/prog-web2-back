<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageCollection;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image as Img;

class ImageController extends Controller
{

    /**
     * Chemin du stockage des photos
     * @var string
     */
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
        $images = Image::orderBy('created_at', 'desc')->paginate($request->has('per_page') ? intval($request->get('per_page')) : 15);
        return new ImageCollection($images);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ImageResource
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
     * @return ImageResource
     */
    public function show(Image $image)
    {
        Log::debug('show: ' . $image->id);
        return new ImageResource($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Image $image
     * @return ImageResource
     * @throws Exception
     */
    public function update(Request $request, Image $image)
    {
        $attributes = $request->validate([
            'title' => 'string|max:64',
            'description' => 'string',
            'image' => 'image'
        ]);

        if ($request->has('image')) {
            $image_file = $request->file('image');
            $name = sha1(date('YmdHis') . Str::random(32));
            $save_name = $name . '.' . $image_file->getClientOriginalExtension();

            try {
                $this->destroy($image);
            } catch (Exception $e) {
                throw $e;
            }

            Img::make($image_file)->orientate()->save($this->photos_path . '/' . $save_name);
            $image->name = $save_name;
            $image->old_name = basename($image_file->getClientOriginalName());
        }

        if($request->has('title'))
            $image->title = $attributes['title'];

        if($request->has('description'))
            $image->description = $attributes['description'];

        if(count($attributes) > 0)
            $image->save();

        return new ImageResource($image);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Image $image
     * @return ImageResource
     * @throws Exception
     */
    public function destroy(Image $image)
    {
        try {

            // on supprime localement
            Storage::delete('images/events/' . $image->name);

            // on supprime de la bdd
            $image->delete();

            return new ImageResource($image);
        } catch (Exception $e) {
            throw $e;
        }

    }
}
