<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Lumina - Smart School Digital Library')</title>

    <!-- Google Fonts: Outfit (Display) & Plus Jakarta Sans (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        plum: {
                            950: '#090510',
                            900: '#10091d',
                            850: '#160d26',
                            800: '#1f1335',
                            700: '#2b1b47',
                        },
                        pinky: {
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777',
                            soft: '#ffe4e6',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #090510;
            color: #fdf2f8;
        }

        /* Cute & Calm Glassmorphism (Midnight Rose Library) */
        .glass-card {
            background: rgba(22, 13, 38, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(244, 114, 182, 0.12);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-card:hover {
            border-color: rgba(244, 114, 182, 0.35);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(236, 72, 153, 0.12);
        }

        .cover-shadow {
            box-shadow: 0 12px 28px -6px rgba(0, 0, 0, 0.8), 0 4px 12px -2px rgba(236, 72, 153, 0.2);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col font-sans antialiased selection:bg-pinky-500 selection:text-white pb-20">

    <!-- Top Floating Navbar -->
    <header class="sticky top-0 z-50 bg-plum-950/80 backdrop-blur-xl border-b border-pink-500/10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
            
            <!-- Brand Logo -->
            <div class="flex items-center gap-6">
                <a href="{{ route('lumina.index') }}" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-pink-500 via-rose-500 to-pink-400 flex items-center justify-center text-white text-sm font-black shadow-md shadow-pink-500/30 group-hover:scale-105 transition">
                        🌸
                    </div>
                    <span class="font-display font-extrabold text-xl tracking-tight text-white group-hover:text-pink-300 transition">Lumina</span>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden sm:flex items-center gap-1 text-xs sm:text-sm font-medium">
                    <a href="{{ route('lumina.index') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('lumina.index') ? 'text-white font-bold bg-pink-500/20 text-pink-300 border border-pink-500/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Rak Buku
                    </a>
                    <a href="{{ route('lumina.gamification') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('lumina.gamification') ? 'text-white font-bold bg-pink-500/20 text-pink-300 border border-pink-500/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Piala & Fraksi
                    </a>
                </nav>
            </div>

            <!-- Search Bar & Clean Profile -->
            <div class="flex items-center gap-3">
                <div class="relative w-44 sm:w-60">
                    <input 
                        type="text" 
                        id="globalSearchInput" 
                        placeholder="Cari buku kesukaanmu..." 
                        class="w-full bg-plum-900 border border-pink-500/20 rounded-full px-3 py-1.5 pl-8 text-xs text-slate-200 placeholder-pink-300/40 focus:outline-none focus:border-pink-400 transition"
                        onkeyup="handleGlobalSearch(event)"
                    >
                    <span class="absolute left-2.5 top-2 text-pink-400 text-xs">🔍</span>
                </div>

                <!-- Clean User Avatar with Level -->
                <a href="{{ route('lumina.gamification') }}" class="flex items-center gap-2 pl-2 border-l border-white/10 hover:opacity-85 transition" title="Profil Siswa">
                    <div class="relative">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Rayhan" alt="Rayhan" class="w-8 h-8 rounded-full bg-plum-850 border border-pink-400/50">
                        <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-rose-500 text-white font-black text-[9px] rounded-full flex items-center justify-center shadow">5</span>
                    </div>
                    <span class="text-xs font-semibold text-pink-200 hidden md:inline">Rayhan</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-6xl mx-auto px-4 sm:px-6 py-6 w-full">
        @yield('content')
    </main>

    <!-- Floating Audio Player Bar (Pinky Sleek) -->
    <div id="globalAudioPlayer" class="fixed bottom-4 left-1/2 -translate-x-1/2 w-[92%] max-w-xl z-50 hidden transition-all duration-300">
        <div class="bg-plum-900/95 backdrop-blur-xl border border-pink-500/30 rounded-2xl p-3.5 shadow-2xl shadow-pink-950/60 flex items-center justify-between gap-3 text-white">
            <div class="flex items-center gap-3 min-w-0">
                <img id="audioPlayerCover" src="" class="w-10 h-10 rounded-lg object-cover bg-plum-800 shrink-0 border border-pink-400/30">
                <div class="min-w-0">
                    <h4 id="audioPlayerTitle" class="text-xs sm:text-sm font-bold text-white truncate">Judul Buku</h4>
                    <p id="audioPlayerAuthor" class="text-[11px] text-pink-300 truncate">Penulis</p>
                </div>
            </div>

            <!-- Controls -->
            <div class="flex items-center gap-2 shrink-0">
                <button onclick="cycleAudioSpeed()" id="audioSpeedBtn" class="px-2 py-1 rounded bg-plum-800 text-[10px] font-bold text-pink-300 hover:bg-plum-700 transition">
                    1.0x
                </button>
                <button onclick="toggleAudioSpeech()" class="w-9 h-9 rounded-full bg-gradient-to-tr from-pink-500 to-rose-500 text-white flex items-center justify-center font-bold text-sm shadow hover:scale-105 transition">
                    <span id="audioPlayIcon">▶</span>
                </button>
                <button onclick="closeAudioPlayer()" class="text-pink-300/60 hover:text-white p-1 text-xs transition">
                    ✕
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastContainer" class="fixed top-20 right-4 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- Global Scripts -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Toast
        function showToast(title, subtitle) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'bg-plum-900 border border-pink-500/40 text-white px-4 py-3 rounded-2xl shadow-xl shadow-pink-950/50 flex items-center gap-3 transition-all duration-300 transform translate-y-2 opacity-0 pointer-events-auto text-xs';
            toast.innerHTML = `
                <span class="text-lg">🌸</span>
                <div>
                    <strong class="block text-pink-200 font-bold">${title}</strong>
                    <span class="text-slate-300">${subtitle}</span>
                </div>
            `;
            container.appendChild(toast);

            setTimeout(() => toast.classList.remove('translate-y-2', 'opacity-0'), 10);
            setTimeout(() => {
                toast.classList.add('translate-y-2', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        // Web Speech Audio Engine
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
                    showToast('Selesai', 'Selesai mendengarkan kutipan audio');
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
