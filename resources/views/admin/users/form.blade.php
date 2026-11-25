@php $isEdit = $account->exists; @endphp
@extends('layouts.dashboard', [
    'title' => $isEdit ? 'Ubah Akun' : 'Tambah Akun',
    'subtitle' => 'Panel Admin / Manajemen Akun / '.($isEdit ? 'Ubah' : 'Tambah')
])

@section('content')
<div class="mb-7">
    <a href="{{ route('admin.users.index') }}" class="text-pine-700 underline underline-offset-4 text-xs font-semibold">&larr; Kembali ke daftar akun</a>
    <h1 class="mt-3 font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">{{ $isEdit ? 'Ubah Akun' : 'Tambah Akun' }}</h1>
    <p class="mt-2 text-text-muted text-sm sm:text-base">
        {{ $isEdit ? 'Perbarui data akun. Kosongkan kata sandi jika tidak ingin menggantinya.' : 'Akun Staff dan Admin hanya dapat dibuat oleh Administrator.' }}
    </p>
</div>

<section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7 max-w-160">
    <form method="POST" action="{{ $isEdit ? route('admin.users.update', $account) : route('admin.users.store') }}" class="space-y-4">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        @php $input = 'block w-full mt-1.5 h-10 border border-line-strong rounded-md px-3 text-sm text-text bg-surface focus:outline-2 focus:outline-pine-700'; @endphp

        <label class="block text-xs font-semibold text-text-muted">Nama Lengkap
            <input required maxlength="255" name="name" value="{{ old('name', $account->name) }}" class="{{ $input }}">
            @error('name') <span class="block mt-1 text-danger font-medium">{{ $message }}</span> @enderror
        </label>
        <label class="block text-xs font-semibold text-text-muted">Alamat Email
            <input required type="email" maxlength="255" name="email" value="{{ old('email', $account->email) }}" class="{{ $input }}">
            @error('email') <span class="block mt-1 text-danger font-medium">{{ $message }}</span> @enderror
        </label>
        <label class="block text-xs font-semibold text-text-muted">Nomor Telepon
            <input name="phone" maxlength="30" value="{{ old('phone', $account->phone) }}" placeholder="Contoh: 081234567890" class="{{ $input }}">
            @error('phone') <span class="block mt-1 text-danger font-medium">{{ $message }}</span> @enderror
        </label>
        <label class="block text-xs font-semibold text-text-muted">Peran
            <select name="role" class="{{ $input }}">
                @foreach ($roles as $key => $label)
                    <option value="{{ $key }}" @selected(old('role', $account->role) === $key)>{{ $label }}</option>
                @endforeach
            </select>
            @error('role') <span class="block mt-1 text-danger font-medium">{{ $message }}</span> @enderror
        </label>

        <div class="pt-4 border-t border-line space-y-4">
            <label class="block text-xs font-semibold text-text-muted">{{ $isEdit ? 'Kata Sandi Baru (opsional)' : 'Kata Sandi' }}
                <input @required(! $isEdit) type="password" minlength="8" name="password" autocomplete="new-password" class="{{ $input }}">
                @error('password') <span class="block mt-1 text-danger font-medium">{{ $message }}</span> @enderror
            </label>
            <label class="block text-xs font-semibold text-text-muted">Konfirmasi Kata Sandi
                <input @required(! $isEdit) type="password" minlength="8" name="password_confirmation" autocomplete="new-password" class="{{ $input }}">
            </label>
        </div>

        <div class="flex flex-wrap gap-3 items-center pt-2">
            <button type="submit" class="bg-pine-700 hover:bg-pine-600 text-white rounded-md font-semibold text-xs min-h-10 px-5 transition-colors">
                {{ $isEdit ? 'Simpan Perubahan' : 'Buat Akun' }}
            </button>
            <a href="{{ route('admin.users.index') }}" class="text-pine-700 underline underline-offset-4 text-xs font-semibold min-h-10 inline-flex items-center">Batal</a>
        </div>
    </form>
</section>
@endsection
