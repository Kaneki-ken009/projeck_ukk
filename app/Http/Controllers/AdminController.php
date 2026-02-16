<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\InputAspirasi;
use App\Models\LaporanLog;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'aspirasiTotal' => InputAspirasi::count(),
            'aspirasiMenunggu' => InputAspirasi::where('status', 'menunggu')->count(),
            'aspirasiProses' => InputAspirasi::where('status', 'proses')->count(),
            'aspirasiSelesai' => InputAspirasi::where('status', 'selesai')->count(),
            'users' => User::orderBy('username')->get(),
        ]);
    }

    public function menunggu()
    {
        return view('admin.aspirasi_menunggu', [
            'aspirasi' => InputAspirasi::with(['kategori', 'pengirim'])
                ->where('status', 'menunggu')
                ->orderBy('tgl_inputaspirasi', 'desc')
                ->get(),
        ]);
    }

    public function proses()
    {
        return view('admin.aspirasi_proses', [
            'aspirasi' => InputAspirasi::with('kategori')
                ->where('status', 'proses')
                ->orderBy('tgl_inputaspirasi', 'desc')
                ->get(),
        ]);
    }

    public function selesai()
    {
        return view('admin.aspirasi_selesai', [
            'aspirasi' => InputAspirasi::with('kategori')
                ->where('status', 'selesai')
                ->orderBy('tgl_inputaspirasi', 'desc')
                ->get(),
        ]);
    }

    public function users()
    {
        return view('admin.users', [
            'users' => User::orderBy('username')->get(),
        ]);
    }

    public function laporan()
    {
        return view('admin.laporan', [
            'logs' => LaporanLog::with('admin')->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function laporanPdf()
    {
        $aspirasi = InputAspirasi::with([
            'kategori',
            'feedback' => fn ($query) => $query->orderByDesc('created_at'),
        ])
            ->orderBy('tgl_inputaspirasi', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan_pdf', [
            'aspirasi' => $aspirasi,
            'generatedAt' => now(),
        ]);

        return $pdf->download('laporan-aspirasi-' . now()->format('YmdHis') . '.pdf');
    }

    public function sendLaporan(Request $request)
    {
        $user = auth()->user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengirim laporan.');
        }

        $data = $request->validate([
            'bulan' => 'required|date_format:Y-m',
            'note' => 'nullable|string|max:300',
        ]);

        $start = Carbon::createFromFormat('Y-m', $data['bulan'])->startOfMonth();
        $end = Carbon::createFromFormat('Y-m', $data['bulan'])->endOfMonth();

        $aspirasi = InputAspirasi::with([
            'kategori',
            'feedback' => fn ($query) => $query->orderByDesc('created_at'),
        ])
            ->whereBetween('tgl_inputaspirasi', [$start, $end])
            ->orderBy('tgl_inputaspirasi', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan_pdf', [
            'aspirasi' => $aspirasi,
            'generatedAt' => now(),
            'periodStart' => $start,
            'periodEnd' => $end,
        ]);

        $filename = 'laporan-aspirasi-' . $start->format('Y-m') . '-' . now()->format('YmdHis') . '.pdf';
        $path = 'reports/' . $filename;
        Storage::disk('local')->put($path, $pdf->output());

        LaporanLog::create([
            'admin_id' => $user->id,
            'admin_username' => $user->nama ?: $user->username,
            'file_type' => 'pdf',
            'period_type' => 'monthly',
            'period_start' => $start->toDateString(),
            'period_end' => $end->toDateString(),
            'file_path' => $path,
            'note' => $data['note'] ?? null,
        ]);

        return back()->with('status', 'Laporan telah terkirim');
    }

    public function downloadLaporan(LaporanLog $log)
    {
        if (!$log->file_path || !Storage::disk('local')->exists($log->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->download($log->file_path);
    }

    public function storeFeedback(Request $request)
    {
        $data = $request->validate([
            'id_aspirasi' => 'required|integer|exists:inputaspirasi,id_inputaspirasi',
            'status' => 'required|in:menunggu,proses,selesai',
            'isi_feedback' => 'required|string',
        ]);

        $aspirasi = InputAspirasi::where('id_inputaspirasi', $data['id_aspirasi'])->firstOrFail();
        $aspirasi->status = $data['status'];
        $aspirasi->save();

        Feedback::create([
            'id_aspirasi' => $aspirasi->id_inputaspirasi,
            'nisn' => $aspirasi->nisn,
            'isi_feedback' => $data['isi_feedback'],
            'created_at' => now(),
        ]);

        return back()->with('status', 'Feedback tersimpan.');
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:4',
            'nama' => 'required|string',
            'nisn' => 'nullable|string',
            'role' => 'required|in:admin,siswa,kepsek',
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return back()->with('status', 'User tersimpan.');
    }
}
