<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageCollection;
use App\Http\Resources\ImageResource;
use App\Mail\ContactMail;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Image as Img;

class ContactController extends Controller
{
    private $receiver;

    public function __construct()
    {
        $this->receiver = env('CONTACT_EMAIL', 'contact@schawnndev.fr');
    }

    /**
     * Send mail
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|string|max:64',
            'email' => 'required|email:rfc,dns',
            'message' => 'required|string|max:2048'
        ]);

        $email = new \App\Models\Mail($attributes);

        Mail::to($this->receiver)->send(new ContactMail($email));

        return $email;
    }


}
