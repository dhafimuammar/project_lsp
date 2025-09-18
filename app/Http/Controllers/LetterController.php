<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->input('search');
        $letters = Letter::with('category')
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                        $q->where('judul', 'like', "%$search%")
                          ->orWhere('nomor_surat', 'like', "%$search%")
                          ->orWhereHas('category', function($qc) use ($search) {
                              $qc->where('nama', 'like', "%$search%");
                          });
                });
            })
            ->orderByDesc('created_at')
            ->get();
        return view('letters.index', compact('letters'));
    }

    public function create()
    {
        $categories = Category::all();
    $generated = $this->generateNomor();
    return view('letters.create', compact('categories', 'generated'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'judul' => 'required',
            'kategori_id' => 'required|exists:categories,id',
            'file_surat' => 'required|file|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file_surat');
        // Validasi MIME type dan ekstensi
        if ($file->getClientMimeType() !== 'application/pdf' || strtolower($file->getClientOriginalExtension()) !== 'pdf') {
            return back()->withErrors(['file_surat' => 'File yang diunggah harus berupa PDF asli, bukan hasil rename.']);
        }

    $filePath = $file->store('surat', 'public');
        Letter::create([
            'nomor_surat' => $request->nomor_surat,
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'tanggal_surat' => now(),
            'file_path' => $filePath,
        ]);
        return redirect()->route('letters.index')->with('success', 'Data berhasil disimpan');
    }

    // generate nomor surat otomatis: simple 4-digit counter (0001)
    private function generateNomor()
    {
        $count = Letter::count() + 1;
        return str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function show(Letter $letter)
    {
        $letter->load('category');
        return view('letters.show', compact('letter'));
    }

    public function edit(Letter $letter)
    {
        $categories = Category::all();
        return view('letters.edit', compact('letter', 'categories'));
    }

    public function update(Request $request, Letter $letter)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'judul' => 'required',
            'kategori_id' => 'required|exists:categories,id',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $data = $request->only(['nomor_surat', 'judul', 'kategori_id']);
        if (empty($data['nomor_surat'])) {
            $data['nomor_surat'] = $this->generateNomor();
        }

        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            if ($file->getClientMimeType() !== 'application/pdf' || strtolower($file->getClientOriginalExtension()) !== 'pdf') {
                return back()->withErrors(['file_surat' => 'File yang diunggah harus berupa PDF asli.']);
            }
            // hapus file lama jika ada
            if ($letter->file_path) {
                Storage::disk('public')->delete($letter->file_path);
            }
            $filePath = $file->store('surat', 'public');
            $data['file_path'] = $filePath;
        }

        $letter->update($data);
        return redirect()->route('letters.show', $letter->id)->with('success', 'Data surat berhasil diperbarui');
    }

    public function destroy(Letter $letter)
    {
        if ($letter->file_path) {
            Storage::disk('public')->delete($letter->file_path);
        }
        $letter->delete();
        return redirect()->route('letters.index')->with('success', 'Surat berhasil dihapus');
    }

    public function download(Letter $letter)
    {
        // gunakan judul surat sebagai nama file saat didownload, bersihkan karakter tidak valid
        $safeName = preg_replace('/[^A-Za-z0-9_\- ]/', '', $letter->judul);
        $safeName = trim(str_replace(' ', '_', $safeName));
        $filename = $safeName ?: 'surat';
        if (!str_ends_with(strtolower($filename), '.pdf')) {
            $filename .= '.pdf';
        }
        return Storage::disk('public')->download($letter->file_path, $filename);
    }

    /**
     * Stream PDF inline with proper headers (for iframe display).
     */
    public function viewPdf(Letter $letter)
    {
        $path = storage_path('app/public/' . $letter->file_path);
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline',
        ]);
    }
}
