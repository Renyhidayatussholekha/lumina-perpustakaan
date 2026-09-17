@extends('layouts.lumina')

@section('title', 'Fraksi & Prestasi - Lumina')

@section('content')
<div class="max-w-5xl mx-auto space-y-10 py-4">

    <!-- Header & Breadcrumb -->
    <div>
        <a href="{{ route('lumina.index') }}" class="text-xs font-bold text-pink-300/80 hover:text-pink-200 transition">
            ← Kembali ke Rak Buku
        </a>
        <div class="mt-2 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <div>
                <h1 class="font-display font-black text-2xl sm:text-3xl text-white">Ruang Fraksi & Prestasi Siswa</h1>
                <p class="text-xs sm:text-sm text-slate-400">Kumpulkan jam baca dan tuntaskan misi mingguan untuk mendukung kemenangan fraksimu.</p>
            </div>
            <span class="px-3.5 py-1.5 rounded-full bg-pink-500/20 text-pink-300 text-xs font-mono font-bold border border-pink-500/30 shadow-sm">
                🌸 Musim Ganjil 2026/2027
            </span>
        </div>
    </div>

    <!-- 1. Student Profile Card -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6 border border-pink-500/20 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-pink-500/15 rounded-full blur-3xl pointer-events-none" aria-hidden="true" role="presentation"></div>

        <div class="flex items-center gap-5">
            <div class="relative">
                <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="w-16 h-16 rounded-full bg-plum-850 border-2 border-pink-400 cover-shadow" loading="lazy" decoding="async">
                <span class="absolute -bottom-1 -right-1 px-1.5 py-0.2 bg-rose-500 text-white font-black text-[10px] rounded-full border border-plum-950 shadow">
                    Lv.{{ $student['level'] }}
                </span>
            </div>
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <h2 class="font-display font-extrabold text-xl text-white">{{ $student['name'] }}</h2>
                    <span class="px-2 py-0.5 rounded-full bg-pink-500/20 text-pink-300 text-xs font-bold font-mono border border-pink-500/30">
                        {{ $student['level_title'] }}
                    </span>
                </div>
                <p class="text-xs text-slate-400">{{ $student['grade'] }} • Fraksi {{ $student['house_emblem'] }} <strong class="text-pink-300">{{ $student['house'] }}</strong></p>
                
                <!-- XP Bar -->
                <div class="space-y-1 pt-1 max-w-xs">
                    <div class="flex justify-between text-[11px] text-pink-300/80 font-mono">
                        <span>Progres XP:</span>
                        <strong class="text-pink-400" id="xpTextDisplay">{{ $student['xp_current'] }} / {{ $student['xp_target'] }} XP</strong>
                    </div>
                    <div class="w-48 bg-plum-950 h-2 rounded-full overflow-hidden border border-pink-500/20">
                        <div id="xpProgressBar" class="h-full rounded-full bg-gradient-to-r from-pink-500 to-rose-400" style="width: 72%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Metrics -->
        <div class="grid grid-cols-3 gap-3 w-full sm:w-auto text-center">
            <div class="p-3.5 rounded-2xl bg-plum-950/70 border border-pink-500/20">
                <span class="text-xl">🔥</span>
                <span class="font-display font-bold text-white block text-sm mt-0.5">{{ $student['streak_days'] }} Hari</span>
                <span class="text-[10px] text-pink-300/70 uppercase tracking-wider">Streak</span>
            </div>
            <div class="p-3.5 rounded-2xl bg-plum-950/70 border border-pink-500/20">
                <span class="text-xl">⏱️</span>
                <span class="font-display font-bold text-pink-300 block text-sm mt-0.5">{{ $student['reading_minutes'] }}</span>
                <span class="text-[10px] text-pink-300/70 uppercase tracking-wider">Menit Baca</span>
            </div>
            <div class="p-3.5 rounded-2xl bg-plum-950/70 border border-pink-500/20">
                <span class="text-xl">📚</span>
                <span class="font-display font-bold text-emerald-400 block text-sm mt-0.5">{{ $student['books_finished'] }}</span>
                <span class="text-[10px] text-pink-300/70 uppercase tracking-wider">Tamat</span>
            </div>
        </div>
    </div>

    <!-- 2. 4 Houses (Piala Membaca) -->
    <div class="space-y-4">
        <div>
            <h3 class="font-display font-bold text-lg text-white">Klasemen 4 Fraksi Sekolah</h3>
            <p class="text-xs text-slate-400">Poin diakumulasikan dari durasi membaca seluruh siswa per fraksi.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($houses as $hIndex => $h)
            <div class="glass-card rounded-3xl p-5 space-y-3 border border-pink-500/15 {{ $h->name === $student['house'] ? 'border-pink-400/60 bg-pink-950/20 shadow-lg shadow-pink-500/15' : '' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="text-3xl">{{ $h->emblem }}</span>
                        <div>
                            <h4 class="font-display font-bold text-sm text-white">{{ $h->name }}</h4>
                            <span class="text-[11px] text-slate-400">{{ $h->member_count }} Siswa</span>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-pink-300 font-mono">#{{ $hIndex + 1 }}</span>
                </div>

                <p class="text-xs text-slate-300 italic">"{{ $h->motto }}"</p>

                <div class="pt-2 border-t border-white/5">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-slate-400">Total Poin:</span>
                        <strong class="text-white font-mono font-bold" id="housePoints-{{ $h->id }}">{{ number_format($h->total_points, 0, ',', '.') }}</strong>
                    </div>
                    <div class="w-full bg-plum-950 h-2 rounded-full overflow-hidden border border-pink-500/10">
                        @php $pct = min(100, round(($h->total_points / 4000) * 100)); @endphp
                        <div class="h-full rounded-full" style="width: {{ $pct }}%; background-color: {{ $h->color_hex }};"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- 3. Misi Mingguan (Quests) -->
    <div class="space-y-4">
        <div>
            <h3 class="font-display font-bold text-lg text-white">Misi Mingguan (Weekly Quests)</h3>
            <p class="text-xs text-slate-400">Selesaikan misi untuk mendapatkan bonus XP dan menyumbang poin fraksi.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($quests as $quest)
            <div class="glass-card rounded-2xl p-4 sm:p-5 flex flex-col justify-between gap-3 border border-pink-500/15">
                <div class="flex items-start gap-3.5">
                    <span class="text-2xl p-2.5 rounded-2xl bg-plum-900 border border-pink-500/20 shrink-0">{{ $quest->icon }}</span>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="font-display font-bold text-xs sm:text-sm text-white">{{ $quest->title }}</h4>
                            <span class="text-[10px] font-mono font-bold text-pink-300 bg-pink-500/20 border border-pink-500/30 px-2 py-0.5 rounded-full">
                                +{{ $quest->xp_reward }} XP
                            </span>
                        </div>
                        <p class="text-xs text-slate-300 mt-1 leading-relaxed">{{ $quest->description }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4 pt-3 border-t border-white/5">
                    <div class="flex-1">
                        <div class="flex justify-between text-[11px] text-pink-300/80 font-mono mb-1">
                            <span>Progres</span>
                            <span id="questCount-{{ $quest->id }}" class="font-bold text-pink-300">{{ $quest->current_count }} / {{ $quest->target_count }}</span>
                        </div>
                        <div class="w-full bg-plum-950 h-1.5 rounded-full overflow-hidden border border-pink-500/10">
                            @php $qPct = min(100, round(($quest->current_count / max(1, $quest->target_count)) * 100)); @endphp
                            <div id="questBar-{{ $quest->id }}" class="h-full bg-gradient-to-r from-pink-500 to-rose-400 rounded-full" style="width: {{ $qPct }}%;"></div>
                        </div>
                    </div>

                    @if($quest->is_completed)
                        <span class="px-3.5 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold">
                            ✓ Tuntas
                        </span>
                    @else
                        <button 
                            onclick="claimQuestProgress({{ $quest->id }})" 
                            id="questBtn-{{ $quest->id }}"
                            class="px-4 py-2 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-400 hover:to-rose-400 text-white text-xs font-bold transition shadow-md shadow-pink-500/20"
                        >
                            Lanjutkan
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- 4. Etalase Lencana (Badges) -->
    <div class="space-y-4">
        <div>
            <h3 class="font-display font-bold text-lg text-white">Koleksi Lencana</h3>
            <p class="text-xs text-slate-400">Lencana pencapaian literasi siswa.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            @foreach($badges as $badge)
            <div class="glass-card rounded-2xl p-4 text-center flex flex-col items-center justify-between gap-2 border border-pink-500/15 {{ $badge->unlocked ? 'border-pink-400/40 bg-pink-950/20 shadow-md shadow-pink-500/10' : 'opacity-60' }}">
                <span class="text-2xl p-2.5 rounded-2xl bg-plum-900 border border-pink-500/20">{{ $badge->icon }}</span>
                <div>
                    <h5 class="font-display font-bold text-xs text-white">{{ $badge->name }}</h5>
                    <p class="text-[10px] text-slate-400 mt-0.5 line-clamp-2">{{ $badge->description }}</p>
                </div>
                @if($badge->unlocked)
                    <span class="text-[9px] font-mono font-bold text-pink-300 bg-pink-500/20 px-2 py-0.5 rounded-full border border-pink-500/30">
                        {{ $badge->unlocked_date }}
                    </span>
                @else
                    <span class="text-[9px] text-slate-500">🔒 Terkunci</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- 5. Leaderboard Top 10 -->
    <div class="space-y-4">
        <div>
            <h3 class="font-display font-bold text-lg text-white">Peringkat Membaca Sekolah (Top 10)</h3>
            <p class="text-xs text-slate-400">Daftar siswa dengan durasi jam baca tertinggi bulan ini.</p>
        </div>

        <div class="glass-card rounded-3xl overflow-hidden border border-pink-500/20">
            <div class="divide-y divide-white/5 text-xs sm:text-sm">
                @foreach($leaderboard as $row)
                <div class="p-3.5 sm:px-6 flex items-center justify-between {{ isset($row['is_me']) && $row['is_me'] ? 'bg-pink-500/15 font-bold border-l-4 border-pink-400' : 'hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-slate-400 w-6 text-center text-base">
                            @if($row['rank'] === 1) 🥇 @elseif($row['rank'] === 2) 🥈 @elseif($row['rank'] === 3) 🥉 @else #{{ $row['rank'] }} @endif
                        </span>
                        <img src="{{ $row['avatar'] }}" alt="{{ $row['name'] }}" class="w-8 h-8 rounded-full bg-plum-850 border border-pink-400/30" loading="lazy" decoding="async">
                        <div>
                            <span class="text-white block font-semibold">
                                {{ $row['name'] }}
                            </span>
                            <span class="text-[11px] text-slate-400">{{ $row['grade'] }} • {{ $row['emblem'] }} {{ $row['house'] }}</span>
                        </div>
                    </div>
                    <span class="font-mono text-pink-300 font-bold">{{ number_format($row['minutes'], 0, ',', '.') }} Menit</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<script>
    async function claimQuestProgress(questId) {
        const btn = document.getElementById(`questBtn-${questId}`);
        btn.disabled = true;

        try {
            const res = await fetch('{{ route("lumina.api.quest") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ quest_id: questId })
            });
            const data = await res.json();

            document.getElementById(`questCount-${questId}`).textContent = `${data.quest.current_count} / ${data.quest.target_count}`;
            const pct = Math.min(100, Math.round((data.quest.current_count / data.quest.target_count) * 100));
            document.getElementById(`questBar-${questId}`).style.width = pct + '%';

            if (data.quest.is_completed) {
                btn.outerHTML = `<span class="px-3.5 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold">✓ Tuntas</span>`;
            } else {
                btn.disabled = false;
            }

            document.getElementById('xpTextDisplay').textContent = '1.550 / 2.000 XP';
            document.getElementById('xpProgressBar').style.width = '77%';

            showToast('Misi Diperbarui', `+${data.xp_earned} XP berhasil diraih!`);
        } catch(e) {
            console.error(e);
            btn.disabled = false;
            alert('Gagal memperbarui misi');
        }
    }
</script>
@endsection
