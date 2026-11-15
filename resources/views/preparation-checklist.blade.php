@extends('layouts.app')

@section('title', 'Checklist Persiapan Glamping | Atara Glamping')

@section('content')
<section class="bg-[#F9F7F5] border-b border-[#E0DEDC] py-14 sm:py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center gap-2 font-mono text-[10px] sm:text-xs uppercase tracking-[0.18em] text-[#969696] mb-6">
            <a href="{{ route('home') }}" class="hover:text-[#1D1D1C]">Beranda</a>
            <span>/</span>
            <span class="text-[#1D1D1C]">Persiapan Menginap</span>
        </div>

        <div class="max-w-3xl">
            <span class="font-mono text-xs uppercase tracking-widest text-[#969696] block mb-3">Panduan Sebelum Berangkat</span>
            <h1 class="font-sans font-bold text-3xl sm:text-5xl lg:text-6xl tracking-tight leading-[1.05] text-[#1D1D1C] mb-6">
                Persiapan kecil, pengalaman alam yang lebih tenang.
            </h1>
            <p class="font-serif text-base sm:text-xl text-[#444444] leading-relaxed">
                Gunakan checklist ini untuk memastikan barang penting sudah disiapkan sebelum perjalanan glamping. Tandai setiap item yang sudah masuk ke tas.
            </p>
        </div>

        <div class="mt-10 border border-[#E0DEDC] bg-white p-5 sm:p-7">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-4">
                <div>
                    <span class="font-mono text-[10px] uppercase tracking-widest text-[#969696] block mb-2">Progres Persiapan</span>
                    <p class="font-sans font-bold text-2xl text-[#1D1D1C]" id="progress-count" aria-live="polite">0 dari 20 item</p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" id="reset-checklist" class="px-4 py-2.5 border border-[#E0DEDC] text-[#444444] text-[11px] font-semibold uppercase tracking-wider hover:bg-[#F9F7F5] rounded-[5px]">Reset</button>
                    <button type="button" id="print-checklist" class="px-4 py-2.5 bg-[#1D1D1C] text-white text-[11px] font-semibold uppercase tracking-wider hover:bg-black rounded-[5px]">Cetak Checklist</button>
                </div>
            </div>
            <div class="h-2 bg-[#E0DEDC] overflow-hidden" role="progressbar" aria-label="Progres checklist" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" id="progress-bar">
                <div id="progress-fill" class="h-full bg-[#1D1D1C] transition-all duration-300" style="width: 0%"></div>
            </div>
            <p class="font-serif text-xs text-[#969696] mt-3" id="progress-message">Mulai tandai barang yang sudah kamu siapkan.</p>
        </div>
    </div>
</section>

<section class="bg-white py-14 sm:py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8" id="checklist-items">
            @php
                $groups = [
                    'Dokumen & Reservasi' => [
                        'Konfirmasi atau kode booking',
                        'Identitas diri yang diperlukan',
                        'Informasi kontak yang bisa dihubungi',
                    ],
                    'Pakaian & Perlengkapan Pribadi' => [
                        'Pakaian hangat untuk udara dingin',
                        'Pakaian ganti secukupnya',
                        'Jaket atau outer tahan angin',
                        'Alas kaki yang nyaman',
                        'Perlengkapan mandi dan kebersihan pribadi',
                    ],
                    'Kesehatan & Kenyamanan' => [
                        'Obat pribadi yang rutin digunakan',
                        'Perlengkapan P3K pribadi bila diperlukan',
                        'Tabir surya dan perlindungan dari serangga',
                        'Botol minum pribadi',
                    ],
                    'Gawai & Perlengkapan Tambahan' => [
                        'Ponsel dan pengisi daya',
                        'Power bank yang sudah terisi',
                        'Kamera atau perlengkapan dokumentasi',
                        'Tas kecil untuk aktivitas di sekitar area',
                        'Kantong untuk menyimpan pakaian kotor',
                        'Senter kecil sebagai perlengkapan tambahan',
                    ],
                ];
            @endphp

            @foreach ($groups as $group => $items)
                <article class="border border-[#E0DEDC] bg-[#F9F7F5] p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-3 border-b border-[#E0DEDC] pb-4 mb-4">
                        <div>
                            <span class="font-mono text-[10px] uppercase tracking-widest text-[#969696]">Kelompok Perlengkapan</span>
                            <h2 class="font-sans font-bold text-lg text-[#1D1D1C] mt-1">{{ $group }}</h2>
                        </div>
                        <span class="font-mono text-xs text-[#969696]">{{ count($items) }} item</span>
                    </div>
                    <ul class="space-y-3">
                        @foreach ($items as $item)
                            <li>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" class="checklist-checkbox mt-0.5 h-4 w-4 accent-[#1D1D1C] shrink-0" value="{{ $item }}">
                                    <span class="font-serif text-sm text-[#444444] leading-relaxed group-hover:text-[#1D1D1C]">{{ $item }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>

        <div class="mt-10 border-l-2 border-[#1D1D1C] pl-5 py-1">
            <span class="font-mono text-[10px] uppercase tracking-widest text-[#969696] block mb-2">Catatan Perjalanan</span>
            <p class="font-serif text-sm text-[#444444] leading-relaxed">
                Daftar ini bersifat panduan umum dan dapat disesuaikan dengan kebutuhan pribadi, cuaca, serta durasi perjalanan. Periksa kembali informasi reservasi dan ketentuan menginap sebelum berangkat.
            </p>
        </div>

        <div class="mt-12 flex flex-col sm:flex-row sm:items-center justify-between gap-5 border-t border-[#E0DEDC] pt-8">
            <div>
                <h2 class="font-sans font-bold text-xl text-[#1D1D1C]">Masih ada yang ingin ditanyakan?</h2>
                <p class="font-serif text-sm text-[#969696] mt-1">Tim Atara dapat membantu melalui kanal kontak yang tersedia.</p>
            </div>
            <a href="{{ route('home') }}#kontak" class="inline-flex items-center justify-center px-6 py-3.5 bg-[#1D1D1C] text-white text-xs font-semibold tracking-wider uppercase hover:bg-black transition-colors rounded-[5px]">Lihat Informasi Kontak</a>
        </div>
    </div>
</section>

<style>
    @media print {
        header, footer, #reset-checklist, #print-checklist, .mt-12.flex { display: none !important; }
        body, section { background: #fff !important; }
        .checklist-checkbox { print-color-adjust: exact; }
        article { break-inside: avoid; }
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = Array.from(document.querySelectorAll('.checklist-checkbox'));
        const count = document.getElementById('progress-count');
        const fill = document.getElementById('progress-fill');
        const bar = document.getElementById('progress-bar');
        const message = document.getElementById('progress-message');

        const updateProgress = () => {
            const completed = checkboxes.filter((checkbox) => checkbox.checked).length;
            const total = checkboxes.length;
            const percentage = total === 0 ? 0 : Math.round((completed / total) * 100);

            count.textContent = `${completed} dari ${total} item`;
            fill.style.width = `${percentage}%`;
            bar.setAttribute('aria-valuenow', String(percentage));
            message.textContent = completed === total
                ? 'Semua item sudah ditandai. Semoga perjalananmu menyenangkan!'
                : completed === 0
                    ? 'Mulai tandai barang yang sudah kamu siapkan.'
                    : `${percentage}% persiapan sudah selesai.`;
        };

        checkboxes.forEach((checkbox) => checkbox.addEventListener('change', updateProgress));
        document.getElementById('reset-checklist').addEventListener('click', () => {
            checkboxes.forEach((checkbox) => { checkbox.checked = false; });
            updateProgress();
        });
        document.getElementById('print-checklist').addEventListener('click', () => window.print());
        updateProgress();
    });
</script>
@endpush

