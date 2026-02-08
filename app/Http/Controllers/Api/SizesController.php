<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sizes;
use Illuminate\Http\Request;

class SizesController extends Controller
{
    // 📌 جلب جميع المقاسات (Get All Sizes)
    // هذه الدالة تعيد قائمة بكل المقاسات المسجلة في قاعدة البيانات
    // This function returns a list of all sizes stored in the database
    public function index()
    {
        $sizes = Sizes::selectBasic()->get(); // جلب البيانات مرتبة من الأحدث للأقدم
        return \App\Http\Resources\SizeResource::collection($sizes); // إرجاع البيانات باستخدام Resource لتنسيقها
    // return response()->json(['message' => '✅ تم جلب جميع المقاسات بنجاح', 'data' => $sizes]);
    }

    // 📌 إنشاء مقاس جديد (Create New Size)
    // هذه الدالة تقوم بالتحقق من البيانات المدخلة وحفظ مقاس جديد
    // This function validates the input and creates a new size record
    public function store(Request $request)
    {
        // التحقق من صحة البيانات (Validation)
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // إنشاء السجل في قاعدة البيانات
        $size = Sizes::create($data);

        // إرجاع رسالة نجاح مع الكائن الذي تم إنشاؤه
        return response()->json([
            'message' => 'تم إنشاء المقاس بنجاح',
            'data' => new \App\Http\Resources\SizeResource($size)
        ], 201);
    }

    // 📌 جلب مقاس واحد (Get Single Size)
    // عرض تفاصيل مقاس محدد بناءً على المعرف (ID)
    // Show details of a specific size based on ID
    public function show($id)
    {
        $size = Sizes::find($id);

        if (!$size) {
            return response()->json(['message' => 'المقاس غير موجود'], 404);
        }

        return new \App\Http\Resources\SizeResource($size);
    }

    // 📌 تحديث مقاس (Update Size)
    // تعديل بيانات مقاس موجود
    // Update an existing size record
    public function update(Request $request, $id)
    {
        $size = Sizes::find($id);

        if (!$size) {
            return response()->json(['message' => 'المقاس غير موجود'], 404);
        }

        // التحقق من البيانات الجديدة
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // تحديث السجل
        $size->update($data);

        return response()->json([
            'message' => 'تم تحديث المقاس بنجاح',
            'data' => new \App\Http\Resources\SizeResource($size)
        ]);
    }

    // 📌 حذف مقاس (Delete Size)
    // حذف مقاس من قاعدة البيانات نهائيًا
    // Permanently delete a size from the database
    public function destroy($id)
    {
        $size = Sizes::find($id);

        if (!$size) {
            return response()->json(['message' => 'المقاس غير موجود'], 404);
        }

        $size->delete();

        return response()->json([
            'message' => 'تم حذف المقاس بنجاح'
        ]);
    }
}
