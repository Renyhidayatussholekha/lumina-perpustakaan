@extends('layouts.lumina')

@section('title', 'Ruang Gamifikasi & Fraksi Sekolah - Lumina')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">

    <!-- Header Title -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-2xl">🎮</span>
                <h1 class="font-display font-extrabold text-3xl text-white">Ruang Gamifikasi & Fraksi Sekolah</h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">
                Kumpulkan XP, tuntaskan misi mingguan, dan bawa fraksimu memperebutkan Piala Membaca bergengsi!
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs font-mono font-bold">
                🏆 Musim Ganjil 2026/2027
            </span>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 1. STUDENT PROFILE & CIRCULAR LEVELING     -->
    <!-- ========================================== -->
    <div class="p-6 sm:p-8 rounded-3xl glass-panel border border-cyan-500/40 bg-gradient-to-r from-navy-900/90 via-navy-950 to-navy-900 shadow-2xl relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
            <!-- Left: Avatar with Circular XP SVG -->
            <div class="flex flex-col sm:flex-row items-center gap-6 text-center sm:text-left">
                <div class="relative flex items-center justify-center shrink-0">
                    <!-- Circular Animated Progress SVG -->
                    <svg class="w-32 h-32 transform -rotate-90">
                        <circle cx="64" cy="64" r="54" stroke="#1e294f" stroke-width="8" fill="transparent"/>
                        <circle cx="64" cy="64" r="54" stroke="#06b6d4" stroke-width="8" stroke-dasharray="339" stroke-dashoffset="93" stroke-linecap="round" fill="transparent" class="transition-all duration-1000"/>
                    </svg>
                    <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="w-24 h-24 rounded-full absolute object-cover bg-navy-800 border-2 border-navy-950 shadow-inner">
                    <span class="absolute -bottom-1 bg-amber-500 text-navy-950 text-xs font-black px-3 py-0.5 rounded-full border-2 border-navy-950 shadow">
                        Lv. {{ $student['level'] }}
                    </span>
                </div>

                <div class="space-y-2">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                        <h2 class="font-display font-extrabold text-2xl text-white">{{ $student['name'] }}</h2>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                            {{ $student['grade'] }}
                        </span>
                    </div>

                    <div class="flex items-center justify-center sm:justify-start gap-2 text-xs text-slate-300">
                        <span>Gelar: <strong class="text-amber-400">{{ $student['level_title'] }}</strong></span>
                        <span>•</span>
                        <span>Fraksi: <strong class="text-cyan-400">{{ $student['house_emblem'] }} {{ $student['house'] }}</strong></span>
                    </div>

                    <!-- XP Progress Bar -->
                    <div class="space-y-1 max-w-sm pt-1">
                        <div class="flex justify-between text-[11px] font-mono text-slate-400">
                            <span>Level 5 (Progres ke Level 6)</span>
                            <span class="text-cyan-400 font-bold" id="xpTextDisplay">{{ $student['xp_current'] }} / {{ $student['xp_target'] }} XP</span>
                        </div>
                        <div class="w-full bg-navy-950 h-2.5 rounded-full overflow-hidden border border-slate-800">
                            <div id="xpProgressBar" class="bg-gradient-to-r from-cyan-400 to-blue-500 h-full rounded-full transition-all duration-700" style="width: 72%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: 3 Quick Key Metrics -->
            <div class="grid grid-cols-3 gap-3 sm:gap-4 w-full lg:w-auto">
                <div class="p-4 rounded-2xl bg-navy-900/80 border border-slate-800 text-center">
                    <span class="text-2xl">🔥</span>
                    <h4 class="font-display font-extrabold text-lg text-white mt-1">{{ $student['streak_days'] }} Hari</h4>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider">Streak Baca</p>
                </div>
                <div class="p-4 rounded-2xl bg-navy-900/80 border border-slate-800 text-center">
                    <span class="text-2xl">⏱️</span>
                    <h4 class="font-display font-extrabold text-lg text-cyan-400 mt-1">{{ $student['reading_minutes'] }}</h4>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider">Menit Baca</p>
                </div>
                <div class="p-4 rounded-2xl bg-navy-900/80 border border-slate-800 text-center">
                    <span class="text-2xl">📚</span>
                    <h4 class="font-display font-extrabold text-lg text-emerald-400 mt-1">{{ $student['books_finished'] }}</h4>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider">Buku Tamat</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 2. SISTEM 4 FRAKSI & PIALA MEMBACA         -->
    <!-- ========================================== -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🛡️</span>
                    <h3 class="font-display font-extrabold text-2xl text-white">Sistem 4 Fraksi (Houses of Lumina)</h3>
                </div>
                <p class="text-xs text-slate-400 mt-1">
                    Seperti 4 asrama legendaris, setiap menit bacaan seluruh anggota fraksi dikonversi menjadi poin klasemen.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($houses as $index => $h)
            <div class="p-5 rounded-3xl glass-panel border relative overflow-hidden flex flex-col justify-between group transition duration-300 hover:scale-[1.02] {{ $h->name === $student['house'] ? 'border-cyan-400 shadow-glow-cyan bg-cyan-950/20' : 'border-slate-800 bg-navy-900/80' }}">
                
                @if($h->name === $student['house'])
                <div class="absolute top-3 right-3 bg-cyan-500 text-navy-950 font-black text-[9px] px-2 py-0.5 rounded-full uppercase tracking-wider">
                    Fraksimu
                </div>
                @endif

                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-3xl shadow-lg" style="background-color: {{ $h->color_hex }}20; border: 1px solid {{ $h->color_hex }}40;">
                            {{ $h->emblem }}
                        </div>
                        <div>
                            <span class="text-[10px] font-mono font-bold text-slate-400 uppercase">Peringkat #{{ $index + 1 }}</span>
                            <h4 class="font-display font-extrabold text-base text-white">{{ $h->name }}</h4>
                        </div>
                    </div>

                    <p class="text-xs text-slate-300 italic">"{{ $h->motto }}"</p>
                    <p class="text-[11px] text-slate-400 leading-relaxed">{{ $h->description }}</p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-800/80 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">{{ $h->member_count }} Pelajar</span>
                        <strong class="text-white font-mono text-sm" id="housePoints-{{ $h->id }}">{{ number_format($h->total_points, 0, ',', '.') }} Poin</strong>
                    </div>
                    <div class="w-full bg-navy-950 h-2 rounded-full overflow-hidden">
                        @php
                            $pct = min(100, round(($h->total_points / 4000) * 100));
                        @endphp
                        <div class="h-full rounded-full transition-all duration-700" style="width: {{ $pct }}%; background-color: {{ $h->color_hex }};"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 3. MISI MINGGUAN (QUESTS SYSTEM)           -->
    <!-- ========================================== -->
    <div class="space-y-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-2xl">🎯</span>
                <h3 class="font-display font-extrabold text-2xl text-white">Misi Mingguan (Weekly Quests)</h3>
            </div>
            <p class="text-xs text-slate-400 mt-1">
                Selesaikan misi acak berikut untuk membuka lencana khusus dan mengumpulkan limpahan XP!
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($quests as $quest)
            <div class="p-5 rounded-2xl glass-panel border {{ $quest->is_completed ? 'border-emerald-500/40 bg-emerald-950/10' : 'border-slate-800 bg-navy-900/80' }} flex flex-col justify-between gap-4">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-11 h-11 rounded-xl bg-navy-950 border border-slate-700 flex items-center justify-center text-2xl shrink-0 mt-0.5">
                            {{ $quest->icon }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="font-display font-bold text-sm text-white">{{ $quest->title }}</h4>
                                <span class="px-2 py-0.2 rounded-full text-[10px] font-mono font-bold bg-amber-500/20 text-amber-300">
                                    +{{ $quest->xp_reward }} XP
                                </span>
                            </div>
                            <p class="text-xs text-slate-300 mt-1 leading-relaxed">{{ $quest->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quest Progress Bar & Action -->
                <div class="flex items-center justify-between gap-4 pt-3 border-t border-slate-800/80">
                    <div class="flex-1 space-y-1">
                        <div class="flex justify-between text-[11px] font-mono text-slate-400">
                            <span>Progres:</span>
                            <span id="questCount-{{ $quest->id }}" class="font-bold text-cyan-400">{{ $quest->current_count }} / {{ $quest->target_count }}</span>
                        </div>
                        <div class="w-full bg-navy-950 h-2 rounded-full overflow-hidden">
                            @php
                                $qPct = min(100, round(($quest->current_count / max(1, $quest->target_count)) * 100));
                            @endphp
                            <div id="questBar-{{ $quest->id }}" class="h-full bg-cyan-400 rounded-full transition-all duration-500" style="width: {{ $qPct }}%;"></div>
                        </div>
                    </div>

                    @if($quest->is_completed)
                        <span class="px-4 py-2 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-xs border border-emerald-500/30 flex items-center gap-1 shrink-0">
                            <span>✓</span> Tuntas
                        </span>
                    @else
                        <button 
                            onclick="claimQuestProgress({{ $quest->id }})" 
                            id="questBtn-{{ $quest->id }}"
                            class="px-4 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-bold text-xs shadow-glow-cyan transition active:scale-95 shrink-0"
                        >
                            Lanjutkan Misi
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 4. ETALASE LENCANA (BADGES SHOWCASE)       -->
    <!-- ========================================== -->
    <div class="space-y-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-2xl">🏅</span>
                <h3 class="font-display font-extrabold text-2xl text-white">Etalase Lencana Siswa</h3>
            </div>
            <p class="text-xs text-slate-400 mt-1">
                Lencana kebanggaan yang didapatkan dari jam baca aktif, wawancara AI, dan dedikasi literasi.
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($badges as $badge)
            <div class="p-4 rounded-2xl glass-panel border text-center flex flex-col items-center justify-between gap-3 group transition {{ $badge->unlocked ? 'border-amber-400/50 bg-gradient-to-b from-amber-950/20 via-navy-900 to-navy-950 shadow-lg' : 'border-slate-800 bg-navy-900/40 opacity-60' }}">
                
                <!-- Badge Icon -->
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl transition group-hover:scale-110 {{ $badge->unlocked ? 'bg-amber-500/20 shadow-glow-orange border border-amber-400/40' : 'bg-slate-800 border border-slate-700' }}">
                    {{ $badge->icon }}
                </div>

                <div>
                    <h5 class="font-display font-bold text-xs text-white leading-tight mt-1">{{ $badge->name }}</h5>
                    <p class="text-[10px] text-slate-400 mt-1 line-clamp-2">{{ $badge->description }}</p>
                </div>

                @if($badge->unlocked)
                    <span class="text-[9px] font-mono text-amber-400 font-bold bg-amber-500/10 px-2 py-0.5 rounded-full border border-amber-400/20">
                        Diraih: {{ $badge->unlocked_date }}
                    </span>
                @else
                    <span class="text-[9px] font-mono text-slate-500 bg-slate-800 px-2 py-0.5 rounded-full flex items-center gap-1">
                        🔒 Terkunci
                    </span>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 5. PAPAN PERINGKAT SISWA (LEADERBOARD)     -->
    <!-- ========================================== -->
    <div class="space-y-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-2xl">👑</span>
                <h3 class="font-display font-extrabold text-2xl text-white">Papan Peringkat Membaca Sekolah (Top 10)</h3>
            </div>
            <p class="text-xs text-slate-400 mt-1">
                Daftar siswa dengan dedikasi jam membaca tertinggi bulan ini di perpustakaan sekolah.
            </p>
        </div>

        <div class="glass-panel rounded-3xl border border-slate-800 overflow-hidden bg-navy-900/90 shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead class="bg-navy-950/80 border-b border-slate-800 text-[11px] font-mono uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="p-4">Rank</th>
                            <th class="p-4">Siswa</th>
                            <th class="p-4">Fraksi</th>
                            <th class="p-4">Total Jam Baca</th>
                            <th class="p-4">Poin Kontribusi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($leaderboard as $row)
                        <tr class="transition {{ isset($row['is_me']) && $row['is_me'] ? 'bg-cyan-950/40 border-l-4 border-cyan-400' : 'hover:bg-slate-800/40' }}">
                            <td class="p-4 font-mono font-bold">
                                @if($row['rank'] === 1)
                                    <span class="text-xl">🥇</span>
                                @elseif($row['rank'] === 2)
                                    <span class="text-xl">🥈</span>
                                @elseif($row['rank'] === 3)
                                    <span class="text-xl">🥉</span>
                                @else
                                    <span class="text-slate-400">#{{ $row['rank'] }}</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $row['avatar'] }}" alt="{{ $row['name'] }}" class="w-9 h-9 rounded-full bg-navy-800 border border-slate-700">
                                    <div>
                                        <div class="font-bold text-white flex items-center gap-1.5">
                                            <span>{{ $row['name'] }}</span>
                                            @if(isset($row['is_me']) && $row['is_me'])
                                                <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-cyan-500 text-navy-950">Kamu</span>
                                            @endif
                                        </div>
                                        <span class="text-[11px] text-slate-400">{{ $row['grade'] }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-200 flex items-center gap-1.5 w-fit">
                                    <span>{{ $row['emblem'] }}</span>
                                    <span>{{ $row['house'] }}</span>
                                </span>
                            </td>
                            <td class="p-4 font-mono text-cyan-400 font-bold">
                                {{ number_format($row['minutes'], 0, ',', '.') }} Menit
                            </td>
                            <td class="p-4 font-mono text-amber-400 font-bold">
                                +{{ $row['points'] }} Poin
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    async function claimQuestProgress(questId) {
        const btn = document.getElementById(`questBtn-${questId}`);
        btn.disabled = true;
        btn.innerText = 'Memproses...';

        try {
            const response = await fetch('{{ route("lumina.api.quest") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ quest_id: questId })
            });
            const data = await response.json();

            const countEl = document.getElementById(`questCount-${questId}`);
            const barEl = document.getElementById(`questBar-${questId}`);

            countEl.textContent = `${data.quest.current_count} / ${data.quest.target_count}`;
            const pct = Math.min(100, Math.round((data.quest.current_count / data.quest.target_count) * 100));
            barEl.style.width = pct + '%';

            if (data.quest.is_completed) {
                btn.outerHTML = `<span class="px-4 py-2 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-xs border border-emerald-500/30 flex items-center gap-1 shrink-0"><span>✓</span> Tuntas</span>`;
            } else {
                btn.disabled = false;
                btn.innerText = 'Lanjutkan Misi';
            }

            // Update user XP display
            const xpDisplay = document.getElementById('xpTextDisplay');
            xpDisplay.textContent = '1.550 / 2.000 XP';
            document.getElementById('xpProgressBar').style.width = '77%';

            showToast('🎉 Progres Misi Diperbarui!', `+${data.xp_earned} XP berhasil diraih untukmu dan fraksimu!`, 'cyan');
        } catch (err) {
            console.error(err);
            btn.disabled = false;
            btn.innerText = 'Lanjutkan Misi';
            alert('Gagal memperbarui misi');
        }
    }
</script>
@endsection
