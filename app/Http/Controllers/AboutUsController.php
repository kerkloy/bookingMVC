<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AboutUsController extends Controller
{
    public function index() {
        return view('about-us.about-us');
    }

    public function addAboutUsImage(Request $request) {
        // Validate the incoming request
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validate the image
        ]);
    
        // Get the uploaded file
        $image = $request->file('img');
    
        // Define the file path where you want to store the image (in the public folder)
        $destinationPath = 'uploads/about_us'; // Path relative to the public folder
    
        // Get the file's original name and store it in the destination path
        $imageName = time().'_'.$image->getClientOriginalName();
        $image->move(public_path($destinationPath), $imageName);
    
        // Save the file path into the database
        DB::insert("INSERT INTO about_us_img (image_path, description, title) VALUES (?, ?, ?)", [
            $destinationPath . '/' . $imageName, // Save the file path
            $request->input('description'),
            $request->input('title')
        ]);
    
        return response()->json(['success' => 'Image uploaded successfully']);
    }

    public function deleteAboutUsImage($id)
    {
        // Fetch the image record from the database
        $image = DB::table('about_us_img')->where('id', $id)->first();

        if ($image) {
            // Optionally delete the image file from storage
            $imagePath = public_path($image->image_path);
            if (File::exists($imagePath)) {
                File::delete($imagePath); // Delete the file from the storage
            }

            // Delete the image record from the database
            DB::table('about_us_img')->where('id', $id)->delete();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Image not found'], 404);
        }
    }

    public function getUploadedImages() {
        $images = DB::select("SELECT id, description, image_path, title FROM about_us_img");
        return response()->json($images);
    }

    public function updateAboutUsContent(Request $request) {
        $aboutHeader = $request->input('aboutHeader');
        $aboutParagraph = $request->input('aboutContent');

        DB::update("UPDATE `about-us_content` SET aboutHeader =?, aboutParagraph =? WHERE id =1", [
            $aboutHeader,
            $aboutParagraph,
        ]);

        return response()->json(['success' => 'About Us content updated successfully']);
    }

    public function getContent() {
        $content = DB::select("SELECT aboutHeader, aboutParagraph FROM `about-us_content` WHERE id =1");
        return response()->json($content);
    }
    
}
