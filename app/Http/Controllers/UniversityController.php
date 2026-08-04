<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        $universities = University::active()
            ->withCount(['properties', 'comments'])
            ->when($request->type, fn($q, $v) => $q->where('type', $v))
            ->paginate(12);

        return view('universities.index', compact('universities'));
    }

    public function show(University $university)
    {
        abort_if(!$university->is_active, 404);

        $university->load(['comments.user', 'comments.replies.user']);
        $relatedProperties = $university->properties()
            ->active()
            ->with(['images'])
            ->orderByPivot('distance')
            ->take(6)
            ->get();

        return view('universities.show', compact('university', 'relatedProperties'));
    }
}
