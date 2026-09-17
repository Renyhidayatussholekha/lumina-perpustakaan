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
<body class="min-h-screen flex flex-col font-sans antialiased selection:bg-pinky-500 selection:text-white pb-24 sm:pb-16">

    <!-- Top Floating Navbar -->
    <header class="sticky top-0 z-50 bg-plum-950/85 backdrop-blur-xl border-b border-pink-500/10">
        <div class="max-w-6xl mx-auto px-3 sm:px-6 h-16 flex items-center justify-between gap-2 sm:gap-4">
            
            <!-- Brand Logo & Mobile Hamburger -->
            <div class="flex items-center gap-2 sm:gap-6 shrink-0">
                <!-- Hamburger Button (Mobile) -->
                <button 
                    onclick="toggleMobileDrawer()" 
                    id="mobileDrawerBtn" 
                    class="sm:hidden p-2 rounded-xl bg-plum-900 border border-pink-500/20 text-pink-300 hover:text-white transition focus:outline-none"
                    aria-label="Buka Menu Navigasi"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <a href="{{ route('lumina.index') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-pink-500 via-rose-500 to-pink-400 flex items-center justify-center text-white text-sm font-black shadow-md shadow-pink-500/30 group-hover:scale-105 transition">
                        🌸
                    </div>
                    <span class="font-display font-extrabold text-lg sm:text-xl tracking-tight text-white group-hover:text-pink-300 transition">Lumina</span>
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

            <!-- Functional Search Form & Profile -->
            <div class="flex items-center gap-2 sm:gap-3 flex-1 sm:flex-none justify-end">
                <form id="globalSearchForm" action="{{ route('lumina.index') }}" method="GET" class="relative w-full max-w-[170px] sm:max-w-none sm:w-64">
                    <input 
                        type="search" 
                        name="q"
                        id="globalSearchInput" 
                        value="{{ request('q') }}"
                        placeholder="Cari buku / tokoh..." 
                        class="w-full bg-plum-900 border border-pink-500/20 rounded-full px-3 py-1.5 pl-8 pr-6 text-xs text-slate-200 placeholder-pink-300/40 focus:outline-none focus:border-pink-400 transition"
                        onkeyup="handleGlobalLiveSearch(event)"
                        autocomplete="off"
                    >
                    <button type="submit" class="absolute left-2.5 top-2 text-pink-400 text-xs hover:scale-110 transition" title="Mulai Cari">
                        🔍
                    </button>
                    <button 
                        type="button" 
                        id="clearSearchBtn" 
                        onclick="clearSearchInput()" 
                        class="absolute right-2.5 top-2 text-pink-300/60 hover:text-white text-xs {{ request('q') ? '' : 'hidden' }}"
                        title="Bersihkan Pencarian"
                    >
                        ✕
                    </button>
                </form>

                <!-- Clean User Avatar with Level -->
                <a href="{{ route('lumina.gamification') }}" class="flex items-center gap-2 pl-2 border-l border-white/10 hover:opacity-85 transition shrink-0" title="Profil Siswa">
                    <div class="relative">
                        <img 
                            src="https://api.dicebear.com/7.x/avataaars/svg?seed=Rayhan" 
                            alt="Rayhan Alfarizi" 
                            class="w-8 h-8 rounded-full bg-plum-850 border border-pink-400/50"
                            loading="lazy"
                            decoding="async"
                        >
                        <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-rose-500 text-white font-black text-[9px] rounded-full flex items-center justify-center shadow">5</span>
                    </div>
                    <span class="text-xs font-semibold text-pink-200 hidden md:inline">Rayhan</span>
                </a>
            </div>
        </div>

        <!-- Mobile Drawer Menu (Sliding from top when Hamburger clicked) -->
        <div id="mobileDrawerMenu" class="sm:hidden hidden border-t border-pink-500/15 bg-plum-950/98 backdrop-blur-2xl px-4 py-4 space-y-3 transition-all duration-200">
            <div class="space-y-1 text-xs font-medium">
                <a href="{{ route('lumina.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-plum-900 border border-pink-500/20 text-white font-bold">
                    <span class="flex items-center gap-2">📚 <span>Katalog Rak Buku</span></span>
                    <span class="text-pink-400">→</span>
                </a>
                <a href="{{ route('lumina.gamification') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-white/5">
                    <span class="flex items-center gap-2">🏆 <span>Piala & Fraksi Sekolah</span></span>
                    <span class="text-slate-400">→</span>
                </a>
                <button onclick="toggleMobileDrawer(); switchTab('ai');" class="w-full text-left flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-white/5">
                    <span class="flex items-center gap-2">🤖 <span>AI Matchmaker & Tokoh</span></span>
                    <span class="text-slate-400">→</span>
                </button>
            </div>

            <!-- Profile Info in Mobile Drawer -->
            <div class="pt-3 border-t border-white/10 flex items-center justify-between text-xs text-slate-300">
                <div class="flex items-center gap-2">
                    <span>👑 Rayhan Alfarizi (Level 5)</span>
                </div>
                <span class="font-bold text-pink-400 font-mono">1.450 XP</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-6xl mx-auto px-3 sm:px-6 py-5 sm:py-6 w-full">
        @yield('content')
    </main>

    <!-- Mobile Bottom App Dock Navigation (Sleek Spotify-style dock for phones) -->
    <nav class="sm:hidden fixed bottom-0 left-0 right-0 z-40 bg-plum-950/95 backdrop-blur-2xl border-t border-pink-500/20 px-2 py-1.5 flex items-center justify-around shadow-2xl">
        <a href="{{ route('lumina.index') }}" onclick="if(window.location.pathname === '/') { switchTab('katalog'); return false; }" class="flex flex-col items-center gap-0.5 text-slate-300 hover:text-pink-300 transition text-[10px] font-semibold py-1 px-3">
            <span class="text-base">📚</span>
            <span>Rak Buku</span>
        </a>
        <button onclick="if(window.location.pathname === '/') { switchTab('ai'); } else { window.location.href = '{{ route('lumina.index') }}#ai'; }" class="flex flex-col items-center gap-0.5 text-slate-300 hover:text-pink-300 transition text-[10px] font-semibold py-1 px-3">
            <span class="text-base">🤖</span>
            <span>Fitur AI</span>
        </button>
        <button onclick="if(window.location.pathname === '/') { switchTab('fraksi'); } else { window.location.href = '{{ route('lumina.index') }}#fraksi'; }" class="flex flex-col items-center gap-0.5 text-slate-300 hover:text-pink-300 transition text-[10px] font-semibold py-1 px-3">
            <span class="text-base">🏆</span>
            <span>Fraksi</span>
        </button>
        <a href="{{ route('lumina.gamification') }}" class="flex flex-col items-center gap-0.5 {{ request()->routeIs('lumina.gamification') ? 'text-pink-400 font-bold' : 'text-slate-300 hover:text-pink-300' }} transition text-[10px] font-semibold py-1 px-3">
            <span class="text-base">👑</span>
            <span>Profil XP</span>
        </a>
    </nav>

    <!-- Floating Audio Player Bar (Pinky Sleek - Positioned above mobile dock) -->
    <div id="globalAudioPlayer" class="fixed bottom-20 sm:bottom-4 left-1/2 -translate-x-1/2 w-[94%] max-w-xl z-50 hidden transition-all duration-300">
        <div class="bg-plum-900/95 backdrop-blur-xl border border-pink-500/30 rounded-2xl p-3 sm:p-3.5 shadow-2xl shadow-pink-950/60 flex items-center justify-between gap-3 text-white">
            <div class="flex items-center gap-3 min-w-0">
                <img id="audioPlayerCover" src="" alt="Cover Audiobook" class="w-10 h-10 rounded-lg object-cover bg-plum-800 shrink-0 border border-pink-400/30" loading="lazy" decoding="async">
                <div class="min-w-0">
                    <h4 id="audioPlayerTitle" class="text-xs sm:text-sm font-bold text-white truncate">Judul Buku</h4>
                    <p id="audioPlayerAuthor" class="text-[11px] text-pink-300 truncate">Penulis</p>
                </div>
            </div>

            <!-- Controls -->
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                <button onclick="cycleAudioSpeed()" id="audioSpeedBtn" class="px-2 py-1 rounded bg-plum-800 text-[10px] font-bold text-pink-300 hover:bg-plum-700 transition">
                    1.0x
                </button>
                <button onclick="toggleAudioSpeech()" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-gradient-to-tr from-pink-500 to-rose-500 text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow hover:scale-105 transition" aria-label="Putar / Jeda Audio">
                    <span id="audioPlayIcon">▶</span>
                </button>
                <button onclick="closeAudioPlayer()" class="text-pink-300/60 hover:text-white p-1 text-xs transition" aria-label="Tutup Player">
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

        // Hamburger Drawer Toggle
        function toggleMobileDrawer() {
            const drawer = document.getElementById('mobileDrawerMenu');
            if (drawer) {
                drawer.classList.toggle('hidden');
            }
        }

        // Live Real-time & Form Search
        function handleGlobalLiveSearch(e) {
            const q = e.target.value.toLowerCase().trim();
            const clearBtn = document.getElementById('clearSearchBtn');
            if (clearBtn) {
                if (q.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }

            let foundCount = 0;
            document.querySelectorAll('.book-card').forEach(card => {
                const title = (card.getAttribute('data-title') || '').toLowerCase();
                const author = (card.getAttribute('data-author') || '').toLowerCase();
                const category = (card.getAttribute('data-category') || '').toLowerCase();
                if (title.includes(q) || author.includes(q) || category.includes(q)) {
                    card.style.display = '';
                    foundCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Toggle No Results Placeholder
            const noResults = document.getElementById('noBooksFoundState');
            if (noResults) {
                if (foundCount === 0 && q.length > 0) {
                    noResults.classList.remove('hidden');
                    const qDisplay = document.getElementById('searchQueryDisplay');
                    if (qDisplay) qDisplay.textContent = q;
                } else {
                    noResults.classList.add('hidden');
                }
            }
        }

        function clearSearchInput() {
            const input = document.getElementById('globalSearchInput');
            if (input) {
                input.value = '';
                const clearBtn = document.getElementById('clearSearchBtn');
                if (clearBtn) clearBtn.classList.add('hidden');
                document.querySelectorAll('.book-card').forEach(card => card.style.display = '');
                const noResults = document.getElementById('noBooksFoundState');
                if (noResults) noResults.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
