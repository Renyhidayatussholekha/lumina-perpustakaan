@extends('layouts.lumina')

@section('title', 'Fraksi & Prestasi - Lumina')

@section('content')
<div class="max-w-5xl mx-auto space-y-10 py-4">

    <!-- Header & Breadcrumb -->
    <div>
        <a href="{{ route('lumina.index') }}" class="text-xs font-bold text-slate-400 hover:text-cyan-400 transition">
            ← Kembali ke Rak Buku
        </a>
        <div class="mt-2 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <div>
                <h1 class="font-display font-black text-2xl sm:text-3xl text-white">Ruang Fraksi & Prestasi Siswa</h1>
                <p class="text-xs sm:text-sm text-slate-400">Kumpulkan jam baca dan tuntaskan misi mingguan untuk mendukung kemenangan fraksimu.</p>
            </div>
            <span class="px-3.5 py-1.5 rounded-full bg-amber-500/20 text-amber-300 text-xs font-mono font-bold border border-amber-500/30">
                🏆 Musim Ganjil 2026/2027
            </span>
        </div>
    </div>

    <!-- 1. Student Profile Card -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6 border border-white/10 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex items-center gap-5">
            <div class="relative">
                <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="w-16 h-16 rounded-full bg-space-800 border-2 border-cyan-400 cover-shadow">
                <span class="absolute -bottom-1 -right-1 px-1.5 py-0.2 bg-amber-500 text-space-950 font-black text-[10px] rounded-full border border-space-950 shadow">
                    Lv.{{ $student['level'] }}
                </span>
            </div>
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <h2 class="font-display font-extrabold text-xl text-white">{{ $student['name'] }}</h2>
                    <span class="px-2 py-0.5 rounded-full bg-cyan-500/20 text-cyan-300 text-xs font-bold font-mono">
                        {{ $student['level_title'] }}
                    </span>
                </div>
                <p class="text-xs text-slate-400">{{ $student['grade'] }} • Fraksi {{ $student['house_emblem'] }} <strong class="text-cyan-400">{{ $student['house'] }}</strong></p>
                
                <!-- XP Bar -->
                <div class="space-y-1 pt-1 max-w-xs">
                    <div class="flex justify-between text-[11px] text-slate-400 font-mono">
                        <span>Progres XP:</span>
                        <strong class="text-cyan-400" id="xpTextDisplay">{{ $student['xp_current'] }} / {{ $student['xp_target'] }} XP</strong>
                    </div>
                    <div class="w-48 bg-space-950 h-2 rounded-full overflow-hidden border border-white/10">
                        <div id="xpProgressBar" class="h-full rounded-full bg-gradient-to-r from-cyan-400 to-blue-500" style="width: 72%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Metrics -->
        <div class="grid grid-cols-3 gap-3 w-full sm:w-auto text-center">
            <div class="p-3.5 rounded-2xl bg-space-950/60 border border-white/10">
                <span class="text-xl">🔥</span>
                <span class="font-display font-bold text-white block text-sm mt-0.5">{{ $student['streak_days'] }} Hari</span>
                <span class="text-[10px] text-slate-400 uppercase tracking-wider">Streak</span>
            </div>
            <div class="p-3.5 rounded-2xl bg-space-950/60 border border-white/10">
                <span class="text-xl">⏱️</span>
                <span class="font-display font-bold text-cyan-400 block text-sm mt-0.5">{{ $student['reading_minutes'] }}</span>
                <span class="text-[10px] text-slate-400 uppercase tracking-wider">Menit Baca</span>
            </div>
            <div class="p-3.5 rounded-2xl bg-space-950/60 border border-white/10">
                <span class="text-xl">📚</span>
                <span class="font-display font-bold text-emerald-400 block text-sm mt-0.5">{{ $student['books_finished'] }}</span>
                <span class="text-[10px] text-slate-400 uppercase tracking-wider">Tamat</span>
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
            <div class="glass-card rounded-3xl p-5 space-y-3 border border-white/10 {{ $h->name === $student['house'] ? 'border-cyan-400/60 bg-cyan-950/20 shadow-lg shadow-cyan-500/10' : '' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="text-3xl">{{ $h->emblem }}</span>
                        <div>
                            <h4 class="font-display font-bold text-sm text-white">{{ $h->name }}</h4>
                            <span class="text-[11px] text-slate-400">{{ $h->member_count }} Siswa</span>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-cyan-400 font-mono">#{{ $hIndex + 1 }}</span>
                </div>

                <p class="text-xs text-slate-300 italic">"{{ $h->motto }}"</p>

                <div class="pt-2 border-t border-white/10">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-slate-400">Total Poin:</span>
                        <strong class="text-white font-mono font-bold" id="housePoints-{{ $h->id }}">{{ number_format($h->total_points, 0, ',', '.') }}</strong>
                    </div>
                    <div class="w-full bg-space-950 h-2 rounded-full overflow-hidden">
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
            <div class="glass-card rounded-2xl p-4 sm:p-5 flex flex-col justify-between gap-3 border border-white/10">
                <div class="flex items-start gap-3.5">
                    <span class="text-2xl p-2.5 rounded-2xl bg-space-900 border border-white/10 shrink-0">{{ $quest->icon }}</span>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="font-display font-bold text-xs sm:text-sm text-white">{{ $quest->title }}</h4>
                            <span class="text-[10px] font-mono font-bold text-amber-300 bg-amber-500/20 border border-amber-500/30 px-2 py-0.5 rounded-full">
                                +{{ $quest->xp_reward }} XP
                            </span>
                        </div>
                        <p class="text-xs text-slate-300 mt-1 leading-relaxed">{{ $quest->description }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4 pt-3 border-t border-white/10">
                    <div class="flex-1">
                        <div class="flex justify-between text-[11px] text-slate-400 font-mono mb-1">
                            <span>Progres</span>
                            <span id="questCount-{{ $quest->id }}" class="font-bold text-cyan-400">{{ $quest->current_count }} / {{ $quest->target_count }}</span>
                        </div>
                        <div class="w-full bg-space-950 h-1.5 rounded-full overflow-hidden">
                            @php $qPct = min(100, round(($quest->current_count / max(1, $quest->target_count)) * 100)); @endphp
                            <div id="questBar-{{ $quest->id }}" class="h-full bg-cyan-400 rounded-full" style="width: {{ $qPct }}%;"></div>
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
                            class="px-4 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-space-950 text-xs font-bold transition shadow-md shadow-cyan-500/20"
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
            <div class="glass-card rounded-2xl p-4 text-center flex flex-col items-center justify-between gap-2 border border-white/10 {{ $badge->unlocked ? 'border-amber-400/30 bg-amber-950/10' : 'opacity-60' }}">
                <span class="text-2xl p-2.5 rounded-2xl bg-space-900 border border-white/10">{{ $badge->icon }}</span>
                <div>
                    <h5 class="font-display font-bold text-xs text-white">{{ $badge->name }}</h5>
                    <p class="text-[10px] text-slate-400 mt-0.5 line-clamp-2">{{ $badge->description }}</p>
                </div>
                @if($badge->unlocked)
                    <span class="text-[9px] font-mono font-bold text-amber-300 bg-amber-500/20 px-2 py-0.5 rounded-full border border-amber-500/30">
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

        <div class="glass-card rounded-3xl overflow-hidden border border-white/10">
            <div class="divide-y divide-white/10 text-xs sm:text-sm">
                @foreach($leaderboard as $row)
                <div class="p-3.5 sm:px-6 flex items-center justify-between {{ isset($row['is_me']) && $row['is_me'] ? 'bg-cyan-500/10 font-bold border-l-4 border-cyan-400' : 'hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-slate-400 w-6 text-center text-base">
                            @if($row['rank'] === 1) 🥇 @elseif($row['rank'] === 2) 🥈 @elseif($row['rank'] === 3) 🥉 @else #{{ $row['rank'] }} @endif
                        </span>
                        <img src="{{ $row['avatar'] }}" class="w-8 h-8 rounded-full bg-space-800 border border-slate-700">
                        <div>
                            <span class="text-white block font-semibold">
                                {{ $row['name'] }}
                            </span>
                            <span class="text-[11px] text-slate-400">{{ $row['grade'] }} • {{ $row['emblem'] }} {{ $row['house'] }}</span>
                        </div>
                    </div>
                    <span class="font-mono text-cyan-400 font-bold">{{ number_format($row['minutes'], 0, ',', '.') }} Menit</span>
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
