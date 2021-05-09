<?php

namespace App\Http\Controllers;

use App\BookOrder;
use App\User;
use App\Order;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $cartCount = Cart::instance('default')->count();
        $ordersCount = Order::where('user_id', auth()->id())->get()->count();
        $wishlistCount = Cart::instance('wishlist')->count();

        return view('pages.user.dashboard')->with([
            'cartCount' => $cartCount,
            'ordersCount' => $ordersCount,
            'wishlistCount' => $wishlistCount,
        ]);
    }
    public function profile()
    {
        return view('pages.user.profile');
    }
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::user()->id . ',id',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:2000',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|numeric',
            'bio' => 'nullable|string|max:2000',
            'avatar' => 'nullable|image|max:9999'
        ]);
        if ($validator->fails()) {
            session()->flash('error_alert', "Profile Info have not been Saved . Please enter Valid Data");
            return redirect()->back()->withErrors($validator);
        }

        $user = User::find(auth()->id());

        //Handle File Upload
        if ($request->hasFile('avatar')) {

            if ($user->avatar != '/storage/images/users/noavataruser.jpg') {
                $user->deleteOldAvatar();
            }


            $fileNameWithExt = $request->file('avatar')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . auth()->id() . '.' . $extension;
            $fileNameToDB = '/storage/images/users/' . $fileNameToStore;
            $path = $request->file('avatar')->storeAs('public/images/users/', $fileNameToStore);

            $user->avatar = $fileNameToDB;
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zip = $request->zip;
        $user->bio = $request->bio;
        if(!$user->provider){
          $user->email = $request->email;
        }
        $user->save();

        return redirect()->back()->with('success_alert', "Profile info have been saved successfully");
    }
    public function editPassword()
    {
        return view('pages.user.edit-password');
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'     => 'nullable',
            'new_password'     => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);
        $user_old_password = auth()->user()->password;
        if($user_old_password !=null){
            if (!Hash::check(request()->old_password, $user_old_password)) {
                return redirect()->back()->with('error_alert', "Old Password is incorrect");
            }
        }

        $user = User::find(auth()->id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->back()->with('success_alert', " Password has been changed successfully ");
    }

    public function userOrders()
    {


        $user =User::find(auth()->id());
        $userOrders = $user->orders()->paginate(5);
        return view('pages.user.orders')->with([
            'userOrders' => $userOrders
        ]);
    }
    public function userOrdersDetails($id)
    {
        $userOrder = Order::findOrFail($id);
        $userOrderDetails = $userOrder->detailsWithRemovedBooks();
        return view('pages.user.orders-details')->with([
            'userOrder' => $userOrder,
            'userOrderDetails' => $userOrderDetails
        ]);
    }
}
