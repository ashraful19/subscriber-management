<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Subscriber;
use Response;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        return Response::json([
            'subscribers_count' => Subscriber::count(),
            'fields_count' => Field::count()
        ]);
    }
}
