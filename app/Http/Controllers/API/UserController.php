<?php

namespace App\Http\Controllers\API;

use App\Role;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Routing\Matcher\ExpressionLanguageProvider;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('roles')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:2000',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|numeric',
            'bio' => 'nullable|string|max:2000',
            'roles' => 'required',
            // 'avatar' => 'nullable|image64:jpeg,jpg,png'
            'avatar' => 'nullable|base64image|base64max:9999'
        ], [
            'name.required' => "Merci de remplir le nom"  //custom validation messages
        ]);

        $user = new User();

        //Handle File Upload
        if ($request->avatar != "") {

            $exploded = explode(',', $request->avatar);
            $decoded = base64_decode($exploded[1]);
            if (str_contains($exploded[0], 'jpeg')) {
                $extension = "jpeg";
            } else if (str_contains($exploded[0], 'png')) {
                $extension = "png";
            }
            $fileNameToStore = Str::random(10) . '_' . auth()->id() . '.' . $extension;
            $path = '\\public\\images\\users\\' . $fileNameToStore;
            $fileNameToDB = '/storage/images/users/' . $fileNameToStore;
            Storage::put($path, $decoded);
            $user->avatar = $fileNameToDB;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zip = $request->zip;
        $user->bio = $request->bio;
        $user->password = Hash::make($request->password);
        $user->save();
        foreach ($request->roles as $role) {
            $roleDB = Role::find($role['id']);
            $user->roles()->attach($roleDB);
        }

        return json_encode([
            'message' => 'user has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);

        return response()->json([
            'user' => $user,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->avatar != $user->avatar) {
            $avatarValidRules = "nullable|image64:jpeg,jpg,png";
        } else {
            $avatarValidRules = "nullable";
        }
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:2000',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|numeric',
            'bio' => 'nullable|string|max:2000',
            'roles' => 'required',
            'avatar' => $avatarValidRules

        ], [
            'name.required' => "Merci de remplir le nom"  //custom validation messages
        ]);
        //Handle File Upload
        if ($request->avatar !== $user->avatar) {
            if ($user->avatar != '/storage/images/users/noavataruser.jpg') {
                $user->deleteOldAvatar();
            }
            $exploded = explode(',', $request->avatar);
            $decoded = base64_decode($exploded[1]);
            if (str_contains($exploded[0], 'jpeg')) {
                $extension = "jpeg";
            } else if (str_contains($exploded[0], 'png')) {
                $extension = "png";
            }
            $fileNameToStore = Str::random(10) . '_' . auth()->id() . '.' . $extension;
            $path = '\\public\\images\\users\\' . $fileNameToStore;
            $fileNameToDB = '/storage/images/users/' . $fileNameToStore;
            Storage::put($path, $decoded);
            $user->avatar = $fileNameToDB;
        }
        $user->name = $request->name;
        if (!$user->provider) {
            $user->email = $request->email;
        }
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zip = $request->zip;
        $user->bio = $request->bio;
        $user->save();
        $user->roles()->detach();
        foreach ($request->roles as $role) {
            $roleDB = Role::find($role['id']);
            $user->roles()->attach($roleDB);
        }
        return response()->json([
            'message' => "user Info have been updated",

        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->avatar != '/storage/images/users/noavataruser.jpg') {
            $user->deleteOldAvatar();
        }
        $user->delete();
        return response()->json([
            'message' => "user has been deleted",
        ], 200);
    }

    /**
     * Return authors
     *
     * @return \Illuminate\Http\Response
     */
    public function authors()
    {
        return  Role::where('name', 'author')->first()->users;
    }
}
