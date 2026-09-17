@extends('layouts.lumina')

@section('title', 'Lumina - Streaming Library & AI Learning Space')

@section('content')
<div class="space-y-12 pb-12">

    <!-- ========================================== -->
    <!-- 1. HERO BANNER (CLEAN & CINEMATIC)         -->
    <!-- ========================================== -->
    <section class="relative w-full min-h-[460px] lg:min-h-[520px] flex items-center overflow-hidden">
        <!-- Background Banner -->
        <div class="absolute inset-0 z-0">
            <img 
                src="{{ $featuredBook->banner_url }}" 
                alt="{{ $featuredBook->title }}" 
                class="w-full h-full object-cover object-center opacity-30 filter brightness-90"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/70 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-navy-950 via-navy-950/80 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full flex flex-col lg:flex-row items-center justify-between gap-8">
            <!-- Left: Clean Info -->
            <div class="max-w-2xl space-y-4 text-left">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-cyan-500/15 text-cyan-400 border border-cyan-500/20 text-xs font-semibold">
                        ✨ Pilihan Minggu Ini
                    </span>
                    <span class="text-xs text-slate-400">
                        {{ $featuredBook->category }}
                    </span>
                </div>

                <h1 class="font-display font-black text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-tight">
                    {{ $featuredBook->title }}
                </h1>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-xl line-clamp-3">
                    {{ $featuredBook->synopsis }}
                </p>

                <div class="flex items-center gap-3 text-xs text-slate-400 pt-1">
                    <span class="text-amber-400 font-bold">★ {{ $featuredBook->rating }}</span>
                    <span>•</span>
                    <span>⏱️ {{ $featuredBook->reading_time_minutes }} Menit Baca</span>
                    <span>•</span>
                    <span>Oleh <strong class="text-white">{{ $featuredBook->author }}</strong></span>
                </div>

                <!-- Only 2 Clean Buttons -->
                <div class="flex items-center gap-3 pt-3">
                    <a href="{{ route('lumina.reader', $featuredBook->id) }}" class="bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-bold px-6 py-3 rounded-xl text-xs sm:text-sm flex items-center gap-2 transition hover:scale-105 active:scale-95 shadow-lg shadow-cyan-500/20">
                        <span>▶</span>
                        <span>Mulai Baca</span>
                    </a>

                    <button 
                        onclick="startAudiobook('{{ addslashes($featuredBook->title) }}', '{{ addslashes($featuredBook->author) }}', '{{ $featuredBook->cover_url }}', '{{ addslashes($featuredBook->audio_text) }}')" 
                        class="bg-white/10 hover:bg-white/15 text-white font-semibold px-5 py-3 rounded-xl text-xs sm:text-sm border border-white/10 flex items-center gap-2 transition"
                    >
                        <span>🎧</span>
                        <span>Dengar Audio</span>
                    </button>

                    <a href="{{ route('lumina.book', $featuredBook->id) }}" class="text-xs text-slate-400 hover:text-white px-2 py-3 transition">
                        Detail Buku →
                    </a>
                </div>
            </div>

            <!-- Right: Clean Floating Book Cover -->
            <div class="hidden lg:block shrink-0">
                <div class="w-56 h-80 rounded-2xl overflow-hidden shadow-2xl border border-slate-700/60 transform hover:-translate-y-1 transition duration-300">
                    <img src="{{ $featuredBook->cover_url }}" alt="{{ $featuredBook->title }}" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 2. AI SHORTCUT CARDS (CALM & INTUITIVE)    -->
    <!-- ========================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Card 1: Kuis Minat AI -->
            <div onclick="openMatchmakerModal()" class="p-5 rounded-2xl bg-navy-900/60 border border-slate-800 hover:border-cyan-500/40 transition cursor-pointer flex items-center justify-between gap-4 group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 flex items-center justify-center text-2xl shrink-0 group-hover:scale-105 transition">
                        🎯
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-sm text-white group-hover:text-cyan-400 transition">AI Book Matchmaker</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Bingung memilih? Isi kuis 30 detik untuk rekomendasi buku yang pas dengan mood-mu.</p>
                    </div>
                </div>
                <span class="text-slate-500 group-hover:text-cyan-400 transition shrink-0 text-sm">→</span>
            </div>

            <!-- Card 2: Tanya Tokoh -->
            <div onclick="openRoleplayModal(1)" class="p-5 rounded-2xl bg-navy-900/60 border border-slate-800 hover:border-purple-500/40 transition cursor-pointer flex items-center justify-between gap-4 group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center text-2xl shrink-0 group-hover:scale-105 transition">
                        🎙️
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-sm text-white group-hover:text-purple-400 transition">Tanya Tokoh Buku (Roleplay AI)</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Wawancarai Bung Karno, R.A. Kartini, Minke, atau Marcus Aurelius secara langsung.</p>
                    </div>
                </div>
                <span class="text-slate-500 group-hover:text-purple-400 transition shrink-0 text-sm">→</span>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 3. NETFLIX HORIZONTAL BOOK ROWS (CLEAN)    -->
    <!-- ========================================== -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        @foreach($rows as $rowIndex => $row)
        <section class="space-y-3">
            <!-- Row Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-display font-bold text-lg sm:text-xl text-white tracking-tight">{{ $row['title'] }}</h2>
                    <p class="text-xs text-slate-400">{{ $row['subtitle'] }}</p>
                </div>

                <!-- Simple Scroll Arrows -->
                <div class="flex items-center gap-1.5">
                    <button onclick="scrollRow('row-{{ $rowIndex }}', -300)" class="w-7 h-7 rounded-full bg-navy-900 border border-slate-800 hover:border-slate-600 text-slate-400 hover:text-white flex items-center justify-center text-xs transition">
                        ‹
                    </button>
                    <button onclick="scrollRow('row-{{ $rowIndex }}', 300)" class="w-7 h-7 rounded-full bg-navy-900 border border-slate-800 hover:border-slate-600 text-slate-400 hover:text-white flex items-center justify-center text-xs transition">
                        ›
                    </button>
                </div>
            </div>

            <!-- Clean Swipeable Track -->
            <div id="row-{{ $rowIndex }}" class="flex gap-4 overflow-x-auto no-scrollbar scroll-smooth py-2">
                @foreach($row['books'] as $book)
                <a 
                    href="{{ route('lumina.book', $book->id) }}" 
                    class="book-card shrink-0 w-40 sm:w-48 flex flex-col group cursor-pointer"
                    data-title="{{ $book->title }}"
                    data-author="{{ $book->author }}"
                    data-category="{{ $book->category }}"
                >
                    <!-- Book Cover -->
                    <div class="relative w-full h-56 sm:h-64 rounded-xl overflow-hidden bg-navy-900 border border-slate-800 group-hover:border-cyan-500/60 transition">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        
                        <!-- Simple Rating Badge -->
                        <div class="absolute top-2 left-2 bg-navy-950/80 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold text-amber-400">
                            ★ {{ $book->rating }}
                        </div>

                        <!-- Hover Play Indicator -->
                        <div class="absolute inset-0 bg-navy-950/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                            <span class="w-10 h-10 rounded-full bg-cyan-500 text-navy-950 font-bold flex items-center justify-center text-sm shadow-lg transform group-hover:scale-105 transition">
                                ▶
                            </span>
                        </div>
                    </div>

                    <!-- Clean Book Info Below Cover -->
                    <div class="pt-2">
                        <h4 class="font-display font-bold text-xs sm:text-sm text-white group-hover:text-cyan-400 transition truncate">
                            {{ $book->title }}
                        </h4>
                        <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ $book->author }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endforeach
    </div>

</div>

<script>
    function scrollRow(rowId, offset) {
        const row = document.getElementById(rowId);
        if (row) {
            row.scrollBy({ left: offset, behavior: 'smooth' });
        }
    }
</script>
@endsection
