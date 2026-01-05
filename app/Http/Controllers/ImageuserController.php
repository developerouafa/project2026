<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UploadImageTraitt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ImageuserController extends Controller
{
    Use UploadImageTraitt;

    //* function Store Image User
    public function store(Request $request)
    {
        $request->validate([
            'imageuser' => ['required'],
        ],[
            'imageuser.required' =>__('Dashboard/messages.imageuserrequired'),
        ]);

        try{
            $input = $request->all();
            $idimageuser = Auth::user()->id;
            $tableimageuser = User::where('id','=',$idimageuser)->first();

            if(!empty($input['imageuser'])){
                $path = $this->uploadImage($request, 'userimage');
                DB::beginTransaction();
                $tableimageuser->update([
                    'image'=>$path
                ]);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.add'));
                return redirect()->route('profile.edit');
            }else{
                toastr()->error(trans('Dashboard/messages.imageuserrequired'));
                return redirect()->route('profile.edit');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->success(trans('Dashboard/messages.err'));
            return redirect()->route('profile.edit');
        }
    }

    //* function Update Image User
    public function update(Request $request)
    {
        $request->validate([
            'imageuser' => ['required'],
        ],[
            'imageuser.required' =>__('Dashboard/messages.imageuserrequired'),
        ]);
        try{
            $idimageuser = Auth::user()->id;
            $tableimageuser = User::where('id','=',$idimageuser)->first();
            if($request->has('imageuser')){
                    $image = $tableimageuser->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                    $image = $this->uploadImage($request, 'userimage');
                    DB::beginTransaction();
                    $tableimageuser->update([
                        'image' => $image
                    ]);
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.edit'));
                    return redirect()->route('profile.edit');
            }
            else{
                toastr()->error(trans('Dashboard/messages.imageuserrequired'));
                return redirect()->route('profile.edit');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profile.edit');
        }
    }

    //* function Delete Image User
    public function destroy(Request $request)
    {
        try{
            $id = Auth::user()->id;
            $tableimageuser = User::where('id','=',$id)->first();
            DB::beginTransaction();
                $tableimageuser->update([
                    'image' => ''
                ]);
            $image = $tableimageuser->image;
            if(!$image) abort(404);
            unlink(public_path('storage/'.$image));
            DB::commit();
            toastr()->success(trans('Dashboard/messages.delete'));
            return redirect()->route('profile.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profile.edit');
        }
    }
}
