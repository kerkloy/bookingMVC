<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promos = DB::select("
            SELECT 
                promo_id, 
                MAX(created_at) as latest_created_at,
                MAX(promo_header) as promo_header
            FROM promos 
            GROUP BY promo_id
        ");

        // dd($promos);

        return view('promos.promos', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('promos.add-promo');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $request->validate([
            'promoHeader' => 'required|string|max:255',
            // 'description' => 'required|array|max:255',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $promo_id = DB::select('SELECT MAX(promo_id) as pro FROM promos');
        $pr_id = !empty($promo_id) && !empty($promo_id[0]->pro) ? $promo_id[0]->pro + 1 : 1;

        // Handle the image upload
        if ($request->hasFile('img')) {
            $fileName = time() . '.' . $request->file('img')->getClientOriginalExtension();
            $request->file('img')->move(public_path('uploads'), $fileName);

            for($i = 0; $i < count($data['lines']); $i++){
                DB::table('promos')->insert([
                    'promo_id' => $pr_id,
                    'promo_header' => $request->input('promoHeader'),
                    'description' =>$data['lines'][$i]['description'],
                    'image_url' => 'uploads/' . $fileName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return response()->json(['message' => 'Promo created successfully!'], 201);
        }

        return response()->json(['error' => 'Image upload failed.'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::SELECT('SELECT * FROM promos WHERE promo_id = ' . $id);
        // dd($data);
        // return response()->json(['promo' => $data]);
        return view('promos.add-promo', ['promo' => $data]);
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'promoHeader' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $promo = DB::table('promos')->where('promo_id', $id)->first();

        if (!$promo) {
            return response()->json(['error' => 'Promo not found.'], 404);
        }

        // Handle the image upload if a new one is provided
        if ($request->hasFile('img')) {
            $fileName = time() . '.' . $request->file('img')->getClientOriginalExtension();
            $request->file('img')->move(public_path('uploads'), $fileName);
            $imageUrl = 'uploads/' . $fileName;
        } else {
            $imageUrl = $promo->image_url; // Use existing image if no new image is uploaded
        }

        // Update promo header and image
        DB::table('promos')->where('promo_id', $id)->update([
            'promo_header' => $request->input('promoHeader'),
            'image_url' => $imageUrl,
            'updated_at' => now(),
        ]);

        // Update existing descriptions or insert new ones
        $data = $request->all();
        foreach ($data['lines'] as $line) {
            DB::table('promos')->updateOrInsert(
                ['promo_id' => $id, 'description' => $line['description']],
                ['updated_at' => now()]
            );
        }

        // Delete removed descriptions if any
        if (isset($data['deleted'])) {
            foreach ($data['deleted'] as $descriptionId) {
                DB::table('promos')
                    ->where('promo_id', $id)
                    ->where('description', $descriptionId)
                    ->delete();
            }
        }

        return response()->json(['message' => 'Promo updated successfully!']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getPromo() {
        $promos = DB::select("
            SELECT 
                promo_id, 
                MAX(created_at) as latest_created_at,
                MAX(promo_header) as promo_header
            FROM promos 
            GROUP BY promo_id
        ");
        return response()->json($promos);
    }
    
}
