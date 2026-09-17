@extends('layouts.lumina')

@section('title', 'Lumina - Smart Digital Library')

@section('content')
<div class="space-y-10">

    <!-- ==================================================== -->
    <!-- 1. CINEMATIC HERO SPOTLIGHT (MIDNIGHT ROSE STREAMING)-->
    <!-- ==================================================== -->
    <div class="relative rounded-3xl overflow-hidden border border-pink-500/20 bg-gradient-to-br from-plum-900 via-plum-850 to-plum-950 p-6 sm:p-10 shadow-2xl">
        <!-- Soft Pink Ambient Glow behind featured cover -->
        <div class="absolute -right-10 -top-10 w-96 h-96 bg-pink-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -bottom-10 w-80 h-80 bg-rose-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <!-- Left Info -->
            <div class="max-w-xl space-y-4 text-left">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-pink-500/20 text-pink-300 border border-pink-500/30 text-xs font-bold font-mono uppercase tracking-wider flex items-center gap-1.5 shadow-sm shadow-pink-500/10">
                        <span class="w-2 h-2 rounded-full bg-pink-400 animate-pulse"></span>
                        🌸 Buku Pilihan Pekan Ini
                    </span>
                    <span class="text-xs text-pink-200/60">{{ $featuredBook->category }}</span>
                </div>

                <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-tight">
                    {{ $featuredBook->title }}
                </h1>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed line-clamp-3">
                    {{ $featuredBook->synopsis }}
                </p>

                <!-- 3 Bite-Sized AI Bullet Points (Highlighted) -->
                <div class="p-3.5 rounded-2xl bg-plum-950/70 border border-pink-500/20 space-y-1.5 text-xs text-slate-200">
                    <span class="font-bold text-pink-300 text-[11px] block uppercase tracking-wide">💡 Rangkuman AI Lumina:</span>
                    <p class="italic text-pink-100/90">"{{ $featuredBook->ai_summary_1 }}"</p>
                </div>

                <div class="flex items-center gap-3 text-xs text-slate-400 pt-1">
                    <span class="text-amber-400 font-bold flex items-center gap-1">★ {{ $featuredBook->rating }}</span>
                    <span>•</span>
                    <span>Oleh <strong class="text-pink-200">{{ $featuredBook->author }}</strong></span>
                    <span>•</span>
                    <span>⏱️ {{ $featuredBook->reading_time_minutes }} Menit Baca</span>
                </div>

                <!-- 2 Cute & High-Contrast Action Buttons -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ route('lumina.reader', $featuredBook->id) }}" class="bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 hover:from-pink-400 hover:to-rose-400 text-white font-extrabold px-6 py-3 rounded-xl text-xs sm:text-sm shadow-lg shadow-pink-500/30 flex items-center gap-2 transition hover:scale-105 active:scale-95">
                        <span>▶</span>
                        <span>Mulai Baca</span>
                    </a>

                    <button 
                        onclick="startAudiobook('{{ addslashes($featuredBook->title) }}', '{{ addslashes($featuredBook->author) }}', '{{ $featuredBook->cover_url }}', '{{ addslashes($featuredBook->audio_text) }}')" 
                        class="bg-white/10 hover:bg-white/15 text-pink-200 hover:text-white font-bold px-5 py-3 rounded-xl text-xs sm:text-sm border border-pink-400/20 flex items-center gap-2 transition hover:scale-105 active:scale-95"
                    >
                        <span>🎧</span>
                        <span>Dengar Audio</span>
                    </button>

                    <a href="{{ route('lumina.book', $featuredBook->id) }}" class="text-xs text-pink-300/70 hover:text-pink-200 px-2 py-3 transition">
                        Detail Lengkap →
                    </a>
                </div>
            </div>

            <!-- Right 3D Book Cover Presentation -->
            <div class="relative shrink-0 hidden md:block group">
                <div class="absolute -inset-2 bg-gradient-to-tr from-pink-500/30 to-rose-500/30 rounded-2xl blur-xl group-hover:blur-2xl transition duration-500"></div>
                <div class="relative w-48 lg:w-56 aspect-[3/4] rounded-2xl overflow-hidden border border-pink-400/30 cover-shadow transform group-hover:-translate-y-2 transition duration-300">
                    <img src="{{ $featuredBook->cover_url }}" alt="{{ $featuredBook->title }}" class="w-full h-full object-cover">
                    <div class="absolute top-2.5 right-2.5 bg-plum-950/80 backdrop-blur px-2.5 py-1 rounded-full text-[10px] font-bold text-amber-400 border border-amber-400/30">
                        ★ {{ $featuredBook->rating }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================================================== -->
    <!-- 2. SLEEK 3-TAB NAVIGATOR (PINKY STREAMING STYLE)     -->
    <!-- ==================================================== -->
    <div class="flex items-center justify-between border-b border-pink-500/10 pb-4">
        <div class="flex items-center gap-2 p-1 rounded-2xl bg-plum-900 border border-pink-500/20">
            <button onclick="switchTab('katalog')" id="tabBtn-katalog" class="tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-md shadow-pink-500/30 flex items-center gap-2">
                <span>📚</span>
                <span>Rak Buku</span>
            </button>
            <button onclick="switchTab('ai')" id="tabBtn-ai" class="tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition text-slate-400 hover:text-pink-200 hover:bg-white/5 flex items-center gap-2">
                <span>🤖</span>
                <span>Fitur AI & Tokoh</span>
            </button>
            <button onclick="switchTab('fraksi')" id="tabBtn-fraksi" class="tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition text-slate-400 hover:text-pink-200 hover:bg-white/5 flex items-center gap-2">
                <span>🏆</span>
                <span>Piala Fraksi</span>
            </button>
        </div>

        <div class="hidden sm:flex items-center gap-2 text-xs text-pink-300/70">
            <span>🌸 Rayhan</span>
            <span class="text-pink-400 font-bold">• 1.450 XP</span>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 1: RAK BUKU (STREAMING CATALOG)        -->
    <!-- ========================================== -->
    <div id="tabContent-katalog" class="tab-content space-y-8">
        
        <!-- Genre Filter Chips -->
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
            <button onclick="filterCategory('all', this)" class="cat-pill px-3.5 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-pink-500 to-rose-500 text-white transition shrink-0 shadow-sm shadow-pink-500/25">
                ✨ Semua Koleksi ({{ $allBooks->count() }})
            </button>
            <button onclick="filterCategory('Sejarah', this)" class="cat-pill px-3.5 py-1.5 rounded-full text-xs font-semibold bg-plum-900 border border-pink-500/20 text-slate-300 hover:text-pink-200 hover:bg-plum-800 transition shrink-0">
                🏛️ Sejarah & Tokoh
            </button>
            <button onclick="filterCategory('Sastra', this)" class="cat-pill px-3.5 py-1.5 rounded-full text-xs font-semibold bg-plum-900 border border-pink-500/20 text-slate-300 hover:text-pink-200 hover:bg-plum-800 transition shrink-0">
                📖 Sastra & Fiksi
            </button>
            <button onclick="filterCategory('Sains', this)" class="cat-pill px-3.5 py-1.5 rounded-full text-xs font-semibold bg-plum-900 border border-pink-500/20 text-slate-300 hover:text-pink-200 hover:bg-plum-800 transition shrink-0">
                🔭 Sains & Teknologi
            </button>
            <button onclick="filterCategory('Pengembangan', this)" class="cat-pill px-3.5 py-1.5 rounded-full text-xs font-semibold bg-plum-900 border border-pink-500/20 text-slate-300 hover:text-pink-200 hover:bg-plum-800 transition shrink-0">
                🌿 Stoisisme & Jiwa
            </button>
            <button onclick="filterCategory('Lingkungan', this)" class="cat-pill px-3.5 py-1.5 rounded-full text-xs font-semibold bg-plum-900 border border-pink-500/20 text-slate-300 hover:text-pink-200 hover:bg-plum-800 transition shrink-0">
                🍃 Lingkungan Hidup
            </button>
        </div>

        <!-- 4-Column Book Grid with Visual Depth -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5" id="booksGrid">
            @foreach($allBooks as $book)
            <div 
                class="book-card group cursor-pointer flex flex-col justify-between p-3 rounded-2xl glass-card border border-pink-500/15 hover:border-pink-400/60"
                data-title="{{ $book->title }}"
                data-author="{{ $book->author }}"
                data-category="{{ $book->category }}"
            >
                <a href="{{ route('lumina.book', $book->id) }}" class="block">
                    <!-- Book Cover -->
                    <div class="relative w-full aspect-[3/4] rounded-xl overflow-hidden bg-plum-950 border border-pink-500/20 group-hover:shadow-xl transition duration-300">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        
                        <!-- Rating & Duration Tags -->
                        <div class="absolute top-2 left-2 bg-plum-950/85 backdrop-blur px-2 py-0.5 rounded-md text-[10px] font-bold text-amber-400 border border-amber-400/20">
                            ★ {{ $book->rating }}
                        </div>
                        <div class="absolute top-2 right-2 bg-plum-950/85 backdrop-blur px-2 py-0.5 rounded-md text-[10px] font-bold text-pink-300 border border-pink-400/20">
                            {{ $book->reading_time_minutes }}m
                        </div>
                    </div>

                    <!-- Clean Typography -->
                    <div class="pt-3 space-y-1 text-left">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-pink-400 block line-clamp-1">{{ $book->category }}</span>
                        <h4 class="font-display font-bold text-sm text-white group-hover:text-pink-300 transition line-clamp-1 leading-snug">
                            {{ $book->title }}
                        </h4>
                        <p class="text-xs text-slate-400 truncate">{{ $book->author }}</p>
                    </div>
                </a>

                <!-- Quick Action Bar -->
                <div class="flex items-center gap-2 pt-3 mt-2 border-t border-white/5">
                    <a href="{{ route('lumina.reader', $book->id) }}" class="flex-1 py-2 rounded-xl bg-white/10 hover:bg-pink-500 hover:text-white text-pink-100 text-xs font-bold text-center transition">
                        Baca
                    </a>
                    <button 
                        onclick="startAudiobook('{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ $book->cover_url }}', '{{ addslashes($book->audio_text) }}')" 
                        class="p-2 rounded-xl bg-white/10 hover:bg-plum-800 text-pink-200 text-xs transition"
                        title="Dengar Audiobook"
                    >
                        🎧
                    </button>
                    <a href="{{ route('lumina.book', $book->id) }}" class="p-2 rounded-xl bg-white/10 hover:bg-plum-800 text-pink-200 text-xs transition" title="Detail">
                        ℹ️
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 2: FITUR AI & WAWANCARA TOKOH          -->
    <!-- ========================================== -->
    <div id="tabContent-ai" class="tab-content hidden space-y-8">
        
        <!-- 1. AI Book Matchmaker -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 space-y-6">
            <div class="flex items-start justify-between border-b border-pink-500/15 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-pink-500/20 text-pink-300 flex items-center justify-center text-xl">
                        🎯
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-lg text-white">AI Book Matchmaker</h3>
                        <p class="text-xs text-slate-400">Pilih suasana hatimu, biarkan AI meracik rekomendasi harian yang presisi.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Step 1 -->
                <div class="space-y-2 text-left">
                    <label class="block text-xs font-bold text-pink-300 uppercase tracking-wider">1. Mood Membaca</label>
                    <div class="space-y-2">
                        <button type="button" onclick="selectCleanQuiz('mood', 'santai', this)" class="clean-quiz-btn w-full p-3 rounded-xl border border-pink-500 bg-pink-500/20 text-pink-200 text-left text-xs font-semibold transition">
                            ☕ Santai & Tenang (Habis Ujian)
                        </button>
                        <button type="button" onclick="selectCleanQuiz('mood', 'semangat', this)" class="clean-quiz-btn w-full p-3 rounded-xl border border-white/10 hover:bg-white/5 text-slate-300 text-left text-xs font-semibold transition">
                            🔥 Membara & Cari Inspirasi
                        </button>
                        <button type="button" onclick="selectCleanQuiz('mood', 'fokus', this)" class="clean-quiz-btn w-full p-3 rounded-xl border border-white/10 hover:bg-white/5 text-slate-300 text-left text-xs font-semibold transition">
                            🧠 Ingin Tahu Konsep Mendalam
                        </button>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="space-y-2 text-left">
                    <label class="block text-xs font-bold text-pink-300 uppercase tracking-wider">2. Topik Favorit</label>
                    <div class="space-y-2">
                        <button type="button" onclick="selectCleanQuiz('interest', 'sejarah', this)" class="clean-quiz-btn w-full p-3 rounded-xl border border-pink-500 bg-pink-500/20 text-pink-200 text-left text-xs font-semibold transition">
                            🏛️ Sejarah & Tokoh Pahlawan
                        </button>
                        <button type="button" onclick="selectCleanQuiz('interest', 'sains', this)" class="clean-quiz-btn w-full p-3 rounded-xl border border-white/10 hover:bg-white/5 text-slate-300 text-left text-xs font-semibold transition">
                            🚀 Sains, Kosmos & AI
                        </button>
                        <button type="button" onclick="selectCleanQuiz('interest', 'santai', this)" class="clean-quiz-btn w-full p-3 rounded-xl border border-white/10 hover:bg-white/5 text-slate-300 text-left text-xs font-semibold transition">
                            🌿 Filosofi Stoisisme & Jiwa
                        </button>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="space-y-2 text-left">
                    <label class="block text-xs font-bold text-pink-300 uppercase tracking-wider">3. Waktu Luang</label>
                    <div class="space-y-2">
                        <button type="button" onclick="selectCleanQuiz('duration', 15, this)" class="clean-quiz-btn w-full p-3 rounded-xl border border-white/10 hover:bg-white/5 text-slate-300 text-left text-xs font-semibold transition">
                            ⏱️ 15 Menit (Cepat di Angkot)
                        </button>
                        <button type="button" onclick="selectCleanQuiz('duration', 30, this)" class="clean-quiz-btn w-full p-3 rounded-xl border border-pink-500 bg-pink-500/20 text-pink-200 text-left text-xs font-semibold transition">
                            ⏱️ 30 Menit (Sedang di Perpus)
                        </button>
                        <button type="button" onclick="selectCleanQuiz('duration', 45, this)" class="clean-quiz-btn w-full p-3 rounded-xl border border-white/10 hover:bg-white/5 text-slate-300 text-left text-xs font-semibold transition">
                            ⏱️ 45+ Menit (Mendalam)
                        </button>
                    </div>
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button onclick="submitCleanMatchmaker()" id="submitCleanQuizBtn" class="bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-400 hover:to-rose-400 text-white font-extrabold px-6 py-3 rounded-xl text-xs sm:text-sm shadow-lg shadow-pink-500/30 transition hover:scale-105 active:scale-95">
                    ✨ Racik Rekomendasi AI
                </button>
            </div>

            <!-- Results -->
            <div id="cleanMatchResults" class="hidden pt-4 border-t border-pink-500/15 space-y-3">
                <div class="p-3.5 bg-pink-950/40 border border-pink-500/30 rounded-2xl text-xs text-slate-200">
                    <strong class="text-pink-300 font-bold">💡 Analisis AI:</strong>
                    <span id="cleanAnalysisText" class="ml-1 text-pink-100"></span>
                </div>
                <div id="cleanMatchedList" class="grid grid-cols-1 sm:grid-cols-2 gap-3"></div>
            </div>
        </div>

        <!-- 2. Roleplay Tokoh Buku -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-pink-500/15 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-300 flex items-center justify-center text-xl">
                        🎙️
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-lg text-white">Tanya Tokoh Buku (Roleplay AI)</h3>
                        <p class="text-xs text-slate-400">Pilih tokoh pahlawan atau karakter buku untuk diajak berdialog.</p>
                    </div>
                </div>

                <!-- Character Switcher Pills -->
                <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar">
                    <button onclick="selectCleanCharacter(1, this)" class="char-pill px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-pink-500 to-rose-500 text-white transition">
                        Bung Karno
                    </button>
                    <button onclick="selectCleanCharacter(2, this)" class="char-pill px-3 py-1.5 rounded-xl text-xs font-medium bg-white/10 text-slate-300 hover:text-white transition">
                        Minke
                    </button>
                    <button onclick="selectCleanCharacter(3, this)" class="char-pill px-3 py-1.5 rounded-xl text-xs font-medium bg-white/10 text-slate-300 hover:text-white transition">
                        R.A. Kartini
                    </button>
                    <button onclick="selectCleanCharacter(4, this)" class="char-pill px-3 py-1.5 rounded-xl text-xs font-medium bg-white/10 text-slate-300 hover:text-white transition">
                        Marcus Aurelius
                    </button>
                </div>
            </div>

            <!-- Chat Window -->
            <div class="border border-pink-500/20 rounded-2xl overflow-hidden bg-plum-950/70">
                <div class="p-4 bg-plum-900 border-b border-pink-500/15 flex items-center gap-3">
                    <img id="activeCharAvatar" src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=120&q=80" class="w-10 h-10 rounded-xl object-cover border border-pink-400/40">
                    <div>
                        <h4 id="activeCharName" class="font-bold text-sm text-white">Ir. Soekarno (Bung Karno)</h4>
                        <p id="activeCharRole" class="text-xs text-pink-300/80">Proklamator & Presiden RI Pertama</p>
                    </div>
                </div>

                <div id="cleanChatHistory" class="p-4 space-y-3 max-h-72 overflow-y-auto text-xs sm:text-sm">
                    <div class="flex gap-3 items-start">
                        <div class="bg-plum-900 border border-pink-500/20 rounded-2xl p-3.5 max-w-[85%] text-slate-200">
                            <p id="activeCharGreeting">Merdeka! Wahai anak mudaku pembawa panji masa depan bangsa! Ada kegelisahan apa di dadamu tentang negerimu yang indah ini? Tanyakanlah, mari kita berdiskusi!</p>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-plum-900 border-t border-pink-500/15 flex items-center gap-2">
                    <input 
                        type="text" 
                        id="cleanChatInput" 
                        placeholder="Ketik pertanyaan untuk tokoh ini..." 
                        class="flex-1 bg-plum-950 border border-pink-500/20 rounded-xl px-4 py-2.5 text-xs sm:text-sm text-white placeholder-pink-300/40 focus:outline-none focus:border-pink-400"
                        onkeydown="if(event.key === 'Enter') sendCleanChatMessage()"
                    >
                    <button onclick="sendCleanChatMessage()" class="bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-400 hover:to-rose-400 text-white font-bold px-4 py-2.5 rounded-xl text-xs sm:text-sm transition shadow">
                        Kirim
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- TAB 3: FRAKSI & PIALA MEMBACA              -->
    <!-- ========================================== -->
    <div id="tabContent-fraksi" class="tab-content hidden space-y-8">
        
        <div>
            <h3 class="font-display font-extrabold text-xl text-white">🏆 Perebutan Piala Membaca Antar-Fraksi</h3>
            <p class="text-xs text-slate-400 mt-1">Setiap menit membaca seluruh siswa menyumbang poin untuk kemenangan fraksinya.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($houses as $hIndex => $h)
            <div class="p-5 rounded-3xl glass-card border border-pink-500/15 space-y-3 {{ $h->name === $student['house'] ? 'border-pink-400/60 shadow-lg shadow-pink-500/15 bg-pink-950/20' : '' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">{{ $h->emblem }}</span>
                        <div>
                            <h4 class="font-bold text-sm text-white">{{ $h->name }}</h4>
                            <span class="text-[11px] text-slate-400">{{ $h->member_count }} Siswa</span>
                        </div>
                    </div>
                    <span class="font-bold text-xs text-pink-400 font-mono">#{{ $hIndex + 1 }}</span>
                </div>

                <p class="text-xs text-slate-300 italic">"{{ $h->motto }}"</p>

                <div class="pt-2 border-t border-white/5">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-slate-400">Total Poin:</span>
                        <strong class="text-white font-mono font-bold">{{ number_format($h->total_points, 0, ',', '.') }}</strong>
                    </div>
                    <div class="w-full bg-plum-950 h-2 rounded-full overflow-hidden">
                        @php $p = min(100, round(($h->total_points / 4000) * 100)); @endphp
                        <div class="h-full rounded-full" style="width: {{ $p }}%; background-color: {{ $h->color_hex }};"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Top 3 Podium & Leaderboard -->
        <div class="glass-card rounded-3xl overflow-hidden p-6 sm:p-8 space-y-4">
            <h4 class="font-display font-bold text-base text-white">Peringkat 5 Teratas Siswa Pembaca Bulan Ini</h4>
            <div class="divide-y divide-white/5 text-xs sm:text-sm">
                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">🥇</span>
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Siti" class="w-8 h-8 rounded-full bg-plum-800 border border-slate-700">
                        <div>
                            <span class="font-bold text-white block">Siti Nurhaliza</span>
                            <span class="text-[11px] text-slate-400">12 IPS 1 • 🐉 Komodo Wira</span>
                        </div>
                    </div>
                    <span class="font-mono text-pink-300 font-bold">1.840 Menit</span>
                </div>

                <div class="py-3 flex items-center justify-between bg-pink-500/10 -mx-6 px-6 border-l-4 border-pink-400">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">🥈</span>
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Rayhan" class="w-8 h-8 rounded-full bg-plum-800 border border-pink-400">
                        <div>
                            <span class="font-bold text-white block">Rayhan Alfarizi (Kamu)</span>
                            <span class="text-[11px] text-pink-300">11 IPA 2 • 🦅 Garuda Cendekia</span>
                        </div>
                    </div>
                    <span class="font-mono text-pink-300 font-bold">1.045 Menit</span>
                </div>

                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">🥉</span>
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Aditya" class="w-8 h-8 rounded-full bg-plum-800 border border-slate-700">
                        <div>
                            <span class="font-bold text-white block">Aditya Pratama</span>
                            <span class="text-[11px] text-slate-400">10 MIPA 3 • 🌊 Elang Samudra</span>
                        </div>
                    </div>
                    <span class="font-mono text-pink-300 font-bold">980 Menit</span>
                </div>
            </div>

            <div class="pt-2 text-center">
                <a href="{{ route('lumina.gamification') }}" class="text-xs text-pink-400 font-bold hover:underline">
                    Buka Papan Peringkat Lengkap & Misi Mingguan →
                </a>
            </div>
        </div>

    </div>

</div>

<!-- Scripts -->
<script>
    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('bg-gradient-to-r', 'from-pink-500', 'to-rose-500', 'text-white', 'shadow-md', 'shadow-pink-500/30');
            b.classList.add('text-slate-400', 'hover:text-pink-200', 'hover:bg-white/5');
        });

        const targetContent = document.getElementById('tabContent-' + tabName);
        const targetBtn = document.getElementById('tabBtn-' + tabName);
        if (targetContent && targetBtn) {
            targetContent.classList.remove('hidden');
            targetBtn.classList.remove('text-slate-400', 'hover:text-pink-200', 'hover:bg-white/5');
            targetBtn.classList.add('bg-gradient-to-r', 'from-pink-500', 'to-rose-500', 'text-white', 'shadow-md', 'shadow-pink-500/30');
        }
    }

    function filterCategory(cat, btn) {
        document.querySelectorAll('.cat-pill').forEach(b => {
            b.classList.remove('bg-gradient-to-r', 'from-pink-500', 'to-rose-500', 'text-white', 'shadow-sm', 'shadow-pink-500/25');
            b.classList.add('bg-plum-900', 'text-slate-300', 'border', 'border-pink-500/20');
        });
        btn.classList.remove('bg-plum-900', 'text-slate-300', 'border', 'border-pink-500/20');
        btn.classList.add('bg-gradient-to-r', 'from-pink-500', 'to-rose-500', 'text-white', 'shadow-sm', 'shadow-pink-500/25');

        document.querySelectorAll('.book-card').forEach(card => {
            const cardCat = card.getAttribute('data-category') || '';
            if (cat === 'all' || cardCat.includes(cat)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    let cleanQuiz = { mood: 'santai', interest: 'sejarah', duration: 30 };
    function selectCleanQuiz(type, val, btn) {
        cleanQuiz[type] = val;
        btn.parentElement.querySelectorAll('button').forEach(b => {
            b.classList.remove('border-pink-500', 'bg-pink-500/20', 'text-pink-200');
            b.classList.add('border-white/10', 'text-slate-300');
        });
        btn.classList.add('border-pink-500', 'bg-pink-500/20', 'text-pink-200');
        btn.classList.remove('border-white/10', 'text-slate-300');
    }

    async function submitCleanMatchmaker() {
        const btn = document.getElementById('submitCleanQuizBtn');
        btn.disabled = true;
        btn.innerText = 'Menganalisis...';

        try {
            const res = await fetch('{{ route("lumina.api.matchmaker") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify(cleanQuiz)
            });
            const data = await res.json();

            document.getElementById('cleanMatchResults').classList.remove('hidden');
            document.getElementById('cleanAnalysisText').textContent = data.ai_analysis;

            const list = document.getElementById('cleanMatchedList');
            list.innerHTML = '';
            data.matched_books.forEach(b => {
                const card = document.createElement('div');
                card.className = 'p-3 rounded-2xl border border-pink-500/20 bg-plum-900 flex items-center justify-between gap-3';
                card.innerHTML = `
                    <div class="flex items-center gap-3 min-w-0">
                        <img src="${b.cover_url}" class="w-10 h-14 rounded-lg object-cover shrink-0">
                        <div class="min-w-0">
                            <span class="text-[10px] text-pink-400 font-bold">${b.match_score}% Match</span>
                            <h5 class="text-xs font-bold text-white truncate">${b.title}</h5>
                            <p class="text-[11px] text-slate-400 truncate">${b.author}</p>
                        </div>
                    </div>
                    <a href="/buku/${b.id}" class="px-3 py-1.5 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-400 hover:to-rose-400 text-white font-bold rounded-xl text-xs shrink-0 transition">Buka</a>
                `;
                list.appendChild(card);
            });
        } catch(e) {
            console.error(e);
            alert('Gagal mengambil rekomendasi');
        } finally {
            btn.disabled = false;
            btn.innerText = '✨ Racik Rekomendasi AI';
        }
    }

    const charactersList = {
        1: { name: 'Ir. Soekarno (Bung Karno)', role: 'Proklamator & Presiden RI Pertama', avatar: 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=120&q=80', greeting: 'Merdeka! Wahai anak mudaku pembawa panji masa depan bangsa! Ada kegelisahan apa di dadamu tentang negerimu yang indah ini? Tanyakanlah, mari kita berdiskusi!' },
        2: { name: 'Minke (Raden Mas Tirto)', role: 'Pena Perlawanan & Pribumi Terpelajar', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80', greeting: 'Salam kawan sebayaku. Di zaman serba canggihmu sekarang, apakah pena dan tulisanmu masih tajam membela yang lemah? Apa yang ingin kau diskusikan bersamaku?' },
        3: { name: 'R.A. Kartini', role: 'Pelopor Emansipasi Putri', avatar: 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&w=120&q=80', greeting: 'Salam hangat dan kasih, saudaraku. Betapa bersyukurnya aku melihatmu hari ini bisa membaca dan menuntut ilmu dengan bebas. Cita-cita apa yang sedang kau rajut di hatimu?' },
        4: { name: 'Marcus Aurelius', role: 'Kaisar Romawi & Filsuf Stoa', avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80', greeting: 'Ketenangan menyertaimu, sobat muda. Pikiranmu adalah benteng terkokohmu. Masalah apa yang sedang mengusik ketenangan batinmu hari ini? Mari kita selidiki dengan akal sehat.' }
    };
    let activeCharId = 1;

    function selectCleanCharacter(id, btn) {
        activeCharId = id;
        document.querySelectorAll('.char-pill').forEach(b => {
            b.classList.remove('bg-gradient-to-r', 'from-pink-500', 'to-rose-500', 'text-white', 'font-bold');
            b.classList.add('bg-white/10', 'text-slate-300');
        });
        btn.classList.remove('bg-white/10', 'text-slate-300');
        btn.classList.add('bg-gradient-to-r', 'from-pink-500', 'to-rose-500', 'text-white', 'font-bold');

        const c = charactersList[id];
        document.getElementById('activeCharAvatar').src = c.avatar;
        document.getElementById('activeCharName').textContent = c.name;
        document.getElementById('activeCharRole').textContent = c.role;
        document.getElementById('activeCharGreeting').textContent = c.greeting;
        document.getElementById('cleanChatHistory').innerHTML = `
            <div class="flex gap-3 items-start">
                <div class="bg-plum-900 border border-pink-500/20 rounded-2xl p-3.5 max-w-[85%] text-slate-200">
                    <p>${c.greeting}</p>
                </div>
            </div>
        `;
    }

    async function sendCleanChatMessage() {
        const input = document.getElementById('cleanChatInput');
        const text = input.value.trim();
        if (!text) return;

        const history = document.getElementById('cleanChatHistory');
        const userDiv = document.createElement('div');
        userDiv.className = 'flex justify-end';
        userDiv.innerHTML = `<div class="bg-gradient-to-r from-pink-500 to-rose-500 text-white font-semibold rounded-2xl p-3 max-w-[85%]">${text}</div>`;
        history.appendChild(userDiv);
        input.value = '';
        history.scrollTop = history.scrollHeight;

        try {
            const res = await fetch('{{ route("lumina.api.roleplay") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ character_id: activeCharId, message: text })
            });
            const data = await res.json();
            const botDiv = document.createElement('div');
            botDiv.className = 'flex justify-start';
            botDiv.innerHTML = `<div class="bg-plum-900 border border-pink-500/20 text-slate-200 rounded-2xl p-3 max-w-[85%] leading-relaxed">${data.reply}</div>`;
            history.appendChild(botDiv);
            history.scrollTop = history.scrollHeight;
        } catch(e) {
            console.error(e);
            alert('Gagal mengirim pesan');
        }
    }
</script>
@endsection
