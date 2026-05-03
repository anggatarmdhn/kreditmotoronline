<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('modules.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('modules.banner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|max:5120',
            'sort_order' => 'integer',
        ]);

        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'image_path' => $path,
            'is_active' => $request->has('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('banner.index')->with('success', 'Banner berhasil ditambahkan.');
    }
    public function edit(Banner $banner)
    {
        return view('modules.banner.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'sort_order' => 'integer',
        ]);

        $data = [
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'is_active' => $request->has('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('banner.index')->with('success', 'Banner berhasil diperbarui.');
    }
    public function destroy(Banner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();
        return back()->with('success', 'Banner dihapus.');
    }
}
