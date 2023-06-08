<?php

namespace App\Http\Controllers\Api\V1;

use GuzzleHttp\Client;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

         if (!request('category')) {
            return ProductsResource::collection(Products::paginate(15));
         } 
         
         $query = Products::query();
         $query = $query->when(request('category'), function($query) {
             $query->where('category', "like", '%'.request('category').'%');
         });

         return $query->paginate(15);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request)
    {
        $product = Products::create($request->validated());

        return [
            'message' => 'Product with ID: '. $product->id . ' have been created',
            'details'=> ProductsResource::make($product)
        ];

    }

    /**
     * Display the specified resource.
     */
    public function show(Products $product)
    {
        return [
            'message' => 'Requested ID: '. $product->id,
            'details'=> ProductsResource::make($product)
        ];
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Products $products)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request, Products $product)
    {
        $product->update($request->validated());


        $client = new Client();

        $res = $client->request('POST', 'http://httpbin.org/anything', [
            'json' => ProductsResource::make($product)
        ]);

        if ($res->getStatusCode() == 200) {
            $response_data = [
                'body' => json_decode($res->getBody()->getContents(), JSON_PRESERVE_ZERO_FRACTION),
            ];
            
        } else {
            $response_data = [
                'error' => $res->getStatusCode(), 
            ];
        }

        if ($response_data) {
            return [
                'message' => 'Product: '. $product->name .' has been updated',
                'details'=> ProductsResource::make($product),
                'details from external API' => $response_data
            ];
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        //
    }
}
