<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\DeleteUserNotification;
use App\Notifications\NewUserNotification;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{

    function __construct(
        private User $user
    ) {}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->user->latest()->paginate(15);

        return view('users.users_list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create-user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'name' => 'required|string',
                'username' => 'required|string|unique:users,username',
                'password' => 'required|min:6'
            ], [
                'username.unique' => __('validation.unique', ['attribute' => __('app.username')]),
                'password.min'  => __('validation.min.numeric', ['min' => 6, 'attribute' => __('app.password')])
            ]);

            $user = $this->user->create($data);

            auth()->user()->notify(new NewUserNotification($user));
            
            return to_route('users.index')->with('message', __('app.create_successful', ['attribute' => __('app.user')]));

        } catch (\Throwable $th) {

            report($th);

            return to_route('users.create')->with('error', __('app.error')  . ' : ' . $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit-user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {

            $data = $request->validate([
                'name' => 'required|string',
                'username' => 'required|string',
            ]);

            $user->update($data);

            return to_route('users.index')->with('message', __('app.update_successful', ['attribute' => __('app.user')]));
        } catch (\Throwable $th) {

            report($th);

            return to_route('users.edit', $user)->with('error', __('app.error')  . ' : ' . $th->getMessage());
        }
    }

    /**
     * Show delete user page
     */
    public function delete(User $user)
    {
        try {

            if ($user->username == config('database.default_user.username')) {
                throw new Exception(__('app.remove_admin_msg'));
            }

            return view('users.delete-user', compact('user'));

        } catch (\Throwable $th) {

            report($th);

            return to_route('users.index')->with('error', __('app.error')  . ' : ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {

            $user->delete();

            auth()->user()->notify(new DeleteUserNotification($user));

            return to_route('users.index')->with('message', __('app.delete_successful', ['attribute' => __('app.user')]));

        } catch (\Throwable $th) {

            report($th);

            return to_route('users.create')->with('error', __('app.error' . ' ' . $th->getMessage()));
        }
    }
}
