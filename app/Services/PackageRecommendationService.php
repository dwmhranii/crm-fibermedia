<?php

namespace App\Services;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PackageRecommendationService
{
    public function recommend(Request $request, int $limit = 3): Collection
    {
        $hasFilter = $this->hasRecoFilter($request);
        if (!$hasFilter) return collect();

        // Ambil kandidat aktif saja
        $candidates = Package::query()
            ->where('is_active', 1)
            ->get();

        if ($candidates->isEmpty()) return collect();

        // Normalisasi input
        $usage = $request->input('usage'); // browsing|streaming|gaming|wfh|tv|kuota_hp
        $usersKey = $request->input('users'); // 1-2|3-4|5-7|8plus
        $extra = $request->input('extra'); // tv|streaming|kuota_hp|null

        [$minUsersWanted, $maxUsersWanted] = $this->mapUsersKeyToRange($usersKey);

        // Hitung skor tiap paket
        $scored = $candidates->map(function ($pkg) use ($usage, $extra, $minUsersWanted, $maxUsersWanted) {
            $score = 0;

            // 1) Kebutuhan utama (paling berat)
            $score += $this->scoreUsage($pkg, $usage);

            // 2) Jumlah pengguna (berat juga)
            $score += $this->scoreUsersFit($pkg, $minUsersWanted, $maxUsersWanted);

            // 3) Extra (TV/Streaming/Kuota HP)
            $score += $this->scoreExtra($pkg, $extra);

            // 4) Best-for label (kalau kamu isi kolom best_for)
            $score += $this->scoreBestFor($pkg, $usage);

            // 5) Speed & Price (bonus ringan, biar tidak ngawur)
            $score += $this->scoreSpeed($pkg, $usage);
            $score += $this->scorePrice($pkg);

            // 6) Best seller / featured (bonus kecil)
            if ((int) $pkg->is_best_seller === 1) $score += 6;
            if ((int) $pkg->is_featured === 1) $score += 4;

            return [
                'package' => $pkg,
                'score'   => $score,
            ];
        });

        $sorted = $scored
            ->sort(function ($a, $b) {
                if ($a['score'] !== $b['score']) return $b['score'] <=> $a['score'];

                $pa = $a['package'];
                $pb = $b['package'];

                if ((int)$pa->is_best_seller !== (int)$pb->is_best_seller) {
                    return (int)$pb->is_best_seller <=> (int)$pa->is_best_seller;
                }

                if ((int)$pa->price_monthly !== (int)$pb->price_monthly) {
                    return (int)$pa->price_monthly <=> (int)$pb->price_monthly;
                }

                return (int)$pb->speed_mbps <=> (int)$pa->speed_mbps;
            })
            ->values();

        return $sorted
            ->take($limit)
            ->pluck('package')
            ->values();
    }

    public function hasRecoFilter(Request $request): bool
    {
        return $request->filled('usage') || $request->filled('users') || $request->filled('extra');
    }

    private function mapUsersKeyToRange(?string $usersKey): array
    {
        return match ($usersKey) {
            '1-2'   => [1, 2],
            '3-4'   => [3, 4],
            '5-7'   => [5, 7],
            '8plus' => [8, 99],
            default => [null, null],
        };
    }

    private function scoreUsage($pkg, ?string $usage): int
    {
        if (!$usage) return 0;

        return match ($usage) {
            'gaming' => ((int)$pkg->good_for_gaming === 1 ? 35 : 0),
            'streaming' => ((int)$pkg->good_for_streaming === 1 ? 32 : 0)
                        + ((int)$pkg->includes_streaming_app === 1 ? 10 : 0),
            'wfh' => ((int)$pkg->good_for_wfh === 1 ? 34 : 0),
            'tv' => ((int)$pkg->includes_tv === 1 ? 35 : 0),
            'kuota_hp' => ((int)$pkg->includes_mobile_quota === 1 ? 35 : 0),
            'browsing' => 18, 
            default => 0,
        };
    }

    private function scoreUsersFit($pkg, $minWanted, $maxWanted): int
    {
        if ($minWanted === null || $maxWanted === null) return 0;

        $minPkg = $pkg->min_users ?? null;
        $maxPkg = $pkg->max_users ?? null;

        if ($minPkg === null && $maxPkg === null) return 8;

        $minPkg = $minPkg ?? 1;
        $maxPkg = $maxPkg ?? 99;

        $fullyInside = ($minWanted >= $minPkg && $maxWanted <= $maxPkg);

        $overlap = !($maxWanted < $minPkg || $minWanted > $maxPkg);

        if ($fullyInside) return 28;
        if ($overlap) return 16;

        return -10;
    }

    private function scoreExtra($pkg, ?string $extra): int
    {
        if (!$extra) return 0;

        return match ($extra) {
            'tv' => ((int)$pkg->includes_tv === 1 ? 18 : -6),
            'streaming' => ((int)$pkg->includes_streaming_app === 1 ? 18 : -6),
            'kuota_hp' => ((int)$pkg->includes_mobile_quota === 1 ? 18 : -6),
            default => 0,
        };
    }

    private function scoreBestFor($pkg, ?string $usage): int
    {
        if (!$usage) return 0;
        if (empty($pkg->best_for)) return 0;

        return strtolower(trim($pkg->best_for)) === $usage ? 10 : 0;
    }

    private function scoreSpeed($pkg, ?string $usage): int
    {
        $speed = (int) ($pkg->speed_mbps ?? 0);
        if ($speed <= 0) return 0;

        // bonus speed tergantung kebutuhan
        return match ($usage) {
            'gaming'   => $speed >= 50 ? 10 : 2,
            'streaming'=> $speed >= 30 ? 10 : 2,
            'wfh'      => $speed >= 30 ? 10 : 2,
            'tv'       => $speed >= 30 ? 6  : 1,
            'browsing' => $speed >= 20 ? 4  : 1,
            default    => $speed >= 30 ? 6  : 1,
        };
    }

    private function scorePrice($pkg): int
    {
        $price = (int) ($pkg->price_monthly ?? 0);
        if ($price <= 0) return 0;

        // Bonus kecil untuk harga lebih murah (biar tidak bias ke paket mahal)
        // Kamu bisa sesuaikan threshold
        if ($price <= 200000) return 8;
        if ($price <= 300000) return 5;
        if ($price <= 400000) return 3;
        return 1;
    }
}
