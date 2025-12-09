<?php

namespace App\Http\Controllers\SecurityQuestion;

use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use Illuminate\Http\Request;

class SecurityQuestionController extends Controller
{

    public function __construct(private readonly SecurityQuestion $securityQuestion) {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if ($this->securityQuestion->where('user_id', auth()->user()->id)->count() >= 3) {
            return back()->with('error', __('app.security_questions_limit_completed'));
        }
        return view('settings.create-security-question');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'question' => 'required|string',
                'answer' => 'required|string',
            ], [], [
                'question' => __('app.question'),
                'answer' => __('app.answer'),
            ]);

            $data['user_id'] = auth()->user()->id;

            $this->securityQuestion->create($data);

            return to_route('settings.page')->with('message', __('app.create_successful', ['attribute' => __('app.question')]));
        } catch (\Throwable $th) {

            report($th);

            return back()->with('error', __('validation.required', ['attribute' => __('app.question')])  .' - ' . __('validation.required', ['attribute' => __('app.answer')]));
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SecurityQuestion $securityQuestion)
    {
        if ($securityQuestion->user_id !== auth()->id()) {
            abort(403);
        }
        return view('settings.update-security-question', compact('securityQuestion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SecurityQuestion $securityQuestion)
    {
         try {

            if ($securityQuestion->user_id !== auth()->id()) {
                abort(403);
            }
            $data = $request->validate([
                'question' => 'required|string',
                'answer' => 'required|string',
            ], [], [
                'question' => __('app.question'),
                'answer' => __('app.answer'),
            ]);

            $securityQuestion->update($data);

            return to_route('settings.page')->with('message', __('app.update_successful', ['attribute' => __('app.question')]));

        } catch (\Throwable $th) {

            report($th);
            return back()->with('error', __('validation.required', ['attribute' => __('app.question')])  .' - ' . __('validation.required', ['attribute' => __('app.answer')]));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SecurityQuestion $securityQuestion)
    {
        if ($securityQuestion->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            $securityQuestion->delete();
            return to_route('settings.page')->with('message', __('app.delete_successful', ['attribute' => __('app.question')]));
        } catch (\Throwable $th) {
            report($th);
            return back()->with('error', __('app.error') . ' :' . __('app.checking_error'));
        }
    }
}
