<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\JenisMotor;
use App\Models\LandingSection;
use App\Models\Motor;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function index(Request $request): View
    {
        // Ambil semua jenis motor yang tersedia (untuk filter sidebar)
        $types = JenisMotor::query()
            ->whereHas('motors', fn ($q) => $q->where('is_active', true))
            ->orderBy('merk')
            ->orderBy('jenis')
            ->get();

        $query = Motor::query()
            ->with('jenisMotor')
            ->where('is_active', true);

        // Filter by jenis (id_jenis)
        $selectedTypes = collect($request->input('tipe', []))
            ->filter()
            ->values()
            ->all();

        if (! empty($selectedTypes)) {
            $query->whereIn('id_jenis', $selectedTypes);
        }

        $harga = $request->input('harga');
        if ($harga === '1') {
            $query->where('harga_cash', '<', 20000000);
        } elseif ($harga === '2') {
            $query->whereBetween('harga_cash', [20000000, 30000000]);
        } elseif ($harga === '3') {
            $query->whereBetween('harga_cash', [30000000, 40000000]);
        } elseif ($harga === '4') {
            $query->where('harga_cash', '>', 40000000);
        }

        $q = trim((string) $request->input('q', ''));
        if ($q !== '') {
            $query->where(function ($builder) use ($q) {
                $builder->where('nama_motor', 'like', '%'.$q.'%')
                    ->orWhere('kode_motor', 'like', '%'.$q.'%')
                    ->orWhereHas('jenisMotor', fn ($jq) => $jq->where('merk', 'like', '%'.$q.'%')
                        ->orWhere('jenis', 'like', '%'.$q.'%')
                    );
            });
        }

        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'harga_asc') {
            $query->orderBy('harga_cash');
        } elseif ($sort === 'harga_desc') {
            $query->orderByDesc('harga_cash');
        } elseif ($sort === 'nama_asc') {
            $query->orderBy('nama_motor');
        } else {
            $query->orderByDesc('created_at');
        }

        $priceBuckets = [
            '1' => ['label' => 'Di bawah 20 jt', 'apply' => fn ($builder) => $builder->where('harga_cash', '<', 20000000)],
            '2' => ['label' => '20 jt - 30 jt', 'apply' => fn ($builder) => $builder->whereBetween('harga_cash', [20000000, 30000000])],
            '3' => ['label' => '30 jt - 40 jt', 'apply' => fn ($builder) => $builder->whereBetween('harga_cash', [30000000, 40000000])],
            '4' => ['label' => 'Di atas 40 jt', 'apply' => fn ($builder) => $builder->where('harga_cash', '>', 40000000)],
        ];

        $priceInsights = collect($priceBuckets)
            ->map(function (array $bucket, string $key) use ($selectedTypes, $q) {
                $bucketQuery = Motor::query()->where('is_active', true);

                if (! empty($selectedTypes)) {
                    $bucketQuery->whereIn('id_jenis', $selectedTypes);
                }

                if ($q !== '') {
                    $bucketQuery->where(function ($builder) use ($q) {
                        $builder->where('nama_motor', 'like', '%'.$q.'%')
                            ->orWhere('kode_motor', 'like', '%'.$q.'%');
                    });
                }

                ($bucket['apply'])($bucketQuery);

                return [
                    'key' => $key,
                    'label' => $bucket['label'],
                    'count' => $bucketQuery->count(),
                    'names' => $bucketQuery->orderBy('harga_cash')->limit(4)->pluck('nama_motor')->all(),
                ];
            })
            ->values();

        $filteredMotorNames = (clone $query)
            ->orderBy('harga_cash')
            ->limit(10)
            ->pluck('nama_motor')
            ->all();

        $motors = $query->paginate(12)->withQueryString();

        return view('landing.index', [
            'banners'           => Banner::where('is_active', true)->orderBy('sort_order')->get(),
            'sections'          => LandingSection::where('is_active', true)->orderBy('sort_order')->get(),
            'featuredMotors'    => $motors,
            'types'             => $types,
            'priceInsights'     => $priceInsights,
            'filteredMotorNames'=> $filteredMotorNames,
            'selectedPriceLabel'=> $harga && isset($priceBuckets[$harga]) ? $priceBuckets[$harga]['label'] : null,
            'filters'           => [
                'q'    => $q,
                'tipe' => $selectedTypes,
                'harga'=> $harga,
                'sort' => $sort,
            ],
            'company' => [
                'name'        => Setting::get('company_name', 'Angga Credit Motors'),
                'name_short'  => Setting::get('company_name_short', 'Angga Motors'),
                'name_suffix' => Setting::get('company_name_suffix', 'Credit'),
                'tagline'     => Setting::get('company_tagline', 'Sistem Informasi Kredit Motor'),
                'branch'      => Setting::get('company_branch', 'Rajeg'),
                'phone'       => Setting::get('company_phone', '0813-8704-7805'),
                'logo_text'   => Setting::get('company_logo_text', 'KM'),
                'logo_path'   => Setting::get('company_logo_path', ''),
            ],
        ]);
    }
}
