<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{

    public function index()
    {
        $food = Food::with('category')->get();

        $data = $food->map(function ($food) {
            return [
                'id' => $food->id,
                'name' => $food->name,
                'price' => $food->price,
                'desc' => $food->desc,
                'image' => $food->image,
                'category_id' => $food->category_id,
                'category_name' => $food->category_name,
            ];
        });

        return response(['data' => $food, 'status' => '200', 'messages' => 'Data Berhasil Ditampilkan']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'price' => 'required|integer',
            'image_file' => 'nullable|mimes:jpg,png'
        ]);

        if ($request->file('image_file')) {
            $file = $request->file('image_file');
            $fileName = $file->getClientOriginalName();
            $newName = Carbon::now()->timestamp . '-' . $fileName;
            Storage::disk('public')->putFileAs('Items', $file, $newName);
            $request['image'] = $newName;
        }

        $item = Item::create(
            $request->all()
        );

        return response(['data' => $item, 'status' => '200', 'Messages' => 'Item Berhasil Ditambah']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'price' => 'required|integer',
            'image_file' => 'nullable|mimes:jpg,png'
        ]);

        $item = Item::findOrFail($id);
        if ($request->file('image_file')) {
            $file = $request->file('image_file');
            $fileName = $file->getClientOriginalName();
            $newName = Carbon::now()->timestamp . '-' . $fileName;

            Storage::disk('public')->putFileAs('Items', $file, $newName);

            if ($item->image) {
                Storage::disk('public')->delete('Items/' . $item->image);
            }

            $request['image'] = $newName;
        }

        $item->update($request->all());

        return response(['data' => $item, 'status' => '200', 'messages' => 'Items Berhasil Diupdate']);
    }

    public function delete(Request $request, $id)
    {
        $item = Item::find($id);

        $item->delete();

        return response()->json(['messages' => 'Item Deleted Successfully']);
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        return response(['data' => $item, 'status' => 200, 'messagess' => 'Item Berhasil Ditampilkan']);
    }
}
