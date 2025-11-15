<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ForgotPasswordController extends Controller
{
    public function checkUserNamePage()
    {
        return view('auth.check_username');
    }


    public function verifyAccount(Request $request)
    {
        try {

            $data = $request->validate([
                'username'  => 'required|exists:users,username',
            ], [
                'exists' => __('auth.fails')
            ], [
                'username'  =>  __('app.username'),
            ]);

            session()->put('username',  $data['username']);

            return to_route('auth.forgot_password.page')->with('message', __('app.username_exists_msg', ['user' => $data['username']]));
        } catch (\Throwable $th) {

            report($th);

            return back()->with('error', __('app.error') . ' :' . $th->getMessage());
        }
    }

    /**
     * Show the form for creating the resource.
     */
    public function forgotPasswordPage(Request $request)
    {
        if (!session()->has('username')) {
            abort(404);
        }

        $username = strip_tags(session()->get('username'));

        $question = SecurityQuestion::whereHas('user', fn($q) => $q->where('username', $username))->take(1)->inRandomOrder()->value('question');

        return view('auth.forgot-password', compact('question'));
    }

    /**
     * Store the newly created resource in storage.
     */
    public function verifyAnswer(Request $request)
    {
        if (session()->has('username')) {

            try {

                $data = $request->validate([
                    'answer'  => 'required|exists:security_questions,answer',
                ], [
                    'exists' => __('auth.fails')
                ], [
                    'answer'  =>  __('app.answer'),
                ]);


                $username = session()->get('username');

                $check = SecurityQuestion::whereHas('user', fn($q) => $q->where('username', $username))->where('answer', $data['answer'])->get();

                if (null != $check) {

                    return to_route('auth.forgot_password.reset_password_page');
                    
                } else {

                    return back()->with('error', __('app.error') . ' :' . __('app.checking_error'));
                }

            } catch (\Throwable $th) {

                report($th);

                return back()->with('error', __('app.error') . ' :' . $th->getMessage());
            }

        } else {

            return back()->with('error', __('app.error') . ' :' . __('app.checking_error'));
        }
    }

    /**
     * Reset password page
     * @return  view
     */
    public function resetPasswordPage()
    {
        if (session()->has('username')) {
            return view('auth.reset-password');
        } else {
            return back()->with('error', __('app.error') . ' :' . __('app.checking_error'));
        }
    }

    /**
     * Reset password process 
     * @param Request $request
     */
    public function resetPasswordAction(Request $request)
    {
        
        if (session()->has('username')) {
            
            $user = User::where('username', session()->get('username'))->first();

            if ( $user == null ) {
                return back()->with('error', __('app.error') . ' :' . __('app.checking_error'));
            }

            try {

                $data = $request->validate([
                    'password' => 'required|min:6'
                ], [
                    'password.min'  => __('validation.min.numeric', ['min' => 6, 'attribute' => __('app.password')])
                ]);

                $user->forceFill([
                    'password' => bcrypt($data['password'])
                ]);

                $user->save();

                Notification::sendNow($user, new PasswordResetNotification($user));


                return to_route('login')->with('message', __('app.password_reset_successfully', ['user' => session()->get('username')]));

            } catch (\Throwable $th) {

                return back()->with('error', __('app.checking_error') . ' :'. $th->getMessage());    
            }

        } else {

            return back()->with('error', __('app.error') . ' :'. __('app.checking_error'));
        }
    }

}
