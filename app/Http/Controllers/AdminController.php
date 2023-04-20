<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message'=>'User Logout Sucessfully',
            'alert-type'=>'info'
        );

        return redirect('/login')->with($notification);
    }

    public function profile(){
        $id=Auth::user()->id;
        $adminData=User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));
    }
    public function editProfile(){
        $id=Auth::user()->id;
        $editData=User::find($id);
        return view('admin.admin_profile_edit',compact('editData'));
    }
    public function updateProfile(Request $request){
        $id=Auth::user()->id;
        $data=User::find($id);
        $data->name=$request->name;
        $data->email=$request->email;
        if($request->hasFile('profile_image')){

            $filenameWithExt=$request->file('profile_image')->getClientOriginalName();


            //get just filename
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);

            //GET JUST EXTENSION
            $ext=$request->file('profile_image')->getClientOriginalExtension();

            $fileNameToStore=$filename ."_".time().".".$ext;

            // $path=$request->file('profile_image')->storeAs('upload/admin_images',$fileNameToStore);

            $request->file('profile_image')->move(public_path('upload/admin_images'),$fileNameToStore);

        }else{
            $fileNameToStore='noimage.jpg';
        }
        $data->profile_image= $fileNameToStore;
        $data->save();
        $notification = array(
            'message'=>'Admin Profile Updated Sucessfully',
            'alert-type'=>'info'
        );
        return redirect()->route('admin.profile')->with($notification);
    }

    public function changePassword(){
        return view('admin.change_password');
    }
     public function updatePassword(Request $request)
    {
        # code...
        $validateData=$request->validate(
            [
                'oldpassword'=>'required',
                'newpassword'=>'required',
                'confirm_password'=>'required|same:newpassword'
            ]
        );
        $hashedPassword=Auth::user()->password;
        if(Hash::check($request->oldpassword,$hashedPassword)){
            $user=Auth::user()->id;
            $user->password=bcrypt($request->newpassword);
            $user->save();
            session()->flash('message','Password updated sucessfully');
            return redirect()->back();
        }else{
            session()->flash('message','Old Password did not match');
            return redirect()->back();
        }

    }
}
