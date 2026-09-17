<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Lumina - Perpustakaan Digital Sekolah')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #f8fafc;
            color: #0f172a;
            font-feature-settings: "cv02", "cv03", "cv04", "cv11";
        }
        .clean-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease-in-out;
        }
        .clean-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col font-sans antialiased text-slate-900 pb-20">

    <!-- Top Clean Navbar (Apple Books / Notion Style) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
            
            <!-- Logo & Brand -->
            <div class="flex items-center gap-6">
                <a href="{{ route('lumina.index') }}" class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                        L
                    </span>
                    <span class="font-bold text-lg tracking-tight text-slate-900">Lumina</span>
                </a>

                <!-- 3 Main Navigation Tabs -->
                <nav class="hidden sm:flex items-center gap-1 text-sm font-medium">
                    <a href="{{ route('lumina.index') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('lumina.index') && !request()->has('tab') ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        📚 Katalog Buku
                    </a>
                    <a href="{{ route('lumina.index', ['tab' => 'ai']) }}" class="px-3 py-1.5 rounded-lg transition {{ request()->get('tab') === 'ai' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        🤖 Fitur AI & Wawancara
                    </a>
                    <a href="{{ route('lumina.gamification') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('lumina.gamification') ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        🏆 Fraksi & Peringkat
                    </a>
                </nav>
            </div>

            <!-- Search Bar & User -->
            <div class="flex items-center gap-3">
                <div class="relative w-48 sm:w-64">
                    <input 
                        type="text" 
                        id="globalSearchInput" 
                        placeholder="Cari buku atau penulis..." 
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 pl-8 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white transition"
                        onkeyup="handleGlobalSearch(event)"
                    >
                    <span class="absolute left-2.5 top-2 text-slate-400 text-xs">🔍</span>
                </div>

                <!-- User Profile Pill -->
                <a href="{{ route('lumina.gamification') }}" class="flex items-center gap-2 pl-2 border-l border-slate-200 hover:opacity-80 transition" title="Profil Siswa">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Rayhan" alt="Rayhan" class="w-7 h-7 rounded-full bg-slate-100 border border-slate-200">
                    <div class="hidden md:block text-left text-xs">
                        <span class="font-semibold text-slate-800 block leading-tight">Rayhan</span>
                        <span class="text-[10px] text-blue-600 font-medium">Lv. 5 • Garuda</span>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-6xl mx-auto px-4 sm:px-6 py-6 w-full">
        @yield('content')
    </main>

    <!-- Clean Floating Audio Player (Only shows when playing) -->
    <div id="globalAudioPlayer" class="fixed bottom-4 left-1/2 -translate-x-1/2 w-[92%] max-w-2xl z-40 hidden transition-all duration-300">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-3 sm:p-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <img id="audioPlayerCover" src="" class="w-10 h-10 rounded-lg object-cover bg-slate-100 border border-slate-200 shrink-0">
                <div class="min-w-0">
                    <h4 id="audioPlayerTitle" class="text-xs sm:text-sm font-bold text-slate-900 truncate">Judul Buku</h4>
                    <p id="audioPlayerAuthor" class="text-[11px] text-slate-500 truncate">Penulis</p>
                </div>
            </div>

            <!-- Controls -->
            <div class="flex items-center gap-2 shrink-0">
                <button onclick="cycleAudioSpeed()" id="audioSpeedBtn" class="px-2 py-1 rounded bg-slate-100 text-[10px] font-bold text-slate-700 hover:bg-slate-200 transition">
                    1.0x
                </button>
                <button onclick="toggleAudioSpeech()" class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm shadow hover:bg-blue-700 transition">
                    <span id="audioPlayIcon">▶</span>
                </button>
                <button onclick="closeAudioPlayer()" class="text-slate-400 hover:text-slate-600 p-1.5 text-xs transition" title="Tutup">
                    ✕
                </button>
            </div>
        </div>
    </div>

    <!-- Clean Toast Notification -->
    <div id="toastContainer" class="fixed top-20 right-4 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- Scripts -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Toast Message
        function showToast(title, subtitle) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'bg-slate-900 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 transition-all duration-300 transform translate-y-2 opacity-0 pointer-events-auto text-xs';
            toast.innerHTML = `
                <span class="text-base">✨</span>
                <div>
                    <strong class="block text-white font-semibold">${title}</strong>
                    <span class="text-slate-300">${subtitle}</span>
                </div>
            `;
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('translate-y-2', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        // Web Speech Audio Player
        let currentUtterance = null;
        let audioSpeed = 1.0;
        let activeAudioBook = {};

        function startAudiobook(title, author, cover, text) {
            activeAudioBook = { title, author, cover, text };
            document.getElementById('audioPlayerTitle').textContent = title;
            document.getElementById('audioPlayerAuthor').textContent = author;
            document.getElementById('audioPlayerCover').src = cover;
            document.getElementById('globalAudioPlayer').classList.remove('hidden');

            playAudioSpeech(text);
        }

        function playAudioSpeech(textToRead) {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                currentUtterance = new SpeechSynthesisUtterance(textToRead);
                currentUtterance.rate = audioSpeed;
                currentUtterance.lang = 'id-ID';

                currentUtterance.onstart = () => {
                    document.getElementById('audioPlayIcon').textContent = '⏸';
                };
                currentUtterance.onend = () => {
                    document.getElementById('audioPlayIcon').textContent = '▶';
                    showToast('Selesai', 'Selesai mendengarkan audio');
                };
                window.speechSynthesis.speak(currentUtterance);
            }
        }

        function toggleAudioSpeech() {
            if (!('speechSynthesis' in window)) return;
            if (window.speechSynthesis.speaking) {
                if (window.speechSynthesis.paused) {
                    window.speechSynthesis.resume();
                    document.getElementById('audioPlayIcon').textContent = '⏸';
                } else {
                    window.speechSynthesis.pause();
                    document.getElementById('audioPlayIcon').textContent = '▶';
                }
            } else {
                playAudioSpeech(activeAudioBook.text);
            }
        }

        function cycleAudioSpeed() {
            const speeds = [0.8, 1.0, 1.25, 1.5];
            let nextIndex = (speeds.indexOf(audioSpeed) + 1) % speeds.length;
            audioSpeed = speeds[nextIndex];
            document.getElementById('audioSpeedBtn').textContent = audioSpeed.toFixed(1) + 'x';
            if (window.speechSynthesis.speaking) {
                playAudioSpeech(activeAudioBook.text);
            }
        }

        function closeAudioPlayer() {
            if ('speechSynthesis' in window) window.speechSynthesis.cancel();
            document.getElementById('globalAudioPlayer').classList.add('hidden');
        }

        function handleGlobalSearch(e) {
            const q = e.target.value.toLowerCase();
            document.querySelectorAll('.book-card').forEach(card => {
                const title = (card.getAttribute('data-title') || '').toLowerCase();
                const author = (card.getAttribute('data-author') || '').toLowerCase();
                if (title.includes(q) || author.includes(q)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
