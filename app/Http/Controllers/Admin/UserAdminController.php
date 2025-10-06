<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserAdminController extends Controller
{
    // GET /admin/users  (รายการ + ค้นหา/กรอง)
    public function index(Request $request)
    {
        $q    = trim($request->input('q', ''));
        $role = $request->input('role_id');

        $users = User::query()
            ->with('role')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('username', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%")
                      ->orWhere('first_name', 'like', "%{$q}%")
                      ->orWhere('last_name', 'like', "%{$q}%");
                });
            })
            ->when($role, fn ($query) => $query->where('role_id', $role))
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        $roles = Role::orderBy('role_id')->get();

        return view('admin.users.index', compact('users', 'roles', 'q', 'role'));
    }

    // GET /admin/users/{user}/edit
    public function edit(User $user)
    {
        $roles = Role::orderBy('role_id')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // PUT /admin/users/{user}
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => ['nullable', 'string', 'max:100'],
            'last_name'  => ['nullable', 'string', 'max:100'],
            'email'      => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'username'   => ['required','alpha_dash','max:50', Rule::unique('users','username')->ignore($user->id)],
            'role_id'    => ['required','integer','exists:roles,role_id'],
        ]);

        // กันไม่ให้เหลือ admin 0 คน (หากลดสิทธิ์ตัวเอง)
        if ($user->id === auth()->id() && (int)$data['role_id'] !== (int)$user->role_id) {
            $otherAdmins = User::where('id','!=',$user->id)
                ->whereHas('role', fn($q)=>$q->where('role_name','admin'))
                ->exists();
            if (!$otherAdmins) {
                return back()->withErrors(['role_id' => 'ต้องเหลือผู้ดูแลระบบอย่างน้อย 1 คน']);
            }
        }

        $user->fill($data)->save();

        return redirect()->route('admin.users.index')->with('ok', 'อัปเดตข้อมูลผู้ใช้เรียบร้อย');
    }

    // DELETE /admin/users/{user}  (ถ้าต้องการ)
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['delete' => 'ไม่สามารถลบบัญชีตัวเองได้']);
        }
        $user->delete();
        return back()->with('ok', 'ลบผู้ใช้เรียบร้อย');
    }
}
