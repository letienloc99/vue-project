<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->select('users.*', 'user_status.name as status', 'departments.name as department')
            ->join('departments', 'departments.id', '=', 'users.department_id')
            ->join('user_status', 'user_status.id', '=', 'users.status_id')
            ->get();
        return $this->sendResponseSuccess($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_status = DB::table('user_status')->select(
            'id as value',
            'name as label',
        )->get();
        $department = DB::table('departments')->select(
            'id as value',
            'name as label',
        )->get();
        return $this->sendResponseSuccess([
            'status' => $user_status,
            'department' => $department
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        User::create($data);
        return $this->sendResponseSuccess('success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return User::findOrFail($id);
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
    public function update(UserUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $data['change_password_at'] = Carbon::now();
        if (!$data['password']) {
            $data = Arr::except($data, ['password', 'change_password_at']);
        }
        User::findOrFail($id)->update($data);
        return $this->sendResponseSuccess('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return $this->sendResponseSuccess('success');
    }
}
