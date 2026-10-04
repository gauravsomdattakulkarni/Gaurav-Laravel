<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BucketController extends Controller
{
    public function images()
    {
        $path = "/images";
        $files = Storage::disk('s3')->files($path);
       
        $data['files'] = $files;

        return view('bucket_manager',$data);
    }

    public function upload_images_success(Request $request)
    {
        $request->validate(['image' => 'required|image']);
        $path = $request->file('image')->store('images', 's3');
        Storage::disk('s3')->setVisibility($path, 'public');
        return redirect()->route('images')->with('success', 'Image uploaded successfully.');
    }

    public function delete_image(Request $request)
    {
        $key = $request->input('file_to_delete');
        Storage::disk('s3')->delete($key);
        return redirect()->route('images')->with('success', 'Image deleted successfully.');
    }
}
