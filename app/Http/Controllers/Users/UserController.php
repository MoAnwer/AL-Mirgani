<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
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
                'username' => 'required|string',
                'password' => 'required|min:6'
            ]);

            $this->user->create($data);

            return to_route('users.index')->with('message', __('app.create_successful', ['attribute' => __('app.user')]));

        } catch (\Throwable $th) {
            
            report($th);

            return to_route('users.create')->with('error', __('app.error' .' ' . $th->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
