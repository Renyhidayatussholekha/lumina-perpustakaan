@extends('layouts.lumina')

@section('title', $book->title . ' - Lumina')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 py-4">

    <!-- Breadcrumb & Back -->
    <div>
        <a href="{{ route('lumina.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-pink-300/80 hover:text-pink-200 transition">
            ← Kembali ke Rak Buku
        </a>
    </div>

    <!-- Main Book Header Card -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-8 border border-pink-500/20 relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-pink-500/15 rounded-full blur-3xl pointer-events-none" aria-hidden="true" role="presentation"></div>

        <!-- Cover with Lazy Loading -->
        <div class="relative w-44 sm:w-52 aspect-[3/4] rounded-2xl overflow-hidden bg-plum-950 border border-pink-400/30 shrink-0 cover-shadow">
            <img 
                src="{{ $book->cover_url }}" 
                alt="{{ $book->title }}" 
                class="w-full h-full object-cover"
                loading="lazy"
                decoding="async"
            >
            <div class="absolute top-2.5 right-2.5 bg-plum-950/85 backdrop-blur px-2.5 py-1 rounded-full text-[10px] font-bold text-amber-400 border border-amber-400/30">
                ★ {{ $book->rating }}
            </div>
        </div>

        <!-- Info -->
        <div class="flex-1 space-y-4 text-left">
            <div>
                <a href="{{ route('lumina.index', ['kategori' => $book->category]) }}" class="px-2.5 py-0.5 rounded-full bg-pink-500/20 text-pink-300 hover:bg-pink-500/30 border border-pink-500/30 text-[10px] font-mono font-bold uppercase tracking-wider inline-block transition">
                    🌸 {{ $book->category }}
                </a>
                <h1 class="font-display font-black text-2xl sm:text-3xl text-white mt-2 leading-tight">{{ $book->title }}</h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1">Karya <strong class="text-pink-300">{{ $book->author }}</strong></p>
                
                <div class="flex items-center gap-3 text-xs text-slate-400 mt-2">
                    <span class="text-amber-400 font-bold">★ {{ $book->rating }}</span>
                    <span>•</span>
                    <span>⏱️ Estimasi {{ $book->reading_time_minutes }} Menit</span>
                    <span>•</span>
                    <span>Target: {{ $book->grade_level }}</span>
                </div>
            </div>

            <!-- 3 AI Bite-sized Summary Points with Live AI Re-Generation -->
            <div class="p-4 rounded-2xl bg-plum-950/70 border border-pink-500/20 space-y-3 text-xs relative" id="aiSummaryBox">
                <div class="flex items-center justify-between border-b border-pink-500/15 pb-2">
                    <span class="font-display font-bold text-pink-300 flex items-center gap-1.5 text-xs">
                        <span>💡</span> 3 Inti Pokok Buku (Rangkuman AI Lumina):
                    </span>
                    <button 
                        type="button" 
                        onclick="generateFreshAiSummary({{ $book->id }})" 
                        id="genAiBtn" 
                        class="text-[10px] font-bold text-pink-300 hover:text-white bg-pink-500/20 hover:bg-pink-500/35 px-2.5 py-1 rounded-xl border border-pink-500/30 transition flex items-center gap-1 shadow-sm"
                        title="Minta AI meracik perspektif baru dari buku ini"
                    >
                        <span>✨</span>
                        <span id="genAiBtnText">Analisis AI Baru</span>
                    </button>
                </div>
                <ul class="text-xs text-slate-300 space-y-2 pl-1" id="aiSummaryList">
                    <li class="flex items-start gap-2">
                        <span class="text-pink-400 font-bold">•</span>
                        <span id="summaryPoint1">{{ $book->ai_summary_1 }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-pink-400 font-bold">•</span>
                        <span id="summaryPoint2">{{ $book->ai_summary_2 }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-pink-400 font-bold">•</span>
                        <span id="summaryPoint3">{{ $book->ai_summary_3 }}</span>
                    </li>
                </ul>
                <div id="aiSourceBadge" class="text-[10px] text-pink-400/70 italic pt-1 border-t border-white/5">
                    Model: Lumina Neural Library AI v2.4 (Terhubung)
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <a href="{{ route('lumina.reader', $book->id) }}" class="bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 hover:from-pink-400 hover:to-rose-400 text-white font-extrabold px-6 py-3 rounded-xl text-xs sm:text-sm shadow-lg shadow-pink-500/30 flex items-center gap-2 transition hover:scale-105 active:scale-95">
                    <span>📖</span>
                    <span>Buka Ruang Baca (Mode Fokus)</span>
                </a>

                <button 
                    onclick="startAudiobook('{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ $book->cover_url }}', '{{ addslashes($book->audio_text) }}')"
                    class="bg-white/10 hover:bg-white/15 text-pink-200 hover:text-white font-bold px-5 py-3 rounded-xl text-xs sm:text-sm border border-pink-400/20 flex items-center gap-2 transition hover:scale-105 active:scale-95"
                >
                    <span>🎧</span>
                    <span>Putar Audiobook (TTS)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Synopsis Card -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 space-y-3 border border-pink-500/20">
        <h3 class="font-display font-bold text-base text-white">Sinopsis Buku</h3>
        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
            {{ $book->synopsis }}
        </p>
    </div>

    <!-- Klub Buku Virtual (Forum Diskusi Siswa) -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 space-y-6 border border-pink-500/20">
        <div class="flex items-center justify-between border-b border-pink-500/15 pb-3">
            <div>
                <h3 class="font-display font-bold text-base text-white flex items-center gap-2">
                    <span>💬</span> Klub Buku Siswa
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Bagikan analisismu atau tanggapi teman sekelas. Komentarmu menyumbang <strong class="text-pink-300">+10 poin</strong> untuk fraksimu!</p>
            </div>
        </div>

        <!-- AI Moderator Question Box -->
        <div class="p-4 rounded-2xl bg-gradient-to-r from-pink-950/40 to-plum-900 border border-pink-500/30 flex items-start gap-3">
            <span class="text-2xl">🌸</span>
            <div class="text-xs">
                <strong class="text-pink-300 block font-bold">Pertanyaan Pemantik dari AI Moderator:</strong>
                <p class="text-slate-200 mt-0.5 italic">"Menurut teman-teman, apa keputusan terpenting atau pelajaran hidup yang paling membekas dari buku ini? Bagikan pendapatmu!"</p>
            </div>
        </div>

        <!-- Submit Comment -->
        <div class="space-y-2">
            <textarea 
                id="discussionCommentInput" 
                rows="2" 
                placeholder="Tuliskan tanggapanmu..." 
                class="w-full bg-plum-950 border border-pink-500/20 rounded-2xl p-3.5 text-xs sm:text-sm text-white placeholder-pink-300/40 focus:outline-none focus:border-pink-400"
            ></textarea>
            <div class="flex justify-end">
                <button 
                    onclick="submitBookDiscussion({{ $book->id }})" 
                    id="submitDiscussionBtn"
                    class="bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-400 hover:to-rose-400 text-white font-extrabold px-5 py-2.5 rounded-xl text-xs flex items-center gap-1.5 transition active:scale-95 shadow-md shadow-pink-500/30"
                >
                    <span>Kirim Tanggapan (+10 Poin)</span>
                    <span>✍️</span>
                </button>
            </div>
        </div>

        <!-- Comments List -->
        <div id="discussionsThread" class="space-y-3 pt-2">
            @foreach($book->discussions as $disc)
            <div class="p-4 rounded-2xl border border-pink-500/15 bg-plum-900/60 space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <img 
                            src="{{ $disc->user_avatar }}" 
                            alt="{{ $disc->user_name }}" 
                            class="w-7 h-7 rounded-full bg-plum-800 border border-pink-400/40"
                            loading="lazy"
                            decoding="async"
                        >
                        <span class="font-bold text-xs text-white">{{ $disc->user_name }}</span>
                        <span class="text-[10px] text-pink-300 font-mono">• {{ $disc->user_house }}</span>
                    </div>
                    <span class="text-[10px] text-slate-500">{{ $disc->created_at ? $disc->created_at->diffForHumans() : 'Baru saja' }}</span>
                </div>
                <p class="text-xs text-slate-300 pl-9 leading-relaxed">
                    {{ $disc->comment }}
                </p>
            </div>
            @endforeach
        </div>
    </div>

</div>

<script>
    // Real-time Dynamic AI Summarization
    async function generateFreshAiSummary(bookId) {
        const btn = document.getElementById('genAiBtn');
        const textSpan = document.getElementById('genAiBtnText');
        btn.disabled = true;
        textSpan.textContent = 'Menganalisis AI...';

        try {
            const res = await fetch('{{ route("lumina.api.summarize") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ book_id: bookId })
            });
            const data = await res.json();

            if (data.status === 'success') {
                document.getElementById('summaryPoint1').textContent = data.summary_1;
                document.getElementById('summaryPoint2').textContent = data.summary_2;
                document.getElementById('summaryPoint3').textContent = data.summary_3;
                
                const badge = document.getElementById('aiSourceBadge');
                if (badge) {
                    badge.textContent = 'Model: ' + data.source + ' (Baru saja diperbarui ✨)';
                    badge.classList.add('text-pink-300', 'font-bold');
                }

                showToast('AI Berhasil!', 'Rangkuman baru berhasil diracik oleh AI');
            }
        } catch (e) {
            console.error(e);
            showToast('Info AI', 'Menggunakan analisis kontekstual Lumina');
        } finally {
            btn.disabled = false;
            textSpan.textContent = 'Analisis AI Baru';
        }
    }

    async function submitBookDiscussion(bookId) {
        const input = document.getElementById('discussionCommentInput');
        const text = input.value.trim();
        if (!text) return;

        const btn = document.getElementById('submitDiscussionBtn');
        btn.disabled = true;

        try {
            const res = await fetch('{{ route("lumina.api.discussion") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ book_id: bookId, comment: text })
            });
            const data = await res.json();

            const thread = document.getElementById('discussionsThread');
            const card = document.createElement('div');
            card.className = 'p-4 rounded-2xl border border-pink-500/30 bg-plum-900 space-y-2';
            card.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <img src="${data.discussion.user_avatar}" alt="${data.discussion.user_name}" class="w-7 h-7 rounded-full bg-plum-800 border border-pink-400" loading="lazy" decoding="async">
                        <span class="font-bold text-xs text-white">${data.discussion.user_name}</span>
                        <span class="text-[10px] text-pink-300 font-mono">• ${data.discussion.user_house}</span>
                    </div>
                    <span class="text-[10px] text-slate-500">Baru saja</span>
                </div>
                <p class="text-xs text-slate-300 pl-9 leading-relaxed">${data.discussion.comment}</p>
            `;
            thread.prepend(card);
            input.value = '';
            showToast('Terkirim!', '+10 Poin untuk ' + data.house_name);
        } catch(e) {
            console.error(e);
            alert('Gagal mengirim tanggapan');
        } finally {
            btn.disabled = false;
        }
    }
</script>
@endsection
