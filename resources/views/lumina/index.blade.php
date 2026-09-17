@extends('layouts.lumina')

@section('title', 'Lumina - Streaming Library & AI Learning Space')

@section('content')
<div class="space-y-12">

    <!-- ========================================== -->
    <!-- 1. HERO BANNER CAROUSEL (NETFLIX-STYLE)    -->
    <!-- ========================================== -->
    <section class="relative w-full min-h-[520px] lg:min-h-[580px] flex items-center overflow-hidden">
        <!-- Background Cinematic Image with Gradient Overlay -->
        <div class="absolute inset-0 z-0">
            <img 
                src="{{ $featuredBook->banner_url }}" 
                alt="{{ $featuredBook->title }}" 
                class="w-full h-full object-cover object-center opacity-35 filter brightness-90 transform scale-105 transition-transform duration-1000"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/80 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-navy-950 via-navy-950/90 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full flex flex-col lg:flex-row items-center justify-between gap-8">
            <!-- Left Info Content -->
            <div class="max-w-2xl space-y-4 text-left">
                <!-- Badges / Tags -->
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-400/40 text-xs font-bold font-mono uppercase tracking-wider flex items-center gap-1.5 shadow-glow-cyan">
                        <span>✨</span> {{ $featuredBook->trending_label ?? 'Buku Pilihan AI Pekan Ini' }}
                    </span>
                    <span class="px-2.5 py-1 rounded-full bg-navy-800/80 border border-slate-700 text-xs text-slate-300">
                        {{ $featuredBook->category }}
                    </span>
                    <span class="px-2.5 py-1 rounded-full bg-navy-800/80 border border-slate-700 text-xs text-slate-300">
                        🎓 {{ $featuredBook->grade_level }}
                    </span>
                </div>

                <!-- Main Title -->
                <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-tight">
                    {{ $featuredBook->title }}
                </h1>

                <!-- Subtitle / Author & Meta -->
                <div class="flex items-center gap-4 text-xs sm:text-sm text-slate-300">
                    <span class="font-semibold text-cyan-400">Oleh {{ $featuredBook->author }}</span>
                    <span>•</span>
                    <span class="text-amber-400 font-bold flex items-center gap-1">★ {{ $featuredBook->rating }}</span>
                    <span>•</span>
                    <span>⏱️ Estimasi {{ $featuredBook->reading_time_minutes }} Menit Tamat</span>
                    <span>•</span>
                    <span>👥 {{ $featuredBook->total_readers }}+ Siswa Membaca</span>
                </div>

                <!-- Bite-Sized AI Summary (Highlighted) -->
                <div class="p-3.5 rounded-2xl glass-panel border border-cyan-500/25 max-w-xl">
                    <div class="flex items-center gap-2 mb-1.5 text-xs font-bold text-cyan-300">
                        <span>💡</span>
                        <span>Ringkasan Singkat AI Lumina:</span>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed italic line-clamp-2">
                        "{{ $featuredBook->ai_summary_1 }}"
                    </p>
                </div>

                <!-- Action CTA Buttons -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ route('lumina.reader', $featuredBook->id) }}" class="bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-black px-6 py-3 rounded-xl text-sm flex items-center gap-2 shadow-glow-cyan transition hover:scale-105 active:scale-95">
                        <span>▶</span>
                        <span>Mulai Baca Sekarang</span>
                    </a>

                    <button 
                        onclick="startAudiobook('{{ addslashes($featuredBook->title) }}', '{{ addslashes($featuredBook->author) }}', '{{ $featuredBook->cover_url }}', '{{ addslashes($featuredBook->audio_text) }}')" 
                        class="bg-navy-800/90 hover:bg-slate-800 text-white font-bold px-5 py-3 rounded-xl text-sm border border-slate-700 hover:border-cyan-400/60 flex items-center gap-2 transition hover:scale-105 active:scale-95"
                    >
                        <span>🎧</span>
                        <span>Dengar Audio (TTS)</span>
                    </button>

                    <button 
                        onclick="openRoleplayModal(1)" 
                        class="bg-lumina-purple/20 hover:bg-lumina-purple/30 text-purple-200 font-bold px-4 py-3 rounded-xl text-sm border border-purple-500/40 flex items-center gap-2 transition hover:scale-105 active:scale-95 shadow-glow-purple"
                    >
                        <span>🎙️</span>
                        <span>Tanya Bung Karno</span>
                    </button>

                    <a href="{{ route('lumina.book', $featuredBook->id) }}" class="px-3.5 py-3 text-xs text-slate-400 hover:text-white transition">
                        Detail Selengkapnya →
                    </a>
                </div>
            </div>

            <!-- Right Book Showcase 3D Floating Cover -->
            <div class="relative group hidden lg:block">
                <div class="absolute -inset-4 bg-gradient-to-r from-cyan-500 to-lumina-purple rounded-3xl opacity-30 blur-2xl group-hover:opacity-60 transition duration-500"></div>
                <div class="relative w-64 h-96 rounded-2xl overflow-hidden border-2 border-slate-700/80 shadow-2xl group-hover:border-cyan-400 transition transform group-hover:-translate-y-2">
                    <img src="{{ $featuredBook->cover_url }}" alt="{{ $featuredBook->title }}" class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3 bg-navy-950/80 backdrop-blur px-2.5 py-1 rounded-full text-[10px] font-bold text-amber-400 border border-amber-400/30">
                        ★ {{ $featuredBook->rating }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 2. STUDENT LIVE XP & QUEST RIBBON         -->
    <!-- ========================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20">
        <div class="glass-panel p-4 sm:p-5 rounded-2xl border border-slate-800 shadow-xl flex flex-col lg:flex-row items-center justify-between gap-4">
            
            <!-- Student Stats -->
            <div class="flex items-center gap-4 w-full lg:w-auto">
                <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-2xl">
                    🦅
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-white text-sm">Fraksi {{ $student['house'] }}</span>
                        <span class="px-2 py-0.2 rounded-full text-[10px] font-bold bg-cyan-500/20 text-cyan-300">Peringkat 2 Sekolah</span>
                    </div>
                    <p class="text-xs text-slate-400">Total Jam Bacamu: <strong class="text-cyan-400">{{ $student['reading_minutes'] }} Menit</strong> • Streak: <strong class="text-orange-400">🔥 {{ $student['streak_days'] }} Hari</strong></p>
                </div>
            </div>

            <!-- Active Quest Highlight -->
            <div class="flex-1 max-w-xl w-full bg-navy-900/80 p-3 rounded-xl border border-slate-800/80 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="text-2xl">🍃</span>
                    <div class="min-w-0">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400">Misi Mingguan Aktif:</span>
                        <h5 class="text-xs font-bold text-white truncate">Baca 2 Bab Tema Lingkungan Hidup</h5>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <div class="text-right">
                        <span class="text-xs font-mono font-bold text-cyan-400">1 / 2 Bab</span>
                        <div class="w-20 bg-slate-800 h-1.5 rounded-full overflow-hidden mt-1">
                            <div class="bg-cyan-400 h-full w-1/2 rounded-full"></div>
                        </div>
                    </div>
                    <a href="{{ route('lumina.gamification') }}" class="px-2.5 py-1.5 rounded-lg bg-navy-800 hover:bg-slate-700 text-[11px] font-bold text-slate-200 transition">
                        Lihat Misi
                    </a>
                </div>
            </div>

            <!-- Matchmaker Trigger button -->
            <button onclick="openMatchmakerModal()" class="w-full lg:w-auto px-4 py-3 rounded-xl bg-gradient-to-r from-cyan-500/20 to-blue-600/20 hover:from-cyan-500/30 hover:to-blue-600/30 border border-cyan-500/40 text-cyan-300 text-xs font-bold flex items-center justify-center gap-2 transition hover:scale-105 active:scale-95">
                <span>🎯 Uji Kuis Minat AI</span>
            </button>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 3. NETFLIX HORIZONTAL SWIPEABLE ROWS      -->
    <!-- ========================================== -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        @foreach($rows as $rowIndex => $row)
        <section class="space-y-4">
            <!-- Row Header with Nav Controls -->
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-display font-extrabold text-xl sm:text-2xl text-white tracking-tight">{{ $row['title'] }}</h2>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-800 text-cyan-300 border border-slate-700">
                            {{ $row['badge'] }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $row['subtitle'] }}</p>
                </div>

                <!-- Left / Right Carousel Controls -->
                <div class="flex items-center gap-2">
                    <button onclick="scrollRow('row-{{ $rowIndex }}', -320)" class="w-8 h-8 rounded-full bg-navy-900 border border-slate-700 hover:border-cyan-400 text-slate-300 hover:text-white flex items-center justify-center transition active:scale-95">
                        ‹
                    </button>
                    <button onclick="scrollRow('row-{{ $rowIndex }}', 320)" class="w-8 h-8 rounded-full bg-navy-900 border border-slate-700 hover:border-cyan-400 text-slate-300 hover:text-white flex items-center justify-center transition active:scale-95">
                        ›
                    </button>
                </div>
            </div>

            <!-- Horizontal Swipeable Track -->
            <div id="row-{{ $rowIndex }}" class="flex gap-4 sm:gap-5 overflow-x-auto no-scrollbar scroll-smooth py-3 px-1">
                @foreach($row['books'] as $book)
                <div 
                    class="book-card shrink-0 w-48 sm:w-56 rounded-2xl glass-panel border border-slate-800 hover:border-cyan-500/60 overflow-hidden flex flex-col group cursor-pointer"
                    data-title="{{ $book->title }}"
                    data-author="{{ $book->author }}"
                    data-category="{{ $book->category }}"
                >
                    <!-- Book Cover Image with Badges -->
                    <div class="relative w-full h-64 sm:h-72 overflow-hidden bg-navy-900">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-transparent to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                        
                        <!-- Rating & Category Tag -->
                        <div class="absolute top-2.5 left-2.5 flex items-center gap-1.5">
                            <span class="px-2 py-0.5 rounded-md bg-navy-950/80 backdrop-blur text-[10px] font-bold text-amber-400 border border-amber-400/30">
                                ★ {{ $book->rating }}
                            </span>
                        </div>
                        <div class="absolute top-2.5 right-2.5">
                            <span class="px-2 py-0.5 rounded-md bg-cyan-950/80 backdrop-blur text-[10px] font-bold text-cyan-300 border border-cyan-500/30">
                                {{ $book->reading_time_minutes }}m
                            </span>
                        </div>

                        <!-- Hover Action Quick Bar -->
                        <div class="absolute inset-x-0 bottom-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex items-center justify-between gap-1.5 bg-navy-950/90 backdrop-blur">
                            <a href="{{ route('lumina.reader', $book->id) }}" class="flex-1 py-1.5 rounded-lg bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-black text-center text-xs transition">
                                Baca
                            </a>
                            <button 
                                onclick="startAudiobook('{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ $book->cover_url }}', '{{ addslashes($book->audio_text) }}')" 
                                class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center text-xs transition" 
                                title="Dengarkan Audio"
                            >
                                🎧
                            </button>
                            <a href="{{ route('lumina.book', $book->id) }}" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center text-xs transition" title="Detail Buku">
                                ℹ️
                            </a>
                        </div>
                    </div>

                    <!-- Book Info Container -->
                    <div class="p-3.5 flex flex-col flex-1 justify-between gap-2">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-400 line-clamp-1">{{ $book->category }}</span>
                            <h4 class="font-display font-bold text-xs sm:text-sm text-white group-hover:text-cyan-300 transition line-clamp-1 mt-0.5">
                                {{ $book->title }}
                            </h4>
                            <p class="text-[11px] text-slate-400 line-clamp-1">{{ $book->author }}</p>
                        </div>
                        <div class="pt-1.5 border-t border-slate-800 text-[10px] text-slate-400 flex items-center justify-between">
                            <span>🎓 {{ $book->grade_level }}</span>
                            <span class="text-cyan-400 group-hover:underline">Buka →</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endforeach
    </div>

    <!-- ========================================== -->
    <!-- 4. ROLEPLAY AI TOKOH SPOTLIGHT             -->
    <!-- ========================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="p-6 sm:p-8 rounded-3xl glass-panel border border-lumina-purple/30 relative overflow-hidden bg-gradient-to-br from-navy-900/90 via-navy-950 to-navy-900">
            <!-- Background glow -->
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-lumina-purple/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 pb-6 border-b border-slate-800">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-purple-500/20 text-purple-300 border border-purple-500/30">
                            🎙️ Fitur Unggulan AI
                        </span>
                    </div>
                    <h3 class="font-display font-extrabold text-2xl sm:text-3xl text-white mt-1">
                        Tanya Tokoh Buku (Roleplay AI)
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1 max-w-2xl">
                        Jangan cuma membaca buku sejarah atau sastra secara pasif! Wawancarai langsung pahlawan proklamator, pejuang emansipasi, hingga filsuf dunia seolah mereka hadir di hadapanmu.
                    </p>
                </div>
                <button onclick="openRoleplayModal(1)" class="bg-lumina-purple hover:bg-purple-500 text-white font-bold px-6 py-3 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-glow-purple transition hover:scale-105 active:scale-95 shrink-0">
                    <span>💬 Mulai Chatting dengan Tokoh</span>
                </button>
            </div>

            <!-- Characters Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                @foreach($characters as $char)
                <div onclick="openRoleplayModal({{ $char->id }})" class="p-4 rounded-2xl bg-navy-900/80 border border-slate-800 hover:border-purple-500/60 hover:bg-slate-800/50 transition cursor-pointer group flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ $char->avatar }}" alt="{{ $char->name }}" class="w-12 h-12 rounded-xl object-cover border border-slate-700 group-hover:border-purple-400 transition">
                        <div class="min-w-0">
                            <h5 class="font-display font-bold text-xs sm:text-sm text-white group-hover:text-purple-300 transition truncate">{{ $char->name }}</h5>
                            <p class="text-[11px] text-slate-400 truncate">{{ $char->role_title }}</p>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-300 italic mt-3 bg-navy-950/60 p-2 rounded-lg border border-slate-800 line-clamp-2">
                        "{{ $char->greeting_message }}"
                    </p>
                    <div class="mt-3 flex items-center justify-between text-[10px] text-purple-400 font-bold pt-2 border-t border-slate-800/80">
                        <span>Dari: {{ $char->book->title }}</span>
                        <span class="group-hover:translate-x-1 transition">Tanya →</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 5. SISTEM FRAKSI SEKOLAH & PIALA MEMBACA  -->
    <!-- ========================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-display font-extrabold text-xl sm:text-2xl text-white">🏆 Perebutan Piala Membaca Antar-Fraksi</h3>
                    <p class="text-xs text-slate-400">Setiap menit membaca dikonversi menjadi poin kemenangan fraksi sekolahmu!</p>
                </div>
                <a href="{{ route('lumina.gamification') }}" class="text-xs font-bold text-cyan-400 hover:underline">
                    Lihat Papan Peringkat Lengkap →
                </a>
            </div>

            <!-- 4 Houses Mini Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($houses as $hIndex => $house)
                <div class="p-4 rounded-2xl glass-panel border border-slate-800 hover:border-cyan-500/50 transition relative overflow-hidden group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-3xl">{{ $house->emblem }}</span>
                            <div>
                                <h4 class="font-display font-bold text-sm text-white">{{ $house->name }}</h4>
                                <span class="text-[10px] text-slate-400">{{ $house->member_count }} Siswa</span>
                            </div>
                        </div>
                        <span class="font-display font-extrabold text-lg text-cyan-300 font-mono">
                            #{{ $hIndex + 1 }}
                        </span>
                    </div>

                    <!-- Points Bar -->
                    <div class="mt-4 space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">Skor Total:</span>
                            <span class="font-bold text-white font-mono">{{ number_format($house->total_points, 0, ',', '.') }} Poin</span>
                        </div>
                        <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                            @php
                                $pct = min(100, round(($house->total_points / 4000) * 100));
                            @endphp
                            <div class="h-full rounded-full transition-all duration-700" style="width: {{ $pct }}%; background-color: {{ $house->color_hex }};"></div>
                        </div>
                    </div>

                    <p class="text-[11px] text-slate-400 italic mt-3 border-t border-slate-800/80 pt-2 line-clamp-1">
                        "{{ $house->motto }}"
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

</div>

<script>
    // Horizontal row scrolling function
    function scrollRow(rowId, offset) {
        const row = document.getElementById(rowId);
        if (row) {
            row.scrollBy({ left: offset, behavior: 'smooth' });
        }
    }
</script>
@endsection
