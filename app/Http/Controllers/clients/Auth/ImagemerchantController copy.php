<?php

namespace App\Http\Controllers\clients\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Traits\UploadImageTraitt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageclientController extends Controller
{
    Use UploadImageTraitt;

    //* function Store Image Client
    public function store(Request $request)
    {
        $request->validate([
            'imageclient' => ['required'],
        ],[
            'imageclient.required' =>__('Dashboard/messages.imageuserrequired'),
        ]);

        try{
            $input = $request->all();
            $idimageclient = Auth::guard('clients')->user()->id;
            $tableimageclient = Client::where('id','=',$idimageclient)->first();

            if(!empty($input['imageclient'])){
                $path = $this->uploadImagecl($request, 'imageclient');
                DB::beginTransaction();
                $tableimageclient->update([
                    'image'=>$path
                ]);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.add'));
                return redirect()->route('profileclient.edit');
            }else{
                toastr()->error(trans('Dashboard/messages.imageuserrequired'));
                return redirect()->route('profileclient.edit');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->success(trans('Dashboard/messages.err'));
            return redirect()->route('profileclient.edit');
        }
    }

    //* function Update Image Client
    public function update(Request $request)
    {
        $request->validate([
            'imageclient' => ['required'],
        ],[
            'imageclient.required' =>__('Dashboard/messages.imageuserrequired'),
        ]);
        try{
            $idimageclient = Auth::guard('clients')->user()->id;
            $tableimageclient = Client::where('id','=',$idimageclient)->first();
            if($request->has('imageclient')){
                    $image = $tableimageclient->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                    $image = $this->uploadImagecl($request, 'imageclient');
                    DB::beginTransaction();
                    $tableimageclient->update([
                        'image' => $image
                    ]);
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.edit'));
                    return redirect()->route('profileclient.edit');
            }
            else{
                toastr()->error(trans('Dashboard/messages.imageuserrequired'));
                return redirect()->route('profileclient.edit');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profileclient.edit');
        }
    }

    //* function Delete Image Client
    public function destroy(Request $request)
    {
        try{
            $id = Auth::guard('clients')->user()->id;
            $tableimageclient = Client::where('id','=',$id)->first();
            DB::beginTransaction();
                $tableimageclient->update([
                    'image' => ''
                ]);

                if ($tableimageclient->image && Storage::disk('public')->exists($tableimageclient->image)) {
                    Storage::disk('public')->delete($tableimageclient->image);
                }

            DB::commit();
            toastr()->success(trans('Dashboard/messages.delete'));
            return redirect()->route('profileclient.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profileclient.edit');
        }
    }
}
