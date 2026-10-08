<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    /**
     * Tampilkan daftar log aktivitas.
     */
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user');

        // Filter berdasarkan user
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan kata kunci aktivitas
        if ($request->q) {
            $query->where('aktivitas', 'like', '%' . $request->q . '%');
        }

        // Filter berdasarkan tanggal
        if ($request->dari) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->sampai) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        $logs = $query->latest()->paginate(20)->withQueryString();

        // Data untuk filter dropdown
        $users = User::orderBy('nama')->get();

        // Statistik log
        $total_log = LogAktivitas::count();
        $log_hari_ini = LogAktivitas::whereDate('created_at', now()->toDateString())->count();
        $log_minggu_ini = LogAktivitas::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->count();

        return view('log.index', compact(
            'logs',
            'users',
            'total_log',
            'log_hari_ini',
            'log_minggu_ini'
        ));
    }

    /**
     * Hapus log lama (opsional — bersihkan log > 30 hari).
     */
    public function bersihkan()
    {
        $batas = now()->subDays(30);

        $jumlah = LogAktivitas::where('created_at', '<', $batas)->count();

        if ($jumlah === 0) {
            return back()->with('error', 'Tidak ada log yang lebih dari 30 hari.');
        }

        // Simpan log aktivitas pembersihan sebelum hapus
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Bersihkan ' . $jumlah . ' log lama (>30 hari)',
        ]);

        // Hapus log lama
        LogAktivitas::where('created_at', '<', $batas)->delete();

        return back()->with('success', $jumlah . ' log lama berhasil dibersihkan!');
    }

    /**
     * Backup data log ke format SQL (download file).
     */
    public function backup()
    {
        $filename = 'backup-log-' . date('Y-m-d-His') . '.sql';

        $logs = LogAktivitas::with('user')->latest()->get();

        $sql = "-- Backup Log Aktivitas\n";
        $sql .= "-- Tanggal: " . date('d-m-Y H:i:s') . "\n";
        $sql .= "-- Total: " . $logs->count() . " baris\n\n";
        $sql .= "CREATE TABLE IF NOT EXISTS `log_aktivitas` (\n";
        $sql .= "  `id` bigint unsigned NOT NULL AUTO_INCREMENT,\n";
        $sql .= "  `user_id` bigint unsigned NOT NULL,\n";
        $sql .= "  `aktivitas` varchar(255) NOT NULL,\n";
        $sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  PRIMARY KEY (`id`)\n";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\n\n";

        foreach ($logs as $log) {
            $aktivitas = addslashes($log->aktivitas);
            $created = $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : 'NULL';
            $updated = $log->updated_at ? $log->updated_at->format('Y-m-d H:i:s') : 'NULL';

            $sql .= "INSERT INTO `log_aktivitas` (`id`, `user_id`, `aktivitas`, `created_at`, `updated_at`) VALUES ";
            $sql .= "({$log->id}, {$log->user_id}, '{$aktivitas}', '{$created}', '{$updated}');\n";
        }

        // Catat log backup
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Backup log aktivitas (' . $logs->count() . ' baris)',
        ]);

        return response($sql)
            ->header('Content-Type', 'application/sql')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Hapus satu log (opsional — kalau admin perlu).
     */
    public function destroy(LogAktivitas $log)
    {
        $log->delete();
        return back()->with('success', 'Log berhasil dihapus.');
    }
}