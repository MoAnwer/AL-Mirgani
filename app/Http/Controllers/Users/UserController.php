<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\DeleteUserNotification;
use App\Notifications\NewUserNotification;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{

    function __construct(
        private User $user,
        private readonly UserService $userService
    ) {}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->userService->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->userService->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->userService->store($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return $this->userService->edit($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        return $this->userService->update($request, $user);
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

            Notification::send(User::all(), new DeleteUserNotification($user));

            return to_route('users.index')->with('message', __('app.delete_successful', ['attribute' => __('app.user')]));

        } catch (\Throwable $th) {

            report($th);

            return to_route('users.create')->with('error', __('app.error' . ' ' . $th->getMessage()));
        }
    }
}
