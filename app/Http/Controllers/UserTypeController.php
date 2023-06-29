<?php

namespace App\Http\Controllers;

use App\Models\Permissions;
use App\Models\Routes;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserTypeController extends Controller
{
    public function index()
    {
        $routes = Routes::all();
        $usertypes = UserType::getData()->paginate(10);
        return view('pages.usertypes', compact(['routes', 'usertypes']));
    }

    public function add(Request $request)
    {
        $request->validate([
            'isnew' => 'required|in:1,2',
            'usertype' => 'required',
            'status' => 'required|in:1,2,3'
        ]);

        if ($request->isnew == 1) {
            $usertype = UserType::create([
                'usertype' => $request->usertype,
                'status' => $request->status,
            ]);

            if ($request->has('permissions')) {
                foreach ($request->permissions as $permisssion) {
                    Permissions::create([
                        'usertype' => $usertype->id,
                        'route' => $permisssion
                    ]);
                }
            }
        } else {
            $request->validate([
                'record' => 'required|exists:user_types,id'
            ]);
            $data = [
                'usertype' => $request->usertype,
            ];
            $usertypeExists = UserType::where('id', $request->record)->with('permissiondata')->first();
            $usertypeExists->update($data);
            $newPermissions = $request->permissions ?? [];
            foreach ($usertypeExists->permissiondata as $key => $value) {
                if (in_array($value->route, ($request->permissions ?? []))) {
                    array_splice($newPermissions, array_search($value->route, $newPermissions), 1);
                } else {
                    Permissions::where('id', $value->id)->delete();
                }
            }

            foreach ($newPermissions as $valueNew) {
                Permissions::create([
                    'usertype' => $usertypeExists->id,
                    'route' => $valueNew
                ]);
            }
        }
        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'Usertype & Permissions Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
    }

    public function changeStatus($id, $status)
    {
        $user = UserType::find($id);
        if ($user) {
            $user->update(['status' => $status]);
            return redirect()->back()->with(['resp' => ['msg' => 'Usertype Successfully Updated.', 'color' => 'success']]);
        }
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:user_types,id'
        ]);
        UserType::where('id', $request->id)->update(['status' => 3]);

        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'Usertype Successfully Removed']);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:user_types,id'
        ]);
        return UserType::where('id', $request->id)->with('permissionandroutesdata')->first();
    }
}
