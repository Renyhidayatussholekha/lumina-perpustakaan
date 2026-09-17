@extends('layouts.lumina')

@section('title', 'Lumina - Katalog & Perpustakaan Digital')

@section('content')
<div class="space-y-8">

    <!-- Tab Navigation Switcher (Notion / Apple Style) -->
    <div class="flex items-center justify-between border-b border-slate-200 pb-3">
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
            <button onclick="switchTab('katalog')" id="tabBtn-katalog" class="tab-btn px-4 py-2 rounded-xl text-sm font-semibold transition bg-slate-900 text-white shadow-sm flex items-center gap-2">
                <span>📚</span>
                <span>Katalog Buku</span>
            </button>
            <button onclick="switchTab('ai')" id="tabBtn-ai" class="tab-btn px-4 py-2 rounded-xl text-sm font-medium transition text-slate-600 hover:text-slate-900 hover:bg-slate-100 flex items-center gap-2">
                <span>🤖</span>
                <span>Fitur AI & Wawancara</span>
            </button>
            <button onclick="switchTab('fraksi')" id="tabBtn-fraksi" class="tab-btn px-4 py-2 rounded-xl text-sm font-medium transition text-slate-600 hover:text-slate-900 hover:bg-slate-100 flex items-center gap-2">
                <span>🏆</span>
                <span>Fraksi & Peringkat</span>
            </button>
        </div>

        <span class="text-xs text-slate-500 hidden sm:inline">
            Tahun Ajaran 2026/2027
        </span>
    </div>

    <!-- ========================================== -->
    <!-- TAB 1: KATALOG BUKU (BERSIH & TENANG)      -->
    <!-- ========================================== -->
    <div id="tabContent-katalog" class="tab-content space-y-8">
        
        <!-- Calm & Elegant Hero Card -->
        <div class="bg-gradient-to-r from-blue-50 via-slate-50 to-indigo-50/40 rounded-2xl border border-slate-200/80 p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="max-w-xl space-y-3 text-left">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-700 text-xs font-semibold">
                        Buku Pilihan Pekan Ini
                    </span>
                    <span class="text-xs text-slate-500">{{ $featuredBook->category }}</span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    {{ $featuredBook->title }}
                </h1>

                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-2">
                    {{ $featuredBook->synopsis }}
                </p>

                <div class="flex items-center gap-3 text-xs text-slate-500 pt-1">
                    <span class="text-amber-600 font-semibold">★ {{ $featuredBook->rating }}</span>
                    <span>•</span>
                    <span>Oleh <strong>{{ $featuredBook->author }}</strong></span>
                    <span>•</span>
                    <span>⏱️ {{ $featuredBook->reading_time_minutes }} Menit</span>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('lumina.reader', $featuredBook->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-xs sm:text-sm shadow-sm transition">
                        ▶ Mulai Baca
                    </a>
                    <button 
                        onclick="startAudiobook('{{ addslashes($featuredBook->title) }}', '{{ addslashes($featuredBook->author) }}', '{{ $featuredBook->cover_url }}', '{{ addslashes($featuredBook->audio_text) }}')" 
                        class="bg-white hover:bg-slate-50 text-slate-700 font-semibold px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-slate-200 shadow-sm transition"
                    >
                        🎧 Dengar Audio
                    </button>
                    <a href="{{ route('lumina.book', $featuredBook->id) }}" class="text-xs text-slate-500 hover:text-slate-900 transition px-2">
                        Detail Lengkap →
                    </a>
                </div>
            </div>

            <div class="shrink-0 hidden md:block">
                <img src="{{ $featuredBook->cover_url }}" alt="{{ $featuredBook->title }}" class="w-44 h-64 rounded-xl object-cover shadow-md border border-slate-200">
            </div>
        </div>

        <!-- Clean Filter Pills -->
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
            <button onclick="filterCategory('all', this)" class="cat-pill px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 text-white transition">
                Semua Koleksi ({{ $allBooks->count() }})
            </button>
            <button onclick="filterCategory('Sejarah', this)" class="cat-pill px-3 py-1.5 rounded-lg text-xs font-medium bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                Sejarah & Tokoh
            </button>
            <button onclick="filterCategory('Sastra', this)" class="cat-pill px-3 py-1.5 rounded-lg text-xs font-medium bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                Sastra & Fiksi
            </button>
            <button onclick="filterCategory('Sains', this)" class="cat-pill px-3 py-1.5 rounded-lg text-xs font-medium bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                Sains & Teknologi
            </button>
            <button onclick="filterCategory('Pengembangan', this)" class="cat-pill px-3 py-1.5 rounded-lg text-xs font-medium bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                Pengembangan Diri
            </button>
            <button onclick="filterCategory('Lingkungan', this)" class="cat-pill px-3 py-1.5 rounded-lg text-xs font-medium bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                Lingkungan
            </button>
        </div>

        <!-- Clean 4-Column Book Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5" id="booksGrid">
            @foreach($allBooks as $book)
            <div 
                class="book-card group cursor-pointer flex flex-col"
                data-title="{{ $book->title }}"
                data-author="{{ $book->author }}"
                data-category="{{ $book->category }}"
            >
                <a href="{{ route('lumina.book', $book->id) }}" class="block">
                    <!-- Clean Cover -->
                    <div class="relative w-full aspect-[3/4] rounded-xl overflow-hidden bg-slate-100 border border-slate-200 group-hover:shadow-md transition">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-102 transition duration-200">
                        <span class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded-md text-[10px] font-bold text-amber-600 shadow-xs">
                            ★ {{ $book->rating }}
                        </span>
                    </div>

                    <!-- Clean Typography Below Cover -->
                    <div class="pt-2.5 space-y-0.5">
                        <span class="text-[10px] font-medium text-blue-600 block">{{ $book->category }}</span>
                        <h4 class="text-sm font-semibold text-slate-900 group-hover:text-blue-600 transition line-clamp-1 leading-snug">
                            {{ $book->title }}
                        </h4>
                        <p class="text-xs text-slate-500 truncate">{{ $book->author }}</p>
                    </div>
                </a>

                <!-- Quick Action Buttons -->
                <div class="flex items-center gap-2 pt-2 mt-auto">
                    <a href="{{ route('lumina.reader', $book->id) }}" class="flex-1 py-1.5 rounded-lg bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 text-xs font-semibold text-center transition">
                        Baca
                    </a>
                    <button 
                        onclick="startAudiobook('{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ $book->cover_url }}', '{{ addslashes($book->audio_text) }}')" 
                        class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs transition"
                        title="Dengar Audio"
                    >
                        🎧
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 2: FITUR AI & WAWANCARA TOKOH          -->
    <!-- ========================================== -->
    <div id="tabContent-ai" class="tab-content hidden space-y-8">
        
        <!-- 1. AI Book Matchmaker Form (Calm & Clean) -->
        <div class="clean-card rounded-2xl p-6 sm:p-8 space-y-6">
            <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                        <span>🎯</span> AI Book Matchmaker
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih kriteria bacaanmu hari ini, biarkan AI menyarankan buku yang paling cocok.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Step 1 -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">1. Suasana Hati (Mood)</label>
                    <div class="space-y-1.5">
                        <button type="button" onclick="selectCleanQuiz('mood', 'santai', this)" class="clean-quiz-btn w-full p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-left text-xs text-slate-700 font-medium transition active bg-blue-50 border-blue-500 text-blue-700">
                            ☕ Santai & Tenang (Habis Ujian)
                        </button>
                        <button type="button" onclick="selectCleanQuiz('mood', 'semangat', this)" class="clean-quiz-btn w-full p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-left text-xs text-slate-700 font-medium transition">
                            🔥 Butuh Motivasi & Inspirasi
                        </button>
                        <button type="button" onclick="selectCleanQuiz('mood', 'fokus', this)" class="clean-quiz-btn w-full p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-left text-xs text-slate-700 font-medium transition">
                            🧠 Fokus Belajar Sains & Logika
                        </button>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">2. Topik Minat</label>
                    <div class="space-y-1.5">
                        <button type="button" onclick="selectCleanQuiz('interest', 'sejarah', this)" class="clean-quiz-btn w-full p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-left text-xs text-slate-700 font-medium transition active bg-blue-50 border-blue-500 text-blue-700">
                            🏛️ Sejarah & Pahlawan Bangsa
                        </button>
                        <button type="button" onclick="selectCleanQuiz('interest', 'sains', this)" class="clean-quiz-btn w-full p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-left text-xs text-slate-700 font-medium transition">
                            🚀 Sains, Kosmos & Teknologi
                        </button>
                        <button type="button" onclick="selectCleanQuiz('interest', 'santai', this)" class="clean-quiz-btn w-full p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-left text-xs text-slate-700 font-medium transition">
                            🌿 Stoisisme & Pengembangan Diri
                        </button>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">3. Target Waktu Baca</label>
                    <div class="space-y-1.5">
                        <button type="button" onclick="selectCleanQuiz('duration', 15, this)" class="clean-quiz-btn w-full p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-left text-xs text-slate-700 font-medium transition">
                            ⏱️ 15 Menit (Bacaan Singkat)
                        </button>
                        <button type="button" onclick="selectCleanQuiz('duration', 30, this)" class="clean-quiz-btn w-full p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-left text-xs text-slate-700 font-medium transition active bg-blue-50 border-blue-500 text-blue-700">
                            ⏱️ 30 Menit (Sedang)
                        </button>
                        <button type="button" onclick="selectCleanQuiz('duration', 45, this)" class="clean-quiz-btn w-full p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-left text-xs text-slate-700 font-medium transition">
                            ⏱️ 45+ Menit (Mendalam)
                        </button>
                    </div>
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button onclick="submitCleanMatchmaker()" id="submitCleanQuizBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl text-xs sm:text-sm shadow-sm transition">
                    ✨ Rekomendasikan Buku
                </button>
            </div>

            <!-- Matchmaker Results Container -->
            <div id="cleanMatchResults" class="hidden pt-4 border-t border-slate-100 space-y-3">
                <div class="p-3 bg-blue-50 border border-blue-100 rounded-xl text-xs text-blue-900">
                    <strong class="font-semibold">💡 Analisis AI:</strong>
                    <span id="cleanAnalysisText" class="ml-1"></span>
                </div>
                <div id="cleanMatchedList" class="grid grid-cols-1 sm:grid-cols-2 gap-3"></div>
            </div>
        </div>

        <!-- 2. Wawancara Tokoh AI (Clean Chat Area) -->
        <div class="clean-card rounded-2xl p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                        <span>🎙️</span> Tanya Tokoh Buku (Roleplay AI)
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Wawancarai tokoh pahlawan atau karakter buku seolah mereka hadir langsung.</p>
                </div>

                <!-- Tokoh Selector Pills -->
                <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar">
                    <button onclick="selectCleanCharacter(1, this)" class="char-pill px-3 py-1 rounded-lg text-xs font-semibold bg-slate-900 text-white transition">
                        Bung Karno
                    </button>
                    <button onclick="selectCleanCharacter(2, this)" class="char-pill px-3 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                        Minke
                    </button>
                    <button onclick="selectCleanCharacter(3, this)" class="char-pill px-3 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                        R.A. Kartini
                    </button>
                    <button onclick="selectCleanCharacter(4, this)" class="char-pill px-3 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                        Marcus Aurelius
                    </button>
                </div>
            </div>

            <!-- Chat Window (Clean Notion/ChatGPT Style) -->
            <div class="border border-slate-200 rounded-2xl overflow-hidden bg-slate-50/50">
                <!-- Active Character Banner -->
                <div class="p-4 bg-white border-b border-slate-200 flex items-center gap-3">
                    <img id="activeCharAvatar" src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=120&q=80" class="w-10 h-10 rounded-xl object-cover border border-slate-200">
                    <div>
                        <h4 id="activeCharName" class="font-bold text-sm text-slate-900">Ir. Soekarno (Bung Karno)</h4>
                        <p id="activeCharRole" class="text-xs text-slate-500">Proklamator & Presiden RI Pertama</p>
                    </div>
                </div>

                <!-- Message History -->
                <div id="cleanChatHistory" class="p-4 space-y-3 max-h-72 overflow-y-auto text-xs sm:text-sm">
                    <div class="flex gap-3 items-start">
                        <div class="bg-white border border-slate-200 rounded-2xl p-3.5 max-w-[85%] text-slate-800 shadow-xs">
                            <p id="activeCharGreeting">Merdeka! Wahai anak mudaku pembawa panji masa depan bangsa! Ada kegelisahan apa di dadamu tentang negerimu yang indah ini? Tanyakanlah, mari kita berdiskusi!</p>
                        </div>
                    </div>
                </div>

                <!-- Input Box -->
                <div class="p-3 bg-white border-t border-slate-200 flex items-center gap-2">
                    <input 
                        type="text" 
                        id="cleanChatInput" 
                        placeholder="Ketik pertanyaan untuk tokoh ini..." 
                        class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-500"
                        onkeydown="if(event.key === 'Enter') sendCleanChatMessage()"
                    >
                    <button onclick="sendCleanChatMessage()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-xl text-xs sm:text-sm transition">
                        Kirim
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- TAB 3: FRAKSI & PERINGKAT MEMBACA          -->
    <!-- ========================================== -->
    <div id="tabContent-fraksi" class="tab-content hidden space-y-8">
        
        <!-- 4 Houses Clean Cards -->
        <div>
            <div class="mb-4">
                <h3 class="font-bold text-lg text-slate-900">🏆 Piala Membaca: 4 Fraksi Sekolah</h3>
                <p class="text-xs text-slate-500">Setiap menit membaca seluruh siswa menyumbang poin untuk kemenangan fraksinya.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($houses as $hIndex => $h)
                <div class="clean-card rounded-2xl p-5 space-y-3 {{ $h->name === $student['house'] ? 'border-blue-400 bg-blue-50/20' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-3xl">{{ $h->emblem }}</span>
                            <div>
                                <h4 class="font-bold text-sm text-slate-900">{{ $h->name }}</h4>
                                <span class="text-[11px] text-slate-500">{{ $h->member_count }} Pelajar</span>
                            </div>
                        </div>
                        <span class="font-bold text-xs text-slate-400">#{{ $hIndex + 1 }}</span>
                    </div>

                    <p class="text-xs text-slate-600 italic">"{{ $h->motto }}"</p>

                    <div class="pt-2 border-t border-slate-100">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-500">Poin:</span>
                            <strong class="text-slate-900 font-bold">{{ number_format($h->total_points, 0, ',', '.') }} Poin</strong>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            @php $p = min(100, round(($h->total_points / 4000) * 100)); @endphp
                            <div class="h-full rounded-full bg-blue-600" style="width: {{ $p }}%;"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Student Leaderboard Table (Clean & Simple) -->
        <div class="clean-card rounded-2xl overflow-hidden p-6 space-y-4">
            <div>
                <h4 class="font-bold text-base text-slate-900">Peringkat 5 Teratas Siswa Bulan Ini</h4>
                <p class="text-xs text-slate-500">Dihitung berdasarkan total menit membaca aktif di perpustakaan.</p>
            </div>

            <div class="divide-y divide-slate-100 text-xs sm:text-sm">
                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-base">🥇</span>
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Siti" class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200">
                        <div>
                            <span class="font-semibold text-slate-900 block">Siti Nurhaliza</span>
                            <span class="text-[11px] text-slate-500">12 IPS 1 • 🐉 Komodo Wira</span>
                        </div>
                    </div>
                    <span class="font-semibold text-blue-600">1.840 Menit</span>
                </div>

                <div class="py-3 flex items-center justify-between bg-blue-50/50 -mx-6 px-6">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-base">🥈</span>
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Rayhan" class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200">
                        <div>
                            <span class="font-semibold text-slate-900 block">Rayhan Alfarizi (Kamu)</span>
                            <span class="text-[11px] text-slate-500">11 IPA 2 • 🦅 Garuda Cendekia</span>
                        </div>
                    </div>
                    <span class="font-semibold text-blue-600">1.045 Menit</span>
                </div>

                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-base">🥉</span>
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Aditya" class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200">
                        <div>
                            <span class="font-semibold text-slate-900 block">Aditya Pratama</span>
                            <span class="text-[11px] text-slate-500">10 MIPA 3 • 🌊 Elang Samudra</span>
                        </div>
                    </div>
                    <span class="font-semibold text-blue-600">980 Menit</span>
                </div>
            </div>

            <div class="pt-2 text-center">
                <a href="{{ route('lumina.gamification') }}" class="text-xs text-blue-600 font-semibold hover:underline">
                    Buka Halaman Gamifikasi & Misi Mingguan Lengkap →
                </a>
            </div>
        </div>

    </div>

</div>

<!-- Tab & Filter Interactivity Scripts -->
<script>
    // Tab switcher
    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('bg-slate-900', 'text-white', 'shadow-sm');
            b.classList.add('text-slate-600', 'hover:bg-slate-100');
        });

        const targetContent = document.getElementById('tabContent-' + tabName);
        const targetBtn = document.getElementById('tabBtn-' + tabName);
        if (targetContent && targetBtn) {
            targetContent.classList.remove('hidden');
            targetBtn.classList.remove('text-slate-600', 'hover:bg-slate-100');
            targetBtn.classList.add('bg-slate-900', 'text-white', 'shadow-sm');
        }
    }

    // Check URL parameter for tab
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('tab') === 'ai') {
        switchTab('ai');
    } else if (urlParams.get('tab') === 'fraksi') {
        switchTab('fraksi');
    }

    // Category filter
    function filterCategory(cat, btn) {
        document.querySelectorAll('.cat-pill').forEach(b => {
            b.classList.remove('bg-slate-900', 'text-white');
            b.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        });
        btn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        btn.classList.add('bg-slate-900', 'text-white');

        document.querySelectorAll('.book-card').forEach(card => {
            const cardCat = card.getAttribute('data-category') || '';
            if (cat === 'all' || cardCat.includes(cat)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // AI Matchmaker
    let cleanQuiz = { mood: 'santai', interest: 'sejarah', duration: 30 };
    function selectCleanQuiz(type, val, btn) {
        cleanQuiz[type] = val;
        btn.parentElement.querySelectorAll('button').forEach(b => {
            b.classList.remove('bg-blue-50', 'border-blue-500', 'text-blue-700');
        });
        btn.classList.add('bg-blue-50', 'border-blue-500', 'text-blue-700');
    }

    async function submitCleanMatchmaker() {
        const btn = document.getElementById('submitCleanQuizBtn');
        btn.disabled = true;
        btn.innerText = 'Mencari...';

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
                card.className = 'p-3 rounded-xl border border-slate-200 bg-white flex items-center justify-between gap-3';
                card.innerHTML = `
                    <div class="flex items-center gap-3 min-w-0">
                        <img src="${b.cover_url}" class="w-10 h-14 rounded-lg object-cover shrink-0">
                        <div class="min-w-0">
                            <span class="text-[10px] text-blue-600 font-bold">${b.match_score}% Cocok</span>
                            <h5 class="text-xs font-bold text-slate-900 truncate">${b.title}</h5>
                            <p class="text-[11px] text-slate-500 truncate">${b.author}</p>
                        </div>
                    </div>
                    <a href="/buku/${b.id}" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold shrink-0">Buka</a>
                `;
                list.appendChild(card);
            });
        } catch(e) {
            console.error(e);
            alert('Gagal mengambil rekomendasi');
        } finally {
            btn.disabled = false;
            btn.innerText = '✨ Rekomendasikan Buku';
        }
    }

    // Roleplay AI Chat
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
            b.classList.remove('bg-slate-900', 'text-white');
            b.classList.add('bg-slate-100', 'text-slate-700');
        });
        btn.classList.remove('bg-slate-100', 'text-slate-700');
        btn.classList.add('bg-slate-900', 'text-white');

        const c = charactersList[id];
        document.getElementById('activeCharAvatar').src = c.avatar;
        document.getElementById('activeCharName').textContent = c.name;
        document.getElementById('activeCharRole').textContent = c.role;
        document.getElementById('activeCharGreeting').textContent = c.greeting;
        document.getElementById('cleanChatHistory').innerHTML = `
            <div class="flex gap-3 items-start">
                <div class="bg-white border border-slate-200 rounded-2xl p-3.5 max-w-[85%] text-slate-800 shadow-xs">
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
        userDiv.innerHTML = `<div class="bg-blue-600 text-white rounded-2xl p-3 max-w-[85%]">${text}</div>`;
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
            botDiv.innerHTML = `<div class="bg-white border border-slate-200 text-slate-800 rounded-2xl p-3 max-w-[85%] leading-relaxed">${data.reply}</div>`;
            history.appendChild(botDiv);
            history.scrollTop = history.scrollHeight;
        } catch(e) {
            console.error(e);
            alert('Gagal mengirim pesan');
        }
    }
</script>
@endsection
