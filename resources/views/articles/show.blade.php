@extends('layouts.app')

@section('title', $article->title.' | Atara Glamping')

@section('content')
<article class="bg-white border-b border-border-subtle py-12 sm:py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center gap-2 font-mono text-[10px] sm:text-xs uppercase tracking-[0.18em] text-muted-stone mb-5">
            <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
            <span>/</span>
            <a href="{{ route('home') }}#artikel" class="hover:text-primary">Artikel</a>
            <span>/</span>
            <span class="text-primary truncate max-w-52 sm:max-w-none">{{ $article->title }}</span>
        </div>

        <h1 class="font-sans font-bold text-2xl sm:text-4xl text-primary tracking-tight leading-tight mb-4">
            {{ $article->title }}
        </h1>

        <p class="font-mono text-xs text-muted-stone mb-6">
            Oleh {{ $article->author?->name ?? 'Tim Atara Glamping' }}
            @if ($article->created_at)
                &middot; {{ $article->created_at->locale('id')->translatedFormat('d M Y') }}
            @endif
        </p>

        @if ($article->thumbnail_path)
            <div class="aspect-16/9 overflow-hidden border border-border-subtle bg-canvas mb-8">
                <img src="{{ asset($article->thumbnail_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="font-serif text-base sm:text-lg text-neutral-dark leading-relaxed space-y-4">
            @foreach (preg_split("/\r\n|\n|\r/", trim($article->content)) as $paragraph)
                @if (filled($paragraph))
                    <p>{{ $paragraph }}</p>
                @endif
            @endforeach
        </div>

        <div class="mt-10 pt-6 border-t border-border-subtle">
            <a href="{{ route('home') }}#artikel" class="inline-flex items-center min-h-11 font-mono text-xs uppercase tracking-wider text-primary underline underline-offset-4">
                &larr; Kembali ke daftar artikel
            </a>
        </div>
    </div>
</article>

@if ($related->isNotEmpty())
<section class="bg-canvas py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-sans font-bold text-lg text-primary mb-5">Artikel Lainnya</h2>
        <div class="grid sm:grid-cols-2 gap-5">
            @foreach ($related as $item)
                <a href="{{ route('articles.show', $item->slug) }}" class="block bg-white border border-border-subtle p-5 hover:border-primary transition-colors">
                    <h3 class="font-sans font-semibold text-base text-primary mb-2">{{ $item->title }}</h3>
                    <p class="font-serif text-xs text-neutral-dark line-clamp-2">{{ $item->content }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
