@extends('layouts.lumina')

@section('title', $book->title . ' - Lumina')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 py-4">

    <!-- Breadcrumb & Back -->
    <div>
        <a href="{{ route('lumina.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-500 hover:text-slate-900 transition">
            ← Kembali ke Katalog
        </a>
    </div>

    <!-- Main Book Header Card -->
    <div class="clean-card rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row items-start gap-6 sm:gap-8">
        <!-- Cover -->
        <div class="w-40 sm:w-48 aspect-[3/4] rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 shadow-sm mx-auto sm:mx-0">
            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
        </div>

        <!-- Info -->
        <div class="flex-1 space-y-4">
            <div>
                <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">{{ $book->category }}</span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1 leading-tight">{{ $book->title }}</h1>
                <p class="text-sm text-slate-600 mt-1">Karya <strong class="text-slate-900">{{ $book->author }}</strong></p>
                
                <div class="flex items-center gap-3 text-xs text-slate-500 mt-2">
                    <span class="text-amber-600 font-bold">★ {{ $book->rating }}</span>
                    <span>•</span>
                    <span>⏱️ Estimasi {{ $book->reading_time_minutes }} Menit</span>
                    <span>•</span>
                    <span>Target: {{ $book->grade_level }}</span>
                </div>
            </div>

            <!-- 3 AI Bite-sized Summary Points -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-2">
                <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                    <span>💡</span> 3 Inti Pokok Buku (Rangkuman AI Lumina):
                </span>
                <ul class="text-xs text-slate-600 space-y-1.5 pl-1">
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 font-bold mt-0.5">•</span>
                        <span>{{ $book->ai_summary_1 }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 font-bold mt-0.5">•</span>
                        <span>{{ $book->ai_summary_2 }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 font-bold mt-0.5">•</span>
                        <span>{{ $book->ai_summary_3 }}</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-3 pt-1">
                <a href="{{ route('lumina.reader', $book->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-xs sm:text-sm shadow-sm transition">
                    📖 Buka Ruang Baca (Mode Fokus)
                </a>

                <button 
                    onclick="startAudiobook('{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ $book->cover_url }}', '{{ addslashes($book->audio_text) }}')"
                    class="bg-white hover:bg-slate-50 text-slate-700 font-semibold px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-slate-200 shadow-sm transition"
                >
                    🎧 Putar Audiobook (TTS)
                </button>
            </div>
        </div>
    </div>

    <!-- Synopsis Card -->
    <div class="clean-card rounded-2xl p-6 sm:p-8 space-y-3">
        <h3 class="font-bold text-base text-slate-900">Sinopsis Lengkap</h3>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
            {{ $book->synopsis }}
        </p>
    </div>

    <!-- Klub Buku Virtual (Forum Diskusi Siswa) -->
    <div class="clean-card rounded-2xl p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h3 class="font-bold text-base text-slate-900 flex items-center gap-2">
                    <span>💬</span> Klub Buku Siswa
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Bagikan analisismu atau tanggapi teman sekelas. Komentarmu menyumbang poin ke fraksimu.</p>
            </div>
        </div>

        <!-- AI Moderator Question Box -->
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
            <span class="text-xl">🤖</span>
            <div class="text-xs">
                <strong class="text-blue-900 block font-semibold">Pertanyaan Pemantik dari AI Moderator:</strong>
                <p class="text-blue-800 mt-0.5 italic">"Menurut teman-teman, apa keputusan terpenting atau pelajaran hidup yang paling membekas dari buku ini? Bagikan pendapatmu!"</p>
            </div>
        </div>

        <!-- Submit Comment -->
        <div class="space-y-2">
            <textarea 
                id="discussionCommentInput" 
                rows="2" 
                placeholder="Tuliskan tanggapanmu..." 
                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-500"
            ></textarea>
            <div class="flex justify-end">
                <button 
                    onclick="submitBookDiscussion({{ $book->id }})" 
                    id="submitDiscussionBtn"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-xl text-xs transition"
                >
                    Kirim Tanggapan (+10 Poin)
                </button>
            </div>
        </div>

        <!-- Comments List -->
        <div id="discussionsThread" class="space-y-3 pt-2">
            @foreach($book->discussions as $disc)
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/50 space-y-1.5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="{{ $disc->user_avatar }}" class="w-6 h-6 rounded-full bg-slate-200">
                        <span class="font-semibold text-xs text-slate-900">{{ $disc->user_name }}</span>
                        <span class="text-[10px] text-slate-500">• {{ $disc->user_house }}</span>
                    </div>
                    <span class="text-[10px] text-slate-400">{{ $disc->created_at ? $disc->created_at->diffForHumans() : 'Baru saja' }}</span>
                </div>
                <p class="text-xs text-slate-700 pl-8 leading-relaxed">
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
            card.className = 'p-3.5 rounded-xl border border-slate-200 bg-white space-y-1.5';
            card.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="${data.discussion.user_avatar}" class="w-6 h-6 rounded-full bg-slate-200">
                        <span class="font-semibold text-xs text-slate-900">${data.discussion.user_name}</span>
                        <span class="text-[10px] text-slate-500">• ${data.discussion.user_house}</span>
                    </div>
                    <span class="text-[10px] text-slate-400">Baru saja</span>
                </div>
                <p class="text-xs text-slate-700 pl-8 leading-relaxed">${data.discussion.comment}</p>
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
