<?php

namespace App\Http\Controllers\clients\Auth;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Traits\UploadImageTraitt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagemerchantController extends Controller
{
    Use UploadImageTraitt;

    //* function Store Image Merchant
    public function store(Request $request)
    {
        $request->validate([
            'imagemerchant' => ['required'],
        ],[
            'imagemerchant.required' =>__('Dashboard/messages.imageuserrequired'),
        ]);

        try{
            $input = $request->all();
            $idimagemerchant = Auth::guard('merchants')->user()->id;
            $tableimagemerchant = Merchant::where('id','=',$idimagemerchant)->first();

            if(!empty($input['imagemerchant'])){
                $path = $this->uploadImagemr($request, 'imagemerchant');
                DB::beginTransaction();
                $tableimagemerchant->update([
                    'image'=>$path
                ]);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.add'));
                return redirect()->route('profilemerchant.edit');
            }else{
                toastr()->error(trans('Dashboard/messages.imageuserrequired'));
                return redirect()->route('profilemerchant.edit');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->success(trans('Dashboard/messages.err'));
            return redirect()->route('profilemerchant.edit');
        }
    }

    //* function Update Image Merchant
    public function update(Request $request)
    {
        $request->validate([
            'imagemerchant' => ['required'],
        ],[
            'imagemerchant.required' =>__('Dashboard/messages.imageuserrequired'),
        ]);
        try{
            $idimagemerchant = Auth::guard('merchants')->user()->id;
            $tableimagemerchant = Merchant::where('id','=',$idimagemerchant)->first();
            if($request->has('imagemerchant')){
                    $image = $tableimagemerchant->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                    $image = $this->uploadImagemr($request, 'imagemerchant');
                    DB::beginTransaction();
                    $tableimagemerchant->update([
                        'image' => $image
                    ]);
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.edit'));
                    return redirect()->route('profilemerchant.edit');
            }
            else{
                toastr()->error(trans('Dashboard/messages.imageuserrequired'));
                return redirect()->route('profilemerchant.edit');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profilemerchant.edit');
        }
    }

    //* function Delete Image Merchant
    public function destroy(Request $request)
    {
        try{
            $id = Auth::guard('merchants')->user()->id;
            $tableimagemerchant = Merchant::where('id','=',$id)->first();
            DB::beginTransaction();
                $tableimagemerchant->update([
                    'image' => ''
                ]);

                if ($tableimagemerchant->image && Storage::disk('public')->exists($tableimagemerchant->image)) {
                    Storage::disk('public')->delete($tableimagemerchant->image);
                }

            DB::commit();
            toastr()->success(trans('Dashboard/messages.delete'));
            return redirect()->route('profilemerchant.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profilemerchant.edit');
        }
    }
}
