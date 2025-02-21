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
            'promoType' => 'required|string|max:255',
            'promoPrice' => 'required',
            'promoLocation' => 'required|string|max:255',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $promo_id = DB::select('SELECT MAX(promo_id) as pro FROM promos');
        $pr_id = !empty($promo_id) && !empty($promo_id[0]->pro) ? $promo_id[0]->pro + 1 : 1;

        // Handle the image upload
        if ($request->hasFile('img')) {
            $fileName = time() . '.' . $request->file('img')->getClientOriginalExtension();
            $request->file('img')->move(public_path('uploads'), $fileName);

            DB::table('promos')->insert([
                'promo_id' => $pr_id,
                'promo_type' => $request->input('promoType'),
                'promo_price' => $request->input('promoPrice'),
                'promo_location' => $request->input('promoLocation'),
                'promo_header' => $request->input('promoHeader'),
                'image_url' => 'uploads/' . $fileName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            for($i = 0; $i < count($data['lines']); $i++){
                DB::table('promo_inclusions')->insert([
                    'promo_id' => $pr_id,
                    'inclusion' =>$data['lines'][$i]['description'],
                ]);
            }

            for($j = 0; $j < count($data['exclusions']); $j++) {
                DB::table('promo_exclusions')-> insert([
                    'promo_id' => $pr_id,
                    'exclusion' => $data['exclusions'][$j]['exclusion']
                ]);
            }

            for($k = 0; $k < count($data['itineraries']); $k++) {
                DB::table('promo_itinerary')-> insert([
                    'promo_id' => $pr_id,
                    'itinerary' => $data['itineraries'][$k]['itinerary']
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
        // $data = DB::SELECT('SELECT DISTINCT * FROM promos as p INNER JOIN promo_exclusions as pe WHERE p.promo_id = ' . $id . ' AND pe.promo_id = ' . $id);
        $promos = DB::SELECT('SELECT * FROM promos WHERE promo_id = ' . $id);
        $inclusions = DB::SELECT('SELECT * FROM promo_inclusions WHERE promo_id =' .$id);
        $exclusions = DB::SELECT('SELECT * FROM promo_exclusions WHERE promo_id =' .$id);
        $itineraries = DB::SELECT('SELECT * FROM promo_itinerary WHERE promo_id =' .$id);

        $data = [];

        foreach ($promos as $promo) {
            $data= (array) $promo;
            $data['inclusions'] = [];
            $data['exclusions'] = [];
            $data['itineraries'] = [];
        }

        foreach ($inclusions as $inclusion) {
            $data['inclusions'][] = $inclusion->inclusion;
        }
        foreach($exclusions as $exclusion) {
            $data['exclusions'][] = $exclusion->exclusion;
        }
        foreach($itineraries as $itinerary) {
            $data['itineraries'][] = $itinerary->itinerary;
        }
        // dd($promos, $inclusions, $exclusions);
        // return response()->json(['promo' => $data]);
        // dd($data);
        return view('promos.add-promo', ['promo' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {  
        // Validate the request
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

        return response()->json(['message' => 'Promo updated successfully!']);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promo = DB::table('promos')->where('promo_id', $id)->first();

        if (!$promo) {
            return response()->json(['error' => 'Promo not found.'], 404);
        }

        DB::table('promos')->where('promo_id', $id)->delete();

        return response()->json(['message' => 'Promo deleted successfully!']);
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

    public function getAllPromoDetails() {
        $promos = DB::select("SELECT * FROM promos");
        $inclusions = DB::select("SELECT * FROM promo_inclusions");
        $exclusions = DB::select("SELECT * FROM promo_exclusions");
    
        $groupedPromos = [];
    
        foreach ($promos as $promo) {
            $promoId = $promo->promo_id;
            $groupedPromos[$promoId] = (array) $promo;
            $groupedPromos[$promoId]['inclusions'] = [];
            $groupedPromos[$promoId]['exclusions'] = [];
        }
        foreach ($inclusions as $inclusion) {
            $groupedPromos[$inclusion->promo_id]['inclusions'][] = $inclusion->inclusion;
        }
        foreach ($exclusions as $exclusion) {
            $groupedPromos[$exclusion->promo_id]['exclusions'][] = $exclusion->exclusion;
        }
        return response()->json(array_values($groupedPromos));
    }

    public function getPromoInfo($id) {
        // Use prepared statements to prevent SQL injection
        $promo = DB::select("SELECT * FROM promos WHERE promo_id = ?", [$id]);
    
        // Check if promo exists
        if (empty($promo)) {
            return response()->json(['error' => 'Promo not found.'], 404);
        }
    
        // Fetch related data
        $inclusions = DB::select("SELECT * FROM promo_inclusions WHERE promo_id = ?", [$id]);
        $exclusions = DB::select("SELECT * FROM promo_exclusions WHERE promo_id = ?", [$id]);
        $itineraries = DB::select("SELECT * FROM promo_itinerary WHERE promo_id = ?", [$id]);
    
        // Convert promo object to array
        $promoInfo = [];
        foreach ($promo as $pr) {
            $promoID = $pr->promo_id;
            $promoInfo = (array) $pr;
            $promoInfo[$promoID]['inclusions'] = [];
            $promoInfo[$promoID]['exclusions'] = [];
            $promoInfo[$promoID]['itineraries'] = [];
        }
    
        // Append related data
        foreach ($inclusions as $inclusion) {
            $promoInfo[$id]['inclusions'][] = $inclusion->inclusion;
        }
        foreach ($exclusions as $exclusion) {
            $promoInfo[$id]['exclusions'][] = $exclusion->exclusion;
        }
        foreach ($itineraries as $itinerary) {
            $promoInfo[$id]['itineraries'][] = $itinerary->itinerary;
        }

        // dd($promoInfo);
    
        // Return view with data
        return view('promos.view-promo', ['promoInfos' => $promoInfo]);
    }
    
    
}
