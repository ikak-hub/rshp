<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoleUser; // Import model RoleUser

class RoleUserController extends Controller
{
    public function index()
    {
        $roleUsers = RoleUser::with(['user', 'role'])->get(); // Eager load relasi user dan role
        return view('admin.role-user.index', compact('roleUsers'));
    }
}
