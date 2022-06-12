<?php

namespace App\Http\Controllers;

use App\Http\Resources\LinkResource;
use App\Jobs\LinkCreated;
use App\Models\Link;
use App\Models\LinkProduct;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index($id)
    {
        $links = Link::with('orders')->where('user_id', $id)->get();

        return LinkResource::collection($links);
    }
}
