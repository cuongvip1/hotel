<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    private ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function home()
    {
        return view('public.home');
    }

    public function listing(Request $request)
    {
        $data = $this->api->get('bai-dang', $request->only('min', 'max', 'page'));

        return view('public.listing', [
            'data' => $data,
            'filters' => $request->only('min', 'max'),
        ]);
    }


    public function detail($id)
    {
        $item = $this->api->get("/api/bai-dang/{$id}");
        return view('public.detail', compact('item'));
    }
}
