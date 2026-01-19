<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sizes;
use Illuminate\Http\Request;

class SizesController extends Controller
{
    // 📌 جلب جميع المقاسات
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Sizes::latest()->get()
        ]);
    }

    // 📌 إنشاء مقاس جديد
    public function store(Request $request)
    {

        // $data = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        // ]);

        // $size = Sizes::create($data);

        return response()->json([
            'status' => true,
            'message' => 'تم إنشاء المقاس بنجاح',
        ], 201);
    }

    // 📌 جلب مقاس واحد
    public function show($id)
    {
        $size = Sizes::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $size
        ]);
    }

    // 📌 تحديث مقاس
    public function update(Request $request, $id)
    {
        $size = Sizes::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $size->update($data);

        return response()->json([
            'status' => true,
            'message' => 'تم تحديث المقاس بنجاح',
            'data' => $size
        ]);
    }

    // 📌 حذف مقاس
    public function destroy($id)
    {
        Sizes::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'تم حذف المقاس بنجاح'
        ]);
    }
}
