<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackStoreRequest;
use App\Models\Feedback;
use Exception;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(FeedbackStoreRequest $request)
    {
        try {
            if ($request->has('anonymous')) {
                $feedback = Feedback::create(array_merge($request->validated(), [
                    'anonymous' => true,
                    'user_id' => auth()->user()->id,
                ]));
            } else {
                $feedback = Feedback::create(array_merge($request->validated(), [
                    'user_id' => auth()->user()->id,
                ]));
            }

            if ($feedback) {
                return redirect()->route('home.index');
            }
        } catch (Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }
}
