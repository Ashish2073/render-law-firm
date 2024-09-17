<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\WelcomeMessageRepository;
use Illuminate\Database\Eloquent\Collection;

class HomeController extends Controller
{
    public function __construct(protected WelcomeMessageRepository $welcomeMessageRepository)
    {
    }

    public function index()
    {
        $welcomeMessages = $this->welcomeMessageRepository->all();

        return response()->json([
            'success' => true,
            'data' => Collection::make($welcomeMessages),
        ]);
    }
}
