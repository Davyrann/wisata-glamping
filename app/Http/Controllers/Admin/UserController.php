<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Manajemen akun pengguna (Admin, Staff, User) khusus untuk Administrator.
 */
class UserController extends Controller
{
    /**
     * Peran akun yang valid beserta labelnya.
     *
     * @var array<string, string>
     */
    public const ROLES = [
        'admin' => 'Admin',
        'staff' => 'Staff',
        'user' => 'Tamu',
    ];

    /**
     * Daftar akun dengan pencarian nama/email dan filter peran.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'role' => ['nullable', Rule::in(array_keys(self::ROLES))],
        ]);

        $users = User::query()
            ->withCount('bookings')
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query->where(function ($inner) use ($search): void {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($filters['role'] ?? null, fn ($query, string $role) => $query->where('role', $role))
            ->orderBy('role')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'filters' => $filters,
            'roles' => self::ROLES,
            'counts' => User::query()->selectRaw('role, count(*) as total')->groupBy('role')->pluck('total', 'role'),
        ]);
    }

    /**
     * Tampilkan formulir pembuatan akun baru.
     */
    public function create(): View
    {
        return view('admin.users.form', [
            'account' => new User(['role' => 'staff']),
            'roles' => self::ROLES,
        ]);
    }

    /**
     * Simpan akun baru dan catat ke audit log.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+() .-]*$/'],
            'role' => ['required', Rule::in(array_keys(self::ROLES))],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $account = User::create($data);

        ActivityLog::record($request->user(), 'user_created', "Membuat akun {$account->name} ({$account->email}) dengan peran {$account->role}.", $request);

        return redirect()->route('admin.users.index')->with('status', "Akun {$account->name} berhasil dibuat.");
    }

    /**
     * Tampilkan formulir ubah akun.
     */
    public function edit(User $user): View
    {
        return view('admin.users.form', [
            'account' => $user,
            'roles' => self::ROLES,
        ]);
    }

    /**
     * Perbarui akun. Kata sandi hanya diganti jika diisi, dan admin
     * tidak dapat menurunkan peran akunnya sendiri.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+() .-]*$/'],
            'role' => ['required', Rule::in(array_keys(self::ROLES))],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($user->is($request->user()) && $data['role'] !== 'admin') {
            return back()->withInput()->withErrors(['role' => 'Anda tidak dapat menurunkan peran akun Anda sendiri.']);
        }

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        ActivityLog::record($request->user(), 'user_updated', "Memperbarui akun {$user->name} ({$user->email}), peran: {$user->role}.", $request);

        return redirect()->route('admin.users.index')->with('status', "Akun {$user->name} berhasil diperbarui.");
    }

    /**
     * Hapus akun. Akun sendiri dan akun dengan reservasi aktif tidak boleh dihapus.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['delete' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $hasActiveBookings = $user->bookings()
            ->whereIn('status', ['unpaid', 'confirmed', 'checked_in', 'cancellation_requested'])
            ->exists();

        if ($hasActiveBookings) {
            return back()->withErrors(['delete' => "Akun {$user->name} masih memiliki reservasi aktif dan tidak dapat dihapus."]);
        }

        $name = $user->name;
        $email = $user->email;
        $user->delete();

        ActivityLog::record($request->user(), 'user_deleted', "Menghapus akun {$name} ({$email}).", $request);

        return redirect()->route('admin.users.index')->with('status', "Akun {$name} berhasil dihapus.");
    }
}
