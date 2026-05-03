<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    public function edit(): View
    {
        return view('modules.company.edit', [
            'settings' => [
                'company_name'        => Setting::get('company_name', 'Angga Credit Motors'),
                'company_name_short'  => Setting::get('company_name_short', 'Angga Motors'),
                'company_name_suffix' => Setting::get('company_name_suffix', 'Credit'),
                'company_tagline'     => Setting::get('company_tagline', 'Sistem Informasi Kredit Motor'),
                'company_branch'      => Setting::get('company_branch', 'Rajeg'),
                'company_phone'       => Setting::get('company_phone', '0813-8704-7805'),
                'company_logo_text'   => Setting::get('company_logo_text', 'KM'),
                'company_logo_path'   => Setting::get('company_logo_path', ''),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'company_name'        => 'required|string|max:100',
            'company_name_short'  => 'required|string|max:60',
            'company_name_suffix' => 'nullable|string|max:40',
            'company_tagline'     => 'nullable|string|max:120',
            'company_branch'      => 'nullable|string|max:80',
            'company_phone'       => 'nullable|string|max:30',
            'company_logo_text'   => 'nullable|string|max:4',
            'logo_file'           => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
        ]);

        $fields = ['company_name', 'company_name_short', 'company_name_suffix', 'company_tagline', 'company_branch', 'company_phone', 'company_logo_text'];
        foreach ($fields as $field) {
            Setting::set($field, $request->input($field));
        }

        if ($request->hasFile('logo_file')) {
            $oldPath = Setting::get('company_logo_path');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('logo_file')->store('logos', 'public');
            Setting::set('company_logo_path', $path);
        }

        return back()->with('success', 'Pengaturan perusahaan berhasil disimpan.');
    }
}
