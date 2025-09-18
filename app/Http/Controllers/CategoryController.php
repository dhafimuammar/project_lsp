<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //

    public function index(Request $request)
    {
        $search = $request->input('search');
        $categories = Category::when($search, function ($q, $s) {
            return $q->where(function($q2) use ($s) {
                $q2->where('nama', 'like', "%$s%")
                    ->orWhere('keterangan', 'like', "%$s%");
                if (is_numeric($s)) {
                    // jika input numerik, cocokkan juga dengan id
                    $q2->orWhere('id', $s);
                }
            });
        })->orderBy('id')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'nullable',
        ]);
        Category::create($request->only(['nama', 'keterangan']));
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'nullable',
        ]);
        $category->update($request->only(['nama', 'keterangan']));
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
