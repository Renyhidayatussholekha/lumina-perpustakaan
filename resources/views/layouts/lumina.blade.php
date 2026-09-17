<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Lumina - Smart Digital Library Sekolah')</title>

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            950: '#060911',
                            900: '#0a0f1d',
                            850: '#0f172a',
                            800: '#141e38',
                            700: '#1e294f',
                        },
                        cyan: {
                            400: '#22d3ee',
                            500: '#06b6d4',
                            glow: 'rgba(6, 182, 212, 0.4)',
                        },
                        lumina: {
                            amber: '#f59e0b',
                            orange: '#f97316',
                            purple: '#8b5cf6',
                            rose: '#f43f5e',
                            emerald: '#10b981',
                        }
                    },
                    boxShadow: {
                        'glow-cyan': '0 0 25px -5px rgba(6, 182, 212, 0.5)',
                        'glow-orange': '0 0 25px -5px rgba(249, 115, 22, 0.5)',
                        'glow-purple': '0 0 25px -5px rgba(139, 92, 246, 0.5)',
                        'card-hover': '0 15px 30px -5px rgba(0, 0, 0, 0.6), 0 0 20px -2px rgba(6, 182, 212, 0.25)',
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Smooth Scrollbar & Glassmorphism */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #060911;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e294f;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #06b6d4;
        }

        .glass-panel {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-nav {
            background: rgba(6, 9, 17, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .text-gradient-cyan {
            background: linear-gradient(135deg, #38bdf8 0%, #06b6d4 50%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-gold {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #f97316 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Horizontal Carousel Hide Native Scrollbar for clean Netflix look */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Card Scale Transitions */
        .book-card {
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .book-card:hover {
            transform: translateY(-8px) scale(1.03);
            z-index: 20;
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.05); }
        }
        .animate-pulse-glow {
            animation: pulseGlow 3s infinite ease-in-out;
        }
    </style>
</head>
<body class="bg-navy-950 text-slate-100 min-h-screen flex flex-col font-sans selection:bg-cyan-500 selection:text-navy-950 pb-24 md:pb-12">

    <!-- Top Navigation (Netflix / Spotify Style) -->
    <header class="sticky top-0 z-50 glass-nav transition-all duration-300" id="mainHeader">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Brand Logo -->
            <div class="flex items-center gap-8">
                <a href="{{ route('lumina.index') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-cyan-400 via-cyan-500 to-lumina-purple p-0.5 shadow-glow-cyan flex items-center justify-center group-hover:scale-105 transition-transform">
                        <div class="w-full h-full bg-navy-950 rounded-[10px] flex items-center justify-center">
                            <span class="text-2xl">✨</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-display font-extrabold text-2xl tracking-tight text-gradient-cyan">LUMINA</span>
                            <span class="px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 rounded-full">AI Library</span>
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium tracking-wide">Smart School Digital Library</p>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-1 text-sm font-semibold">
                    <a href="{{ route('lumina.index') }}" class="px-3.5 py-2 rounded-lg transition-colors {{ request()->routeIs('lumina.index') ? 'text-cyan-400 bg-cyan-500/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Beranda
                    </a>
                    <button onclick="openMatchmakerModal()" class="px-3.5 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 transition-colors flex items-center gap-1.5">
                        <span>🎯 AI Matchmaker</span>
                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                    </button>
                    <button onclick="openRoleplayModal(1)" class="px-3.5 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 transition-colors flex items-center gap-1.5">
                        <span>🎙️ Tanya Tokoh</span>
                        <span class="px-1.5 py-0.2 text-[9px] bg-lumina-purple/30 text-purple-300 rounded font-mono">Roleplay</span>
                    </button>
                    <a href="{{ route('lumina.gamification') }}" class="px-3.5 py-2 rounded-lg transition-colors {{ request()->routeIs('lumina.gamification') ? 'text-cyan-400 bg-cyan-500/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }} flex items-center gap-1.5">
                        <span>🏆 Fraksi & Piala</span>
                        <span class="px-1.5 py-0.2 text-[9px] bg-amber-500/30 text-amber-300 rounded font-mono">Live</span>
                    </a>
                </nav>
            </div>

            <!-- Search Bar & User Gamification Profile -->
            <div class="flex items-center gap-4">
                <!-- Search Input -->
                <div class="relative hidden sm:block w-64 lg:w-72">
                    <input 
                        type="text" 
                        id="globalSearchInput" 
                        placeholder="Cari buku, pengarang, tokoh..."
                        class="w-full bg-navy-900/80 border border-slate-700/60 rounded-full px-4 py-2 pl-10 text-xs text-slate-200 placeholder-slate-400 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition"
                        onkeyup="handleGlobalSearch(event)"
                    >
                    <span class="absolute left-3.5 top-2.5 text-slate-400 text-xs">🔍</span>
                </div>

                <!-- Quick AI Matchmaker Button -->
                <button onclick="openMatchmakerModal()" class="hidden sm:flex items-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-navy-950 font-bold px-3.5 py-2 rounded-full text-xs shadow-glow-cyan transition-all hover:scale-105 active:scale-95">
                    <span>✨ Kuis Minat</span>
                </button>

                <!-- Student Gamification Avatar & Level -->
                <a href="{{ route('lumina.gamification') }}" class="flex items-center gap-3 pl-2 sm:pl-3 border-l border-slate-800 hover:opacity-95 transition group" title="Lihat Profil & Lencana">
                    <div class="relative flex items-center justify-center">
                        <!-- Circular XP Ring SVG -->
                        <svg class="w-11 h-11 transform -rotate-90">
                            <circle cx="22" cy="22" r="18" stroke="#1e294f" stroke-width="3" fill="transparent"/>
                            <circle cx="22" cy="22" r="18" stroke="#06b6d4" stroke-width="3" stroke-dasharray="113" stroke-dashoffset="31" stroke-linecap="round" fill="transparent"/>
                        </svg>
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Rayhan" alt="Rayhan" class="w-8 h-8 rounded-full absolute object-cover bg-navy-800">
                        <span class="absolute -bottom-1 -right-1 bg-amber-500 text-navy-950 text-[9px] font-black px-1.5 py-0.2 rounded-full border border-navy-950 shadow">
                            Lv.5
                        </span>
                    </div>
                    <div class="hidden lg:block text-left">
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs font-bold text-slate-100 group-hover:text-cyan-400 transition">Rayhan</span>
                            <span class="text-xs">🦅</span>
                        </div>
                        <span class="text-[10px] text-cyan-400 font-semibold block">1.450 / 2.000 XP</span>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Dynamic Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global Floating Audiobook Player (TTS Engine) -->
    <div id="globalAudioPlayer" class="fixed bottom-0 md:bottom-3 left-0 md:left-1/2 md:-translate-x-1/2 w-full md:w-[92%] max-w-5xl z-40 hidden transition-all duration-300">
        <div class="glass-panel p-3.5 md:p-4 rounded-t-2xl md:rounded-2xl border border-cyan-500/30 shadow-2xl flex flex-col md:flex-row items-center justify-between gap-3 bg-navy-900/95 backdrop-blur-xl">
            <!-- Left Info -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative w-12 h-12 rounded-lg overflow-hidden shrink-0 border border-slate-700">
                    <img id="audioPlayerCover" src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=120&q=80" alt="Cover" class="w-full h-full object-cover">
                    <div id="audioWaveform" class="absolute inset-0 bg-cyan-950/60 flex items-center justify-center gap-0.5 opacity-0 transition-opacity">
                        <span class="w-1 h-3 bg-cyan-400 animate-pulse rounded"></span>
                        <span class="w-1 h-5 bg-cyan-400 animate-pulse rounded" style="animation-delay: 0.15s"></span>
                        <span class="w-1 h-2 bg-cyan-400 animate-pulse rounded" style="animation-delay: 0.3s"></span>
                    </div>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-1.5">
                        <span class="px-1.5 py-0.2 rounded bg-cyan-500/20 text-cyan-300 font-mono text-[9px] font-bold uppercase">Auto-Audiobook</span>
                        <span class="text-[10px] text-slate-400" id="audioVoiceSpeaker">Suara: AI Narator Indonesia</span>
                    </div>
                    <h4 id="audioPlayerTitle" class="text-xs sm:text-sm font-bold text-white truncate">Biografi Bung Karno: Penyambung Lidah Rakyat</h4>
                    <p id="audioPlayerAuthor" class="text-[11px] text-slate-400 truncate">Cindy Adams</p>
                </div>
            </div>

            <!-- Center Controls -->
            <div class="flex items-center gap-3 w-full md:w-auto justify-center">
                <!-- Speed Selector -->
                <button onclick="cycleAudioSpeed()" id="audioSpeedBtn" class="px-2 py-1 rounded bg-navy-800 hover:bg-slate-700 text-[10px] font-mono font-bold text-cyan-400 border border-slate-700 transition" title="Ganti Kecepatan Audio">
                    1.0x
                </button>

                <!-- Rewind 10s -->
                <button onclick="restartAudioSpeech()" class="w-8 h-8 rounded-full hover:bg-white/10 text-slate-300 flex items-center justify-center transition" title="Ulangi dari Awal">
                    ⏮️
                </button>

                <!-- Play/Pause Toggle -->
                <button onclick="toggleAudioSpeech()" id="audioPlayToggleBtn" class="w-11 h-11 rounded-full bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-black flex items-center justify-center text-lg shadow-glow-cyan transition hover:scale-105 active:scale-95">
                    <span id="audioPlayIcon">▶</span>
                </button>

                <!-- Stop Button -->
                <button onclick="stopAudioSpeech()" class="w-8 h-8 rounded-full hover:bg-white/10 text-slate-300 flex items-center justify-center transition" title="Hentikan Audio">
                    ⏹️
                </button>
            </div>

            <!-- Right Controls & Close -->
            <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                <span id="audioLiveStatus" class="text-[11px] text-cyan-400 font-medium hidden sm:inline-flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                    Membacakan Bab...
                </span>
                <button onclick="closeAudioPlayer()" class="text-slate-400 hover:text-white p-1 rounded transition" title="Tutup Pemutar">
                    ✕
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Navigation (App-Style) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-30 glass-nav border-t border-slate-800 px-6 py-2.5 flex items-center justify-between text-[11px] font-medium text-slate-400">
        <a href="{{ route('lumina.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('lumina.index') ? 'text-cyan-400 font-bold' : 'hover:text-slate-200' }}">
            <span class="text-lg">🏠</span>
            <span>Beranda</span>
        </a>
        <button onclick="openMatchmakerModal()" class="flex flex-col items-center gap-1 hover:text-slate-200">
            <span class="text-lg">✨</span>
            <span>AI Match</span>
        </button>
        <button onclick="openRoleplayModal(1)" class="flex flex-col items-center gap-1 hover:text-slate-200">
            <span class="text-lg">🎙️</span>
            <span>Tokoh AI</span>
        </button>
        <a href="{{ route('lumina.gamification') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('lumina.gamification') ? 'text-cyan-400 font-bold' : 'hover:text-slate-200' }}">
            <span class="text-lg">🏆</span>
            <span>Fraksi</span>
        </a>
    </nav>

    <!-- MODAL 1: AI Book Matchmaker (Kuis Minat Interaktif) -->
    <div id="matchmakerModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy-950/80 backdrop-blur-md hidden transition-all">
        <div class="glass-panel w-full max-w-xl rounded-3xl border border-cyan-500/30 p-6 sm:p-8 shadow-2xl bg-navy-900/95 relative overflow-hidden">
            <!-- Glow effect decoration -->
            <div class="absolute -right-16 -top-16 w-48 h-48 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-lumina-purple/20 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Header -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/20 border border-cyan-500/40 flex items-center justify-center text-xl">
                        🎯
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-lg text-white">AI Book Matchmaker</h3>
                        <p class="text-xs text-slate-400">Racik daftar bacaan harian yang sangat personal untukmu</p>
                    </div>
                </div>
                <button onclick="closeMatchmakerModal()" class="w-8 h-8 rounded-full hover:bg-slate-800 text-slate-400 hover:text-white flex items-center justify-center text-sm transition">
                    ✕
                </button>
            </div>

            <!-- Quiz Steps Container -->
            <div id="matchmakerQuizContent" class="mt-6 space-y-6">
                <!-- Question 1: Mood Saat Ini -->
                <div>
                    <label class="block text-xs font-bold text-cyan-400 uppercase tracking-wider mb-2">1. Apa suasana hatimu sekarang?</label>
                    <div class="grid grid-cols-2 gap-2.5">
                        <button type="button" onclick="selectQuizOption('mood', 'santai', this)" class="quiz-btn p-3 rounded-xl bg-navy-800 hover:bg-slate-700/80 border border-slate-700 text-left text-xs font-semibold flex items-center gap-2.5 transition active">
                            <span class="text-xl">☕</span>
                            <div>
                                <p class="text-white">Santai & Rileks</p>
                                <span class="text-[10px] text-slate-400 font-normal">Habis ujian / lelah</span>
                            </div>
                        </button>
                        <button type="button" onclick="selectQuizOption('mood', 'penasaran', this)" class="quiz-btn p-3 rounded-xl bg-navy-800 hover:bg-slate-700/80 border border-slate-700 text-left text-xs font-semibold flex items-center gap-2.5 transition">
                            <span class="text-xl">🔍</span>
                            <div>
                                <p class="text-white">Ingin Tahu Rahasia</p>
                                <span class="text-[10px] text-slate-400 font-normal">Eksplorasi mendalam</span>
                            </div>
                        </button>
                        <button type="button" onclick="selectQuizOption('mood', 'semangat', this)" class="quiz-btn p-3 rounded-xl bg-navy-800 hover:bg-slate-700/80 border border-slate-700 text-left text-xs font-semibold flex items-center gap-2.5 transition">
                            <span class="text-xl">🔥</span>
                            <div>
                                <p class="text-white">Membara & Ambisius</p>
                                <span class="text-[10px] text-slate-400 font-normal">Mencari motivasi</span>
                            </div>
                        </button>
                        <button type="button" onclick="selectQuizOption('mood', 'fokus', this)" class="quiz-btn p-3 rounded-xl bg-navy-800 hover:bg-slate-700/80 border border-slate-700 text-left text-xs font-semibold flex items-center gap-2.5 transition">
                            <span class="text-xl">🧠</span>
                            <div>
                                <p class="text-white">Fokus Mendalam</p>
                                <span class="text-[10px] text-slate-400 font-normal">Belajar logika & konsep</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Question 2: Minat Topik -->
                <div>
                    <label class="block text-xs font-bold text-cyan-400 uppercase tracking-wider mb-2">2. Tema yang paling memikatmu?</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <button type="button" onclick="selectQuizOption('interest', 'sejarah', this)" class="quiz-btn p-2.5 rounded-xl bg-navy-800 hover:bg-slate-700/80 border border-slate-700 text-left text-xs font-semibold flex items-center gap-2 transition active">
                            <span>🏛️</span>
                            <span class="text-white">Sejarah & Tokoh</span>
                        </button>
                        <button type="button" onclick="selectQuizOption('interest', 'sains', this)" class="quiz-btn p-2.5 rounded-xl bg-navy-800 hover:bg-slate-700/80 border border-slate-700 text-left text-xs font-semibold flex items-center gap-2 transition">
                            <span>🚀</span>
                            <span class="text-white">Sains & Kosmos</span>
                        </button>
                        <button type="button" onclick="selectQuizOption('interest', 'santai', this)" class="quiz-btn p-2.5 rounded-xl bg-navy-800 hover:bg-slate-700/80 border border-slate-700 text-left text-xs font-semibold flex items-center gap-2 transition">
                            <span>🌿</span>
                            <span class="text-white">Stoisisme & Jiwa</span>
                        </button>
                        <button type="button" onclick="selectQuizOption('interest', 'fiksi', this)" class="quiz-btn p-2.5 rounded-xl bg-navy-800 hover:bg-slate-700/80 border border-slate-700 text-left text-xs font-semibold flex items-center gap-2 transition">
                            <span>📖</span>
                            <span class="text-white">Sastra & Epik</span>
                        </button>
                        <button type="button" onclick="selectQuizOption('interest', 'lingkungan', this)" class="quiz-btn p-2.5 rounded-xl bg-navy-800 hover:bg-slate-700/80 border border-slate-700 text-left text-xs font-semibold flex items-center gap-2 transition">
                            <span>🍃</span>
                            <span class="text-white">Hutan & Ekologi</span>
                        </button>
                        <button type="button" onclick="selectQuizOption('interest', 'teknologi', this)" class="quiz-btn p-2.5 rounded-xl bg-navy-800 hover:bg-slate-700/80 border border-slate-700 text-left text-xs font-semibold flex items-center gap-2 transition">
                            <span>🤖</span>
                            <span class="text-white">AI & Coding</span>
                        </button>
                    </div>
                </div>

                <!-- Question 3: Durasi Target -->
                <div>
                    <label class="block text-xs font-bold text-cyan-400 uppercase tracking-wider mb-2">3. Waktu luang membacamu hari ini?</label>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="selectQuizOption('duration', 15, this)" class="quiz-btn flex-1 py-2.5 rounded-xl bg-navy-800 border border-slate-700 text-center text-xs font-bold text-white transition">
                            ⏱️ 15 Menit
                        </button>
                        <button type="button" onclick="selectQuizOption('duration', 30, this)" class="quiz-btn flex-1 py-2.5 rounded-xl bg-navy-800 border border-slate-700 text-center text-xs font-bold text-white transition active">
                            ⏱️ 30 Menit
                        </button>
                        <button type="button" onclick="selectQuizOption('duration', 45, this)" class="quiz-btn flex-1 py-2.5 rounded-xl bg-navy-800 border border-slate-700 text-center text-xs font-bold text-white transition">
                            ⏱️ 45+ Menit
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button onclick="submitMatchmakerQuiz()" id="submitQuizBtn" class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-navy-950 font-black py-3 rounded-xl text-sm shadow-glow-cyan flex items-center justify-center gap-2 transition-all hover:scale-[1.02] active:scale-95">
                    <span>✨ Racik Rekomendasi Bacaan AI</span>
                </button>
            </div>

            <!-- Loading State -->
            <div id="matchmakerLoading" class="hidden py-12 text-center">
                <div class="w-14 h-14 mx-auto mb-4 border-4 border-cyan-500/20 border-t-cyan-400 rounded-full animate-spin"></div>
                <h4 class="font-display font-bold text-white text-base">AI Lumina Sedang Menganalisis Minatmu...</h4>
                <p class="text-xs text-slate-400 mt-1">Mencocokkan profil psikologis dengan 500+ bab buku digital perpustakaan</p>
            </div>

            <!-- Result State -->
            <div id="matchmakerResult" class="hidden space-y-4">
                <div class="p-3.5 rounded-xl bg-cyan-950/40 border border-cyan-500/30 text-xs">
                    <span class="font-bold text-cyan-300">💡 Analisis AI Lumina:</span>
                    <p id="matchmakerAnalysisText" class="text-slate-300 mt-1"></p>
                </div>

                <div id="matchmakerBooksList" class="space-y-3 max-h-80 overflow-y-auto pr-1">
                    <!-- Dynamic Matched Cards injected here -->
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button onclick="resetMatchmakerQuiz()" class="flex-1 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-slate-300 transition">
                        🔄 Ulangi Kuis
                    </button>
                    <button onclick="closeMatchmakerModal()" class="flex-1 py-2.5 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-navy-950 text-xs font-bold transition">
                        ✓ Simpan ke Koleksiku
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 2: Tanya Tokoh Buku (Roleplay AI Modal) -->
    <div id="roleplayModal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-navy-950/85 backdrop-blur-md hidden transition-all">
        <div class="glass-panel w-full max-w-2xl rounded-3xl border border-lumina-purple/40 shadow-2xl bg-navy-900/98 flex flex-col h-[600px] max-h-[90vh] overflow-hidden relative">
            
            <!-- Modal Header -->
            <div class="p-4 sm:p-5 border-b border-slate-800 flex items-center justify-between bg-navy-950/60">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img id="roleplayCharAvatar" src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=120&q=80" alt="Avatar" class="w-12 h-12 rounded-xl object-cover border-2 border-cyan-400 shadow-glow-cyan">
                        <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full bg-emerald-500 border-2 border-navy-950" title="Online via AI"></span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 id="roleplayCharName" class="font-display font-bold text-base text-white">Ir. Soekarno</h3>
                            <span class="px-2 py-0.5 rounded-full bg-lumina-purple/20 text-purple-300 font-mono text-[10px] border border-purple-500/30">AI Persona</span>
                        </div>
                        <p id="roleplayCharRole" class="text-xs text-slate-400 line-clamp-1">Proklamator & Presiden RI Pertama</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <!-- Switch Character dropdown -->
                    <select id="roleplayCharSelect" onchange="changeRoleplayCharacter(this.value)" class="bg-navy-800 border border-slate-700 text-xs text-slate-200 rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-cyan-400">
                        <option value="1">Ir. Soekarno (Bung Karno)</option>
                        <option value="2">Minke (Raden Mas Tirto)</option>
                        <option value="3">Raden Ajeng Kartini</option>
                        <option value="4">Marcus Aurelius (Stoisisme)</option>
                    </select>
                    <button onclick="closeRoleplayModal()" class="w-8 h-8 rounded-full hover:bg-slate-800 text-slate-400 hover:text-white flex items-center justify-center transition">
                        ✕
                    </button>
                </div>
            </div>

            <!-- Chat History Area -->
            <div id="roleplayChatBox" class="flex-1 p-4 sm:p-5 overflow-y-auto space-y-4 text-xs sm:text-sm">
                <!-- Initial Greeting Bubble -->
                <div class="flex gap-3 items-start">
                    <img id="chatCharThumb" src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=80&q=80" class="w-8 h-8 rounded-lg object-cover shrink-0 mt-0.5">
                    <div class="bg-navy-800/90 border border-slate-700/70 rounded-2xl rounded-tl-sm p-3.5 max-w-[85%] text-slate-200 shadow">
                        <p id="roleplayGreetingText">Merdeka! Wahai anak mudaku pembawa panji masa depan bangsa! Ada kegelisahan apa di dadamu tentang negerimu yang indah ini? Tanyakanlah, mari kita berdiskusi!</p>
                        <span class="text-[10px] text-slate-500 mt-1 block">Tanya Tokoh AI • Respon Realtime</span>
                    </div>
                </div>
            </div>

            <!-- Pre-made Sample Questions Pill -->
            <div id="roleplaySampleQuestions" class="px-4 py-2 border-t border-slate-800 bg-navy-950/40 flex items-center gap-2 overflow-x-auto no-scrollbar">
                <span class="text-[10px] font-bold text-slate-400 shrink-0">Pertanyaan Pemantik:</span>
                <button onclick="askSampleQuestion(this)" class="px-3 py-1 rounded-full bg-navy-800 hover:bg-cyan-950 border border-slate-700 hover:border-cyan-500 text-[11px] text-slate-300 hover:text-cyan-300 shrink-0 transition">
                    Bagaimana cara menumbuhkan rasa percaya diri?
                </button>
                <button onclick="askSampleQuestion(this)" class="px-3 py-1 rounded-full bg-navy-800 hover:bg-cyan-950 border border-slate-700 hover:border-cyan-500 text-[11px] text-slate-300 hover:text-cyan-300 shrink-0 transition">
                    Apa nasihat untuk siswa sekolah zaman sekarang?
                </button>
            </div>

            <!-- Input Bar -->
            <div class="p-3 sm:p-4 border-t border-slate-800 bg-navy-950 flex items-center gap-2">
                <input 
                    type="text" 
                    id="roleplayInput" 
                    placeholder="Ketik pertanyaan untuk tokoh ini..." 
                    class="flex-1 bg-navy-900 border border-slate-700/80 rounded-xl px-4 py-2.5 text-xs sm:text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition"
                    onkeydown="if(event.key === 'Enter') sendRoleplayMessage()"
                >
                <button onclick="sendRoleplayMessage()" id="roleplaySendBtn" class="bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-bold px-4 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-1.5 transition active:scale-95 shadow-glow-cyan">
                    <span>Kirim</span>
                    <span>🚀</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container (for Gamification & Quest XP) -->
    <div id="toastContainer" class="fixed top-24 right-4 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- Footer -->
    <footer class="glass-nav border-t border-slate-800/80 py-8 px-4 mt-16 text-xs text-slate-400">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-lg">✨</span>
                <span class="font-display font-bold text-slate-200">LUMINA SMART LIBRARY</span>
                <span class="text-slate-600">|</span>
                <span>Perpustakaan Digital Sekolah Modern</span>
            </div>
            <div class="flex items-center gap-6">
                <span>⚡ Didukung AI Generatif & Web Speech TTS</span>
                <span>🛡️ Sistem 4 Fraksi Sekolah</span>
                <span class="text-cyan-400 font-semibold">Tahun Ajaran 2026/2027</span>
            </div>
        </div>
    </footer>

    <!-- Global Lumina Interactive Script -->
    <script>
        // Setup CSRF Token for all AJAX POST requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Quiz State
        let quizState = {
            mood: 'santai',
            interest: 'sejarah',
            duration: 30
        };

        function selectQuizOption(type, value, btn) {
            quizState[type] = value;
            const parent = btn.parentElement;
            parent.querySelectorAll('.quiz-btn').forEach(b => {
                b.classList.remove('border-cyan-400', 'bg-cyan-950/40', 'text-cyan-300');
                b.classList.add('border-slate-700', 'bg-navy-800');
            });
            btn.classList.add('border-cyan-400', 'bg-cyan-950/40', 'text-cyan-300');
            btn.classList.remove('border-slate-700', 'bg-navy-800');
        }

        function openMatchmakerModal() {
            document.getElementById('matchmakerModal').classList.remove('hidden');
        }
        function closeMatchmakerModal() {
            document.getElementById('matchmakerModal').classList.add('hidden');
        }

        async function submitMatchmakerQuiz() {
            document.getElementById('matchmakerQuizContent').classList.add('hidden');
            document.getElementById('matchmakerLoading').classList.remove('hidden');

            try {
                const response = await fetch('{{ route("lumina.api.matchmaker") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(quizState)
                });
                const data = await response.json();

                // Render result
                document.getElementById('matchmakerLoading').classList.add('hidden');
                document.getElementById('matchmakerResult').classList.remove('hidden');
                document.getElementById('matchmakerAnalysisText').textContent = data.ai_analysis;

                const list = document.getElementById('matchmakerBooksList');
                list.innerHTML = '';

                data.matched_books.forEach(b => {
                    const card = document.createElement('div');
                    card.className = 'p-3 rounded-xl bg-navy-800 border border-slate-700 hover:border-cyan-500 flex items-center justify-between gap-3 transition';
                    card.innerHTML = `
                        <div class="flex items-center gap-3 min-w-0">
                            <img src="${b.cover_url}" class="w-10 h-14 rounded-lg object-cover shrink-0">
                            <div class="min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <span class="px-1.5 py-0.2 rounded bg-cyan-500/20 text-cyan-300 font-mono text-[9px] font-bold">${b.match_score}% Match</span>
                                    <span class="text-[10px] text-slate-400">⏱️ ${b.reading_time_minutes} mnt</span>
                                </div>
                                <h5 class="text-xs font-bold text-white truncate">${b.title}</h5>
                                <p class="text-[11px] text-slate-400 truncate">${b.ai_highlight}</p>
                            </div>
                        </div>
                        <a href="/buku/${b.id}" class="px-3 py-1.5 rounded-lg bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-bold text-xs shrink-0 transition">
                            Buka
                        </a>
                    `;
                    list.appendChild(card);
                });

                showToast('✨ Rekomendasi Berhasil!', 'AI telah meracik ' + data.matched_books.length + ' buku terbaik untukmu!', 'cyan');
            } catch (err) {
                console.error(err);
                document.getElementById('matchmakerLoading').classList.add('hidden');
                document.getElementById('matchmakerQuizContent').classList.remove('hidden');
                alert('Gagal mengambil rekomendasi AI');
            }
        }

        function resetMatchmakerQuiz() {
            document.getElementById('matchmakerResult').classList.add('hidden');
            document.getElementById('matchmakerQuizContent').classList.remove('hidden');
        }

        // ==========================================
        // TANYA TOKOH BUKU (ROLEPLAY AI SYSTEM)
        // ==========================================
        const charactersData = {
            1: {
                name: 'Ir. Soekarno (Bung Karno)',
                role: 'Proklamator & Presiden Pertama Republik Indonesia',
                avatar: 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=200&q=80',
                greeting: 'Merdeka! Wahai anak mudaku pembawa panji masa depan bangsa! Ada kegelisahan apa di dadamu tentang negerimu yang indah ini? Tanyakanlah, mari kita berdiskusi!',
                questions: ['Bagaimana cara menumbuhkan percaya diri?', 'Apa pesan Bung Karno untuk siswa?', 'Bagaimana menjaga persatuan bangsa?']
            },
            2: {
                name: 'Minke (Raden Mas Tirto)',
                role: 'Pena Perlawanan & Pemuda Pribumi Terpelajar HBS',
                avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
                greeting: 'Salam kawan sebayaku. Di zaman serba canggihmu sekarang, apakah pena dan tulisanmu masih tajam membela yang lemah? Apa yang ingin kau diskusikan bersamaku?',
                questions: ['Mengapa menulis begitu penting?', 'Pelajaran apa yang kau dapat dari Nyai Ontosoroh?', 'Bagaimana agar berbuat adil sejak dalam pikiran?']
            },
            3: {
                name: 'R.A. Kartini',
                role: 'Pelopor Emansipasi & Pencerahan Pendidikan Putri',
                avatar: 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&w=200&q=80',
                greeting: 'Salam hangat dan kasih, saudaraku. Betapa bersyukurnya aku melihatmu hari ini bisa membaca dan menuntut ilmu dengan bebas. Cita-cita apa yang sedang kau rajut di hatimu?',
                questions: ['Apa rahasia tetap optimis saat dipingit?', 'Pentingnya pendidikan bagi kemajuan perempuan?', 'Pesan Ibu Kartini untuk generasi muda hari ini?']
            },
            4: {
                name: 'Marcus Aurelius',
                role: 'Kaisar Romawi & Filsuf Stoa Pengendali Diri',
                avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
                greeting: 'Ketenangan menyertaimu, sobat muda. Pikiranmu adalah benteng terkokohmu. Masalah apa yang sedang mengusik ketenangan batinmu hari ini? Mari kita selidiki dengan akal sehat.',
                questions: ['Bagaimana cara mengatasi overthinking ujian?', 'Bagaimana mengabaikan hinaan orang lain?', 'Apa rahasia fokus belajar seharian?']
            }
        };

        let currentCharacterId = 1;

        function openRoleplayModal(characterId = 1) {
            currentCharacterId = characterId;
            const char = charactersData[characterId] || charactersData[1];

            document.getElementById('roleplayCharSelect').value = characterId;
            document.getElementById('roleplayCharName').textContent = char.name;
            document.getElementById('roleplayCharRole').textContent = char.role;
            document.getElementById('roleplayCharAvatar').src = char.avatar;
            document.getElementById('chatCharThumb').src = char.avatar;
            document.getElementById('roleplayGreetingText').textContent = char.greeting;

            // Render sample questions
            const pillsContainer = document.getElementById('roleplaySampleQuestions');
            pillsContainer.innerHTML = '<span class="text-[10px] font-bold text-slate-400 shrink-0">Pertanyaan Pemantik:</span>';
            char.questions.forEach(q => {
                const b = document.createElement('button');
                b.className = 'px-3 py-1 rounded-full bg-navy-800 hover:bg-cyan-950 border border-slate-700 hover:border-cyan-500 text-[11px] text-slate-300 hover:text-cyan-300 shrink-0 transition';
                b.textContent = q;
                b.onclick = () => askSampleQuestion(b);
                pillsContainer.appendChild(b);
            });

            document.getElementById('roleplayModal').classList.remove('hidden');
        }

        function closeRoleplayModal() {
            document.getElementById('roleplayModal').classList.add('hidden');
        }

        function changeRoleplayCharacter(charId) {
            openRoleplayModal(charId);
        }

        function askSampleQuestion(btn) {
            const input = document.getElementById('roleplayInput');
            input.value = btn.textContent.trim();
            sendRoleplayMessage();
        }

        async function sendRoleplayMessage() {
            const input = document.getElementById('roleplayInput');
            const message = input.value.trim();
            if (!message) return;

            const chatBox = document.getElementById('roleplayChatBox');

            // Append Student Bubble
            const studentBubble = document.createElement('div');
            studentBubble.className = 'flex gap-3 items-start justify-end';
            studentBubble.innerHTML = `
                <div class="bg-cyan-600 text-white rounded-2xl rounded-tr-sm p-3.5 max-w-[85%] shadow">
                    <p>${message}</p>
                    <span class="text-[10px] text-cyan-200 mt-1 block text-right">Kamu • Siswa Lumina</span>
                </div>
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Rayhan" class="w-8 h-8 rounded-lg object-cover shrink-0 mt-0.5">
            `;
            chatBox.appendChild(studentBubble);
            input.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;

            // Typing Indicator
            const typingBubble = document.createElement('div');
            typingBubble.id = 'roleplayTypingIndicator';
            typingBubble.className = 'flex gap-3 items-start';
            const char = charactersData[currentCharacterId];
            typingBubble.innerHTML = `
                <img src="${char.avatar}" class="w-8 h-8 rounded-lg object-cover shrink-0 mt-0.5">
                <div class="bg-navy-800 border border-slate-700 rounded-2xl rounded-tl-sm p-3 max-w-[85%] text-slate-400 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                    <span class="text-xs font-mono">${char.name} sedang merespon...</span>
                </div>
            `;
            chatBox.appendChild(typingBubble);
            chatBox.scrollTop = chatBox.scrollHeight;

            try {
                const response = await fetch('{{ route("lumina.api.roleplay") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        character_id: currentCharacterId,
                        message: message
                    })
                });
                const data = await response.json();

                typingBubble.remove();

                // Append AI Response Bubble
                const aiBubble = document.createElement('div');
                aiBubble.className = 'flex gap-3 items-start';
                aiBubble.innerHTML = `
                    <img src="${char.avatar}" class="w-8 h-8 rounded-lg object-cover shrink-0 mt-0.5">
                    <div class="bg-navy-800/90 border border-slate-700/70 rounded-2xl rounded-tl-sm p-3.5 max-w-[85%] text-slate-200 shadow">
                        <p class="leading-relaxed">${data.reply}</p>
                        <div class="flex items-center justify-between mt-2 pt-1.5 border-t border-slate-700/50 text-[10px] text-slate-400">
                            <span class="font-bold text-cyan-400">${data.character_name}</span>
                            <button onclick="readAloudText('${data.reply.replace(/'/g, "\\'")}')" class="hover:text-cyan-300 flex items-center gap-1">
                                🔊 Dengarkan Suara
                            </button>
                        </div>
                    </div>
                `;
                chatBox.appendChild(aiBubble);
                chatBox.scrollTop = chatBox.scrollHeight;

                showToast('💬 Wawancara AI Selesai!', '+25 XP berhasil didapatkan!', 'purple');
            } catch (err) {
                console.error(err);
                typingBubble.remove();
                alert('Gagal menghubungi tokoh AI');
            }
        }

        // ==========================================
        // AUTO-AUDIOBOOK TEXT-TO-SPEECH ENGINE (TTS)
        // ==========================================
        let currentUtterance = null;
        let audioSpeed = 1.0;
        let isSpeaking = false;
        let activeAudioBook = {
            title: 'Biografi Bung Karno: Penyambung Lidah Rakyat',
            author: 'Cindy Adams',
            cover: 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=120&q=80',
            text: 'Bung Karno berkata: Beri aku seribu orang tua, niscaya akan kucabut Semeru dari akarnya. Beri aku sepuluh pemuda, niscaya akan kuguncangkan dunia! Kemerdekaan bukanlah tujuan akhir, melainkan jembatan emas menuju kecerdasan dan martabat luhur seluruh bangsa Indonesia.'
        };

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

                // Try to find Indonesian voice
                const voices = window.speechSynthesis.getVoices();
                const idVoice = voices.find(v => v.lang.includes('id') || v.lang.includes('ID'));
                if (idVoice) {
                    currentUtterance.voice = idVoice;
                    document.getElementById('audioVoiceSpeaker').textContent = 'Suara: ' + idVoice.name;
                }

                currentUtterance.onstart = () => {
                    isSpeaking = true;
                    document.getElementById('audioPlayIcon').textContent = '⏸';
                    document.getElementById('audioWaveform').classList.remove('opacity-0');
                    document.getElementById('audioLiveStatus').classList.remove('hidden');
                };

                currentUtterance.onend = () => {
                    isSpeaking = false;
                    document.getElementById('audioPlayIcon').textContent = '▶';
                    document.getElementById('audioWaveform').classList.add('opacity-0');
                    document.getElementById('audioLiveStatus').classList.add('hidden');
                    showToast('🎧 Selesai Mendengar Bab!', '+50 XP Jam Baca Ditambahkan!', 'orange');
                };

                currentUtterance.onerror = () => {
                    isSpeaking = false;
                    document.getElementById('audioPlayIcon').textContent = '▶';
                    document.getElementById('audioWaveform').classList.add('opacity-0');
                };

                window.speechSynthesis.speak(currentUtterance);
            } else {
                alert('Browser Anda belum mendukung Web Speech API');
            }
        }

        function toggleAudioSpeech() {
            if (!('speechSynthesis' in window)) return;

            if (window.speechSynthesis.speaking) {
                if (window.speechSynthesis.paused) {
                    window.speechSynthesis.resume();
                    document.getElementById('audioPlayIcon').textContent = '⏸';
                    document.getElementById('audioWaveform').classList.remove('opacity-0');
                } else {
                    window.speechSynthesis.pause();
                    document.getElementById('audioPlayIcon').textContent = '▶';
                    document.getElementById('audioWaveform').classList.add('opacity-0');
                }
            } else {
                playAudioSpeech(activeAudioBook.text);
            }
        }

        function stopAudioSpeech() {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                document.getElementById('audioPlayIcon').textContent = '▶';
                document.getElementById('audioWaveform').classList.add('opacity-0');
                document.getElementById('audioLiveStatus').classList.add('hidden');
            }
        }

        function restartAudioSpeech() {
            stopAudioSpeech();
            playAudioSpeech(activeAudioBook.text);
        }

        function cycleAudioSpeed() {
            const speeds = [0.8, 1.0, 1.25, 1.5];
            let nextIndex = (speeds.indexOf(audioSpeed) + 1) % speeds.length;
            audioSpeed = speeds[nextIndex];
            document.getElementById('audioSpeedBtn').textContent = audioSpeed.toFixed(1) + 'x';
            if (window.speechSynthesis.speaking) {
                restartAudioSpeech();
            }
        }

        function closeAudioPlayer() {
            stopAudioSpeech();
            document.getElementById('globalAudioPlayer').classList.add('hidden');
        }

        function readAloudText(text) {
            playAudioSpeech(text);
        }

        // ==========================================
        // TOAST NOTIFICATIONS
        // ==========================================
        function showToast(title, subtitle, color = 'cyan') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            const colorClasses = {
                cyan: 'border-cyan-400 bg-cyan-950/95 text-cyan-200',
                orange: 'border-orange-400 bg-orange-950/95 text-orange-200',
                purple: 'border-purple-400 bg-purple-950/95 text-purple-200',
                emerald: 'border-emerald-400 bg-emerald-950/95 text-emerald-200',
            }[color] || 'border-cyan-400 bg-cyan-950/95 text-cyan-200';

            toast.className = `p-3.5 rounded-2xl border shadow-2xl backdrop-blur-lg flex items-center gap-3 transition-all duration-300 transform translate-x-12 opacity-0 pointer-events-auto ${colorClasses}`;
            toast.innerHTML = `
                <div class="text-xl">🏆</div>
                <div>
                    <h5 class="font-display font-bold text-xs text-white">${title}</h5>
                    <p class="text-[11px] opacity-90">${subtitle}</p>
                </div>
            `;
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-x-12', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('translate-x-12', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        // Search Filter for Client Side
        function handleGlobalSearch(e) {
            const q = e.target.value.toLowerCase();
            document.querySelectorAll('.book-card').forEach(card => {
                const title = (card.getAttribute('data-title') || '').toLowerCase();
                const author = (card.getAttribute('data-author') || '').toLowerCase();
                const category = (card.getAttribute('data-category') || '').toLowerCase();
                if (title.includes(q) || author.includes(q) || category.includes(q)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
