<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusesController extends Controller
{

    public function index()
    {
        return StatusResource::collection(
        Status::latest()->paginate()
        );
    }

    public function store()
    {
        request()->validate(['body' => 'required|min:5']);

        $status = Status::create([
            'user_id' => auth()->user()->id,
            'body' => request('body')
            ]);

        return StatusResource::make($status);
    }
}
