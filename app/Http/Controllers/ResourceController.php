<?php

namespace App\Http\Controllers;

use App\Models\HealthResource;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(): View
    {
        return view('resources.index', [
            'resources' => HealthResource::query()
                ->where('is_verified', true)
                ->orderBy('service_type')
                ->orderBy('name')
                ->paginate(12),
        ]);
    }
}
