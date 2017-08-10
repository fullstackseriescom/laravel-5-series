<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
  public function index() {
    $users = User::all();
    $roles = Role::pluck('name', 'name');
    return view('admin.users.index', ['users' => $users, 'roles' => $roles]);
  }

  public function activeDeactive(Request $request) {
    if (Auth::id() != $request->user_id) {
      $user = User::findOrFail($request->user_id);
      $user->active = !$user->active;
      $user->save();
      return redirect()->route("admin.users.index")->with('success', $user->name." status has been changed!");
    } else  {
      return redirect()->back()->withErrors(['You can\'t change your status!']);
    }
  }

  public function changeRole(Request $request) {
    if (Auth::id() != $request->user_id) {
      $user = User::findOrFail($request->user_id);
      $user->syncRoles($request->role);
      return redirect()->route("admin.users.index")->with('success', $user->name." role has been changed!");
    } else  {
      return redirect()->back()->withErrors(['You can\'t change your role!']);
    }
  }
}
