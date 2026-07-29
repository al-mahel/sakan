<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Models\UniversityComment;
use Illuminate\Http\Request;

class UniversityCommentController extends Controller
{
    public function store(Request $request, University $university)
    {
        $validated = $request->validate([
            'body'   => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
        ], [
            'body.required' => 'الرأي مطلوب',
            'body.max'      => 'الرأي يجب ألا يتجاوز 1000 حرف',
        ]);

        UniversityComment::create([
            'university_id' => $university->id,
            'user_id'       => auth()->id(),
            'body'          => $validated['body'],
            'rating'        => $validated['rating'] ?? null,
            'parent_id'     => null,
        ]);

        return back()->with('success', 'تم إضافة رأيك بنجاح ✓');
    }

    public function reply(Request $request, UniversityComment $comment)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:500',
        ], [
            'body.required' => 'الرد مطلوب',
        ]);

        UniversityComment::create([
            'university_id' => $comment->university_id,
            'user_id'       => auth()->id(),
            'parent_id'     => $comment->id,
            'body'          => $validated['body'],
        ]);

        return back()->with('success', 'تم إضافة ردك بنجاح ✓');
    }
}
