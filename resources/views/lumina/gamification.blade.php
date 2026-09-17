@extends('layouts.lumina')

@section('title', 'Fraksi & Peringkat - Lumina')

@section('content')
<div class="max-w-5xl mx-auto space-y-10 py-4">

    <!-- Header & Breadcrumb -->
    <div>
        <a href="{{ route('lumina.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition">
            ← Kembali ke Katalog
        </a>
        <div class="mt-2 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Ruang Fraksi & Prestasi Siswa</h1>
                <p class="text-xs sm:text-sm text-slate-500">Kumpulkan jam baca dan tuntaskan misi mingguan untuk mendukung fraksimu.</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">
                🏆 Musim Ganjil 2026/2027
            </span>
        </div>
    </div>

    <!-- 1. Student Profile Card (Clean & Simple) -->
    <div class="clean-card rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="w-16 h-16 rounded-full bg-slate-100 border border-slate-200">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-bold text-slate-900">{{ $student['name'] }}</h2>
                    <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 text-xs font-bold">
                        Level {{ $student['level'] }}
                    </span>
                </div>
                <p class="text-xs text-slate-500">{{ $student['grade'] }} • Fraksi {{ $student['house_emblem'] }} {{ $student['house'] }}</p>
                
                <!-- XP Bar -->
                <div class="space-y-1 pt-1 max-w-xs">
                    <div class="flex justify-between text-[11px] text-slate-500">
                        <span>Progres XP:</span>
                        <strong class="text-slate-800" id="xpTextDisplay">{{ $student['xp_current'] }} / {{ $student['xp_target'] }} XP</strong>
                    </div>
                    <div class="w-48 bg-slate-100 h-2 rounded-full overflow-hidden border border-slate-200">
                        <div id="xpProgressBar" class="h-full rounded-full bg-blue-600" style="width: 72%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Simple Metrics -->
        <div class="grid grid-cols-3 gap-3 w-full sm:w-auto text-center">
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                <span class="text-lg">🔥</span>
                <span class="font-bold text-slate-900 block text-sm mt-0.5">{{ $student['streak_days'] }} Hari</span>
                <span class="text-[10px] text-slate-500">Streak</span>
            </div>
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                <span class="text-lg">⏱️</span>
                <span class="font-bold text-blue-600 block text-sm mt-0.5">{{ $student['reading_minutes'] }}</span>
                <span class="text-[10px] text-slate-500">Menit Baca</span>
            </div>
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                <span class="text-lg">📚</span>
                <span class="font-bold text-emerald-600 block text-sm mt-0.5">{{ $student['books_finished'] }}</span>
                <span class="text-[10px] text-slate-500">Tamat</span>
            </div>
        </div>
    </div>

    <!-- 2. 4 Houses (Piala Membaca) -->
    <div class="space-y-4">
        <div>
            <h3 class="font-bold text-base text-slate-900">Klasemen 4 Fraksi Sekolah</h3>
            <p class="text-xs text-slate-500">Poin diakumulasikan dari durasi membaca seluruh siswa per fraksi.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($houses as $hIndex => $h)
            <div class="clean-card rounded-2xl p-5 space-y-3 {{ $h->name === $student['house'] ? 'border-blue-400 bg-blue-50/20' : '' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="text-2xl">{{ $h->emblem }}</span>
                        <div>
                            <h4 class="font-bold text-sm text-slate-900">{{ $h->name }}</h4>
                            <span class="text-[11px] text-slate-500">{{ $h->member_count }} Siswa</span>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-400">#{{ $hIndex + 1 }}</span>
                </div>

                <p class="text-xs text-slate-600 italic">"{{ $h->motto }}"</p>

                <div class="pt-2 border-t border-slate-100">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-slate-500">Total Poin:</span>
                        <strong class="text-slate-900 font-bold" id="housePoints-{{ $h->id }}">{{ number_format($h->total_points, 0, ',', '.') }}</strong>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
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
            <h3 class="font-bold text-base text-slate-900">Misi Mingguan</h3>
            <p class="text-xs text-slate-500">Selesaikan misi untuk mendapatkan bonus XP dan menyumbang poin fraksi.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($quests as $quest)
            <div class="clean-card rounded-2xl p-4 flex flex-col justify-between gap-3">
                <div class="flex items-start gap-3">
                    <span class="text-2xl p-2 rounded-xl bg-slate-100">{{ $quest->icon }}</span>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="font-semibold text-xs sm:text-sm text-slate-900">{{ $quest->title }}</h4>
                            <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded">
                                +{{ $quest->xp_reward }} XP
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $quest->description }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4 pt-2 border-t border-slate-100">
                    <div class="flex-1">
                        <div class="flex justify-between text-[11px] text-slate-500 mb-1">
                            <span>Progres</span>
                            <span id="questCount-{{ $quest->id }}" class="font-semibold text-slate-800">{{ $quest->current_count }} / {{ $quest->target_count }}</span>
                        </div>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                            @php $qPct = min(100, round(($quest->current_count / max(1, $quest->target_count)) * 100)); @endphp
                            <div id="questBar-{{ $quest->id }}" class="h-full bg-blue-600 rounded-full" style="width: {{ $qPct }}%;"></div>
                        </div>
                    </div>

                    @if($quest->is_completed)
                        <span class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold">
                            ✓ Tuntas
                        </span>
                    @else
                        <button 
                            onclick="claimQuestProgress({{ $quest->id }})" 
                            id="questBtn-{{ $quest->id }}"
                            class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition"
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
            <h3 class="font-bold text-base text-slate-900">Koleksi Lencana</h3>
            <p class="text-xs text-slate-500">Lencana pencapaian literasi siswa.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            @foreach($badges as $badge)
            <div class="clean-card rounded-xl p-3.5 text-center flex flex-col items-center justify-between gap-2 {{ $badge->unlocked ? 'border-blue-200 bg-blue-50/20' : 'opacity-60 bg-slate-50' }}">
                <span class="text-2xl p-2 rounded-xl bg-white shadow-2xs">{{ $badge->icon }}</span>
                <div>
                    <h5 class="font-bold text-xs text-slate-900">{{ $badge->name }}</h5>
                    <p class="text-[10px] text-slate-500 mt-0.5 line-clamp-2">{{ $badge->description }}</p>
                </div>
                @if($badge->unlocked)
                    <span class="text-[9px] font-semibold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">
                        {{ $badge->unlocked_date }}
                    </span>
                @else
                    <span class="text-[9px] text-slate-400">🔒 Terkunci</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- 5. Leaderboard Top 10 -->
    <div class="space-y-4">
        <div>
            <h3 class="font-bold text-base text-slate-900">Peringkat Membaca Sekolah (Top 10)</h3>
            <p class="text-xs text-slate-500">Daftar siswa dengan durasi jam baca tertinggi bulan ini.</p>
        </div>

        <div class="clean-card rounded-2xl overflow-hidden">
            <div class="divide-y divide-slate-100 text-xs sm:text-sm">
                @foreach($leaderboard as $row)
                <div class="p-3.5 sm:px-6 flex items-center justify-between {{ isset($row['is_me']) && $row['is_me'] ? 'bg-blue-50/60 font-semibold' : 'hover:bg-slate-50/50' }}">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-slate-400 w-6 text-center">
                            @if($row['rank'] === 1) 🥇 @elseif($row['rank'] === 2) 🥈 @elseif($row['rank'] === 3) 🥉 @else #{{ $row['rank'] }} @endif
                        </span>
                        <img src="{{ $row['avatar'] }}" class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200">
                        <div>
                            <span class="text-slate-900 block font-medium">
                                {{ $row['name'] }}
                            </span>
                            <span class="text-[11px] text-slate-500">{{ $row['grade'] }} • {{ $row['emblem'] }} {{ $row['house'] }}</span>
                        </div>
                    </div>
                    <span class="font-semibold text-blue-600 font-mono">{{ number_format($row['minutes'], 0, ',', '.') }} Menit</span>
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
                btn.outerHTML = `<span class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold">✓ Tuntas</span>`;
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
