@extends('layouts.lumina')

@section('title', $book->title . ' - Detail & Klub Buku Lumina')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ route('lumina.index') }}" class="hover:text-cyan-400 transition flex items-center gap-1">
            <span>‹</span> Kembali ke Katalog
        </a>
        <span>/</span>
        <span class="text-slate-500">{{ $book->category }}</span>
        <span>/</span>
        <span class="text-slate-200 font-bold truncate max-w-xs">{{ $book->title }}</span>
    </div>

    <!-- ========================================== -->
    <!-- 1. BOOK DETAIL HERO & BITE-SIZED AI INFO   -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Left: Book Cover & Quick Meta -->
        <div class="lg:col-span-4 flex flex-col items-center sm:items-start space-y-4">
            <div class="relative w-64 sm:w-72 h-96 sm:h-[420px] rounded-2xl overflow-hidden glass-panel border-2 border-slate-700/80 shadow-2xl">
                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                <div class="absolute top-3 left-3 bg-navy-950/80 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-amber-400 border border-amber-400/30">
                    ★ {{ $book->rating }}
                </div>
                <div class="absolute top-3 right-3 bg-cyan-950/80 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-cyan-300 border border-cyan-500/30">
                    ⏱️ {{ $book->reading_time_minutes }} Menit
                </div>
            </div>

            <!-- Quick Meta Card -->
            <div class="w-64 sm:w-72 p-4 rounded-2xl glass-panel border border-slate-800 space-y-2 text-xs">
                <div class="flex justify-between py-1 border-b border-slate-800">
                    <span class="text-slate-400">Kategori</span>
                    <span class="font-bold text-slate-200">{{ $book->category }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800">
                    <span class="text-slate-400">Target Siswa</span>
                    <span class="font-bold text-slate-200">{{ $book->grade_level }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800">
                    <span class="text-slate-400">Total Pembaca</span>
                    <span class="font-bold text-cyan-400">{{ $book->total_readers }}+ Pelajar</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Format</span>
                    <span class="font-bold text-emerald-400">Digital E-Book + TTS</span>
                </div>
            </div>
        </div>

        <!-- Right: Bite-Sized Info, Synopsis & CTAs -->
        <div class="lg:col-span-8 space-y-6">
            <div>
                <span class="px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 text-xs font-mono font-bold uppercase tracking-wider">
                    {{ $book->trending_label ?? 'Koleksi Perpustakaan Sekolah' }}
                </span>
                <h1 class="font-display font-black text-3xl sm:text-4xl text-white mt-3 leading-tight">
                    {{ $book->title }}
                </h1>
                <p class="text-sm sm:text-base text-slate-300 mt-1">
                    Karya <strong class="text-cyan-400">{{ $book->author }}</strong>
                </p>
            </div>

            <!-- Bite-Sized Info: 3 Poin AI Summary (Feature Requirement) -->
            <div class="p-5 rounded-2xl glass-panel border border-cyan-500/40 bg-gradient-to-br from-cyan-950/20 via-navy-900/60 to-navy-950 relative overflow-hidden">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xl">🤖</span>
                    <h3 class="font-display font-bold text-sm text-cyan-300 uppercase tracking-wider">Bite-Sized Info: 3 Rangkuman Utama AI Lumina</h3>
                </div>
                <div class="grid grid-cols-1 gap-3">
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-navy-900/80 border border-slate-800">
                        <span class="w-6 h-6 rounded-full bg-cyan-500/20 text-cyan-300 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">1</span>
                        <p class="text-xs sm:text-sm text-slate-200 leading-relaxed">{{ $book->ai_summary_1 }}</p>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-navy-900/80 border border-slate-800">
                        <span class="w-6 h-6 rounded-full bg-cyan-500/20 text-cyan-300 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">2</span>
                        <p class="text-xs sm:text-sm text-slate-200 leading-relaxed">{{ $book->ai_summary_2 }}</p>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-navy-900/80 border border-slate-800">
                        <span class="w-6 h-6 rounded-full bg-cyan-500/20 text-cyan-300 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">3</span>
                        <p class="text-xs sm:text-sm text-slate-200 leading-relaxed">{{ $book->ai_summary_3 }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Bar -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('lumina.reader', $book->id) }}" class="bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-black px-6 py-3 rounded-xl text-sm flex items-center gap-2 shadow-glow-cyan transition hover:scale-105 active:scale-95">
                    <span>📖</span>
                    <span>Buka Ruang Baca (Mode Fokus)</span>
                </a>

                <button 
                    onclick="startAudiobook('{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ $book->cover_url }}', '{{ addslashes($book->audio_text) }}')" 
                    class="bg-navy-800 hover:bg-slate-800 text-white font-bold px-5 py-3 rounded-xl text-sm border border-slate-700 hover:border-cyan-400 flex items-center gap-2 transition hover:scale-105 active:scale-95"
                >
                    <span>🎧</span>
                    <span>Dengar Audiobook (TTS)</span>
                </button>

                @if($book->characters->isNotEmpty())
                <button 
                    onclick="openRoleplayModal({{ $book->characters->first()->id }})" 
                    class="bg-lumina-purple/20 hover:bg-lumina-purple/30 text-purple-200 font-bold px-5 py-3 rounded-xl text-sm border border-purple-500/40 flex items-center gap-2 transition hover:scale-105 active:scale-95 shadow-glow-purple"
                >
                    <span>🎙️</span>
                    <span>Tanya Tokoh: {{ $book->characters->first()->name }}</span>
                </button>
                @endif
            </div>

            <!-- Full Synopsis -->
            <div class="space-y-2">
                <h3 class="font-display font-bold text-base text-white">Sinopsis Buku</h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    {{ $book->synopsis }}
                </p>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 2. AUTO-AUDIOBOOK DEDICATED TTS PLAYER BOX -->
    <!-- ========================================== -->
    <div class="p-6 rounded-3xl glass-panel border border-cyan-500/30 bg-navy-900/90 relative overflow-hidden">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-cyan-500/20 border border-cyan-500/40 flex items-center justify-center text-2xl shadow-glow-cyan">
                    🎧
                </div>
                <div>
                    <h3 class="font-display font-bold text-lg text-white">Auto-Audiobook Ekstraktor</h3>
                    <p class="text-xs text-slate-400">Mendengarkan kutipan buku dengan sintesis suara Bahasa Indonesia saat di perjalanan</p>
                </div>
            </div>

            <button 
                onclick="startAudiobook('{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ $book->cover_url }}', '{{ addslashes($book->audio_text) }}')"
                class="px-5 py-2.5 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-bold text-xs flex items-center gap-2 shadow-glow-cyan transition"
            >
                <span>▶ Putar Audiobook Sekarang</span>
            </button>
        </div>

        <div class="mt-4 p-4 rounded-xl bg-navy-950/60 border border-slate-800 text-xs sm:text-sm text-slate-300 italic leading-relaxed">
            "{{ $book->audio_text }}"
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 3. KLUB BUKU VIRTUAL (FORUM DISKUSI SISWA) -->
    <!-- ========================================== -->
    <div class="space-y-6 pt-6 border-t border-slate-800">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xl">💬</span>
                    <h3 class="font-display font-extrabold text-2xl text-white">Klub Buku Virtual</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                        {{ $book->discussions->count() }} Diskusi Siswa
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-1">
                    Diskusikan gagasan, nilai karakter, dan wawasan buku ini bersama teman-teman sekolah. Komentarmu akan menyumbang <strong>+10 poin</strong> untuk fraksimu!
                </p>
            </div>
        </div>

        <!-- Sticky AI Moderator Prompt (Feature Requirement) -->
        <div class="p-5 rounded-2xl glass-panel border border-purple-500/40 bg-gradient-to-r from-purple-950/30 via-navy-900 to-navy-950 flex items-start gap-4">
            <img src="https://api.dicebear.com/7.x/bottts/svg?seed=LuminaBot" alt="AI Moderator" class="w-12 h-12 rounded-xl bg-purple-500/20 border border-purple-400/40 shrink-0 p-1">
            <div class="space-y-1 min-w-0">
                <div class="flex items-center gap-2">
                    <h5 class="font-display font-bold text-sm text-purple-300">Pertanyaan Pemantik dari AI Moderator Lumina</h5>
                    <span class="px-2 py-0.2 rounded bg-lumina-purple/30 text-purple-200 text-[9px] font-mono">Official Prompt</span>
                </div>
                <p class="text-xs sm:text-sm text-slate-200 leading-relaxed italic">
                    "Menurut teman-teman, apa keputusan terberat atau pelajaran hidup terpenting yang bisa diambil dari buku ini untuk kehidupan siswa masa kini? Yuk bagikan argumen terbaikmu!"
                </p>
            </div>
        </div>

        <!-- Add Comment Form -->
        <div class="p-4 rounded-2xl glass-panel border border-slate-800 bg-navy-900/90 space-y-3">
            <div class="flex items-center gap-3">
                <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="w-8 h-8 rounded-full bg-navy-800 border border-cyan-400">
                <span class="text-xs font-bold text-slate-200">{{ $student['name'] }} ({{ $student['house'] }})</span>
                <span class="text-[10px] text-cyan-400 font-mono">+10 Poin Fraksi saat kirim</span>
            </div>
            <textarea 
                id="discussionCommentInput" 
                rows="3" 
                placeholder="Tulis analisismu atau tanggapi pertanyaan pemantik AI di atas..." 
                class="w-full bg-navy-950 border border-slate-700 rounded-xl p-3 text-xs sm:text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition"
            ></textarea>
            <div class="flex justify-end">
                <button 
                    onclick="submitBookDiscussion({{ $book->id }})" 
                    id="submitDiscussionBtn"
                    class="bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-bold px-5 py-2.5 rounded-xl text-xs flex items-center gap-2 shadow-glow-cyan transition active:scale-95"
                >
                    <span>Kirim Tanggapan</span>
                    <span>✍️</span>
                </button>
            </div>
        </div>

        <!-- Discussions Thread List -->
        <div id="discussionsThread" class="space-y-4">
            @foreach($book->discussions as $disc)
            <div class="p-4 rounded-2xl glass-panel border {{ $disc->is_ai_prompt ? 'border-purple-500/40 bg-purple-950/20' : 'border-slate-800 bg-navy-900/80' }} space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ $disc->user_avatar }}" alt="{{ $disc->user_name }}" class="w-9 h-9 rounded-full bg-navy-800 border border-slate-700">
                        <div>
                            <div class="flex items-center gap-2">
                                <h6 class="font-bold text-xs sm:text-sm text-white">{{ $disc->user_name }}</h6>
                                <span class="px-2 py-0.2 rounded-full text-[10px] font-bold {{ $disc->is_ai_prompt ? 'bg-purple-500/20 text-purple-300' : 'bg-slate-800 text-cyan-300' }}">
                                    {{ $disc->user_house }}
                                </span>
                            </div>
                            <span class="text-[10px] text-slate-400">{{ $disc->created_at ? $disc->created_at->diffForHumans() : 'Beberapa waktu lalu' }}</span>
                        </div>
                    </div>
                    <button class="flex items-center gap-1.5 text-xs text-slate-400 hover:text-rose-400 transition">
                        <span>❤️</span>
                        <span class="font-mono text-[11px]">{{ $disc->likes_count }}</span>
                    </button>
                </div>
                <p class="text-xs sm:text-sm text-slate-200 leading-relaxed pl-12">
                    {{ $disc->comment }}
                </p>
            </div>
            @endforeach
        </div>
    </div>

</div>

<script>
    async function submitBookDiscussion(bookId) {
        const input = document.getElementById('discussionCommentInput');
        const text = input.value.trim();
        if (!text) {
            alert('Tuliskan komentar terlebih dahulu');
            return;
        }

        const btn = document.getElementById('submitDiscussionBtn');
        btn.disabled = true;
        btn.innerText = 'Mengirim...';

        try {
            const response = await fetch('{{ route("lumina.api.discussion") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    book_id: bookId,
                    comment: text
                })
            });
            const data = await response.json();

            // Append to discussion thread
            const thread = document.getElementById('discussionsThread');
            const card = document.createElement('div');
            card.className = 'p-4 rounded-2xl glass-panel border border-cyan-500/40 bg-navy-900/90 space-y-2';
            card.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="${data.discussion.user_avatar}" class="w-9 h-9 rounded-full bg-navy-800 border border-cyan-400">
                        <div>
                            <div class="flex items-center gap-2">
                                <h6 class="font-bold text-xs sm:text-sm text-white">${data.discussion.user_name}</h6>
                                <span class="px-2 py-0.2 rounded-full text-[10px] font-bold bg-cyan-500/20 text-cyan-300">
                                    ${data.discussion.user_house}
                                </span>
                            </div>
                            <span class="text-[10px] text-slate-400">${data.discussion.created_at}</span>
                        </div>
                    </div>
                    <span class="text-xs text-rose-400 font-mono">❤️ 1</span>
                </div>
                <p class="text-xs sm:text-sm text-slate-200 leading-relaxed pl-12">
                    ${data.discussion.comment}
                </p>
            `;
            thread.prepend(card);
            input.value = '';

            showToast('🎉 Komentar Terkirim!', '+10 Poin ditambahkan untuk ' + data.house_name + '!', 'cyan');
        } catch (err) {
            console.error(err);
            alert('Gagal mengirim komentar');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span>Kirim Tanggapan</span> <span>✍️</span>';
        }
    }
</script>
@endsection
