<!DOCTYPE html>
<html lang="id" class="light" id="readerHtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ruang Baca: {{ $book->title }} - Lumina Mode Fokus</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400&family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        book: ['Merriweather', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Themes */
        .theme-light {
            --bg-page: #ffffff;
            --bg-nav: rgba(255, 255, 255, 0.95);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }
        .theme-sepia {
            --bg-page: #fbf0d9;
            --bg-nav: rgba(245, 230, 203, 0.95);
            --text-main: #3d3023;
            --text-muted: #796652;
            --border-color: #e6d5be;
        }
        .theme-dark {
            --bg-page: #0f172a;
            --bg-nav: rgba(15, 23, 42, 0.95);
            --text-main: #e2e8f0;
            --text-muted: #94a3b8;
            --border-color: #334155;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            transition: background-color 0.2s ease, color 0.2s ease;
        }
    </style>
</head>
<body class="theme-light min-h-screen font-sans">

    <!-- Top Reading Toolbar (Sticky) -->
    <header class="sticky top-0 z-40 backdrop-blur-xl border-b transition-colors" style="background-color: var(--bg-nav); border-color: var(--border-color);">
        <!-- Reading Progress Bar -->
        <div class="w-full bg-transparent h-1">
            <div id="readingProgressBar" class="h-1 bg-cyan-400 w-0 transition-all duration-150"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 h-16 flex items-center justify-between gap-4">
            <!-- Left: Back & Title -->
            <div class="flex items-center gap-3 min-w-0">
                <a href="{{ route('lumina.book', $book->id) }}" class="p-2 rounded-xl hover:bg-black/10 transition text-sm font-bold flex items-center gap-1.5" title="Kembali ke Info Buku">
                    <span>←</span>
                    <span class="hidden sm:inline">Info Buku</span>
                </a>
                <div class="min-w-0">
                    <h1 class="text-xs sm:text-sm font-display font-bold truncate">{{ $book->title }}</h1>
                    <p class="text-[11px] truncate opacity-70">{{ $book->author }}</p>
                </div>
            </div>

            <!-- Right: Controls (Theme, Font Size, TTS) -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <!-- Text-to-Speech Toggle -->
                <button onclick="toggleReaderTTS()" id="readerTtsBtn" class="px-3 py-1.5 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-bold text-xs flex items-center gap-1.5 shadow transition">
                    <span id="readerTtsIcon">🎧</span>
                    <span class="hidden sm:inline">Baca Suara</span>
                </button>

                <!-- Font Size Decrease/Increase -->
                <div class="flex items-center bg-black/10 rounded-xl p-0.5 border" style="border-color: var(--border-color);">
                    <button onclick="adjustFontSize(-2)" class="w-7 h-7 rounded-lg hover:bg-black/10 flex items-center justify-center text-xs font-bold font-mono transition" title="Kecilkan Font">A-</button>
                    <span id="fontSizeDisplay" class="text-[11px] font-mono px-1.5">18px</span>
                    <button onclick="adjustFontSize(2)" class="w-7 h-7 rounded-lg hover:bg-black/10 flex items-center justify-center text-xs font-bold font-mono transition" title="Besarkan Font">A+</button>
                </div>

                <!-- Theme Switcher -->
                <div class="flex items-center bg-black/10 rounded-xl p-1 border" style="border-color: var(--border-color);">
                    <button onclick="setReaderTheme('dark')" class="w-6 h-6 rounded-lg bg-navy-950 border border-slate-700 flex items-center justify-center text-[10px] text-white" title="Dark Midnight">🌙</button>
                    <button onclick="setReaderTheme('sepia')" class="w-6 h-6 rounded-lg bg-[#fbf0d9] border border-[#e6d5be] flex items-center justify-center text-[10px] text-amber-900 mx-1" title="Warm Sepia">📜</button>
                    <button onclick="setReaderTheme('light')" class="w-6 h-6 rounded-lg bg-white border border-slate-300 flex items-center justify-center text-[10px] text-slate-800" title="Clean Light">☀️</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Reading Body (Mode Fokus) -->
    <main class="max-w-3xl mx-auto px-6 py-12 space-y-8">
        <!-- Chapter Header -->
        <div class="text-center space-y-3 pb-8 border-b" style="border-color: var(--border-color);">
            <span class="px-3 py-1 rounded-full text-xs font-bold font-mono uppercase tracking-widest bg-cyan-500/20 text-cyan-400">
                Mode Fokus Membaca
            </span>
            <h2 class="font-display font-black text-2xl sm:text-3xl tracking-tight mt-2">
                {{ $book->title }}
            </h2>
            <p class="text-xs sm:text-sm opacity-75">
                Oleh {{ $book->author }} • Estimasi {{ $book->reading_time_minutes }} Menit
            </p>
        </div>

        <!-- Book Reading Content -->
        <article id="bookContentText" class="font-book leading-relaxed space-y-6 text-justify" style="font-size: 18px;">
            {!! nl2br(e($book->content)) !!}
        </article>

        <!-- Chapter Finish Box -->
        <div class="p-6 rounded-2xl border text-center space-y-3 mt-12" style="background-color: var(--bg-nav); border-color: var(--border-color);">
            <div class="text-3xl">🎉</div>
            <h4 class="font-display font-bold text-base">Selamat! Kamu Telah Menyelesaikan Bab Ini</h4>
            <p class="text-xs opacity-75 max-w-md mx-auto">
                Waktu membaca telah dicatat. Kamu mendapatkan <strong class="text-cyan-400">+50 XP</strong> untuk level membacamu dan menambah poin untuk Fraksi {{ $student['house'] }}!
            </p>
            <div class="flex items-center justify-center gap-3 pt-2">
                <a href="{{ route('lumina.book', $book->id) }}" class="px-5 py-2.5 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-bold text-xs shadow transition">
                    Kembali & Tulis Tanggapan
                </a>
                <a href="{{ route('lumina.gamification') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition">
                    Lihat Poin Fraksi
                </a>
            </div>
        </div>
    </main>

    <!-- ==================================================== -->
    <!-- FLOATING ROBOT AI ASSISTANT ("TANYA BUKU / KARAKTER")-->
    <!-- ==================================================== -->
    <div class="fixed bottom-6 right-6 z-50">
        <!-- Floating Bot Trigger Button -->
        <button onclick="toggleReaderAiDrawer()" class="relative group flex items-center gap-2 bg-gradient-to-r from-cyan-500 via-blue-600 to-purple-600 text-white font-bold p-3.5 sm:px-5 sm:py-3.5 rounded-full shadow-2xl transition-all hover:scale-110 active:scale-95 border-2 border-cyan-300">
            <span class="text-2xl animate-bounce">🤖</span>
            <span class="hidden sm:inline font-display text-xs font-black">Tanya Lumina AI</span>
            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-emerald-400 rounded-full border-2 border-navy-950 animate-ping"></span>
        </button>

        <!-- AI Assistant In-Reader Drawer Panel -->
        <div id="readerAiDrawer" class="hidden absolute bottom-16 right-0 w-80 sm:w-96 rounded-3xl p-4 shadow-2xl border border-cyan-500/40 bg-navy-950/95 backdrop-blur-2xl text-slate-200">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <div class="flex items-center gap-2.5">
                    <span class="text-xl">🤖</span>
                    <div>
                        <h4 class="font-display font-bold text-xs sm:text-sm text-white">Lumina Reading Companion</h4>
                        <p class="text-[10px] text-cyan-400">Pendamping baca interaktif cerdas</p>
                    </div>
                </div>
                <button onclick="toggleReaderAiDrawer()" class="text-slate-400 hover:text-white p-1 text-xs">✕</button>
            </div>

            <!-- Bot Messages Box -->
            <div id="readerAiChatBox" class="my-3 max-h-60 overflow-y-auto space-y-3 text-xs pr-1">
                <div class="p-3 rounded-xl bg-navy-900 border border-slate-800 text-slate-300">
                    Halo {{ $student['name'] }}! Sedang membaca <em>{{ $book->title }}</em>? Kamu bisa tanya arti kata sulit, rangkuman paragraf, atau tanya langsung tokoh buku ini!
                </div>
            </div>

            <!-- Quick Prompts Pills -->
            <div class="flex flex-wrap gap-1.5 pb-2">
                <button onclick="askReaderAi('Jelaskan inti pesan moral dari bab ini!')" class="px-2.5 py-1 rounded-lg bg-navy-800 hover:bg-cyan-950 border border-slate-700 text-[10px] text-cyan-300 transition">
                    💡 Pesan Moral?
                </button>
                <button onclick="askReaderAi('Siapa saja tokoh penting dalam bacaan ini?')" class="px-2.5 py-1 rounded-lg bg-navy-800 hover:bg-cyan-950 border border-slate-700 text-[10px] text-cyan-300 transition">
                    👥 Tokoh Utama?
                </button>
                <button onclick="askReaderAi('Bagaimana kaitan bacaan ini dengan kehidupan siswa?')" class="px-2.5 py-1 rounded-lg bg-navy-800 hover:bg-cyan-950 border border-slate-700 text-[10px] text-cyan-300 transition">
                    🏫 Kaitan Siswa?
                </button>
            </div>

            <!-- Chat Input -->
            <div class="flex items-center gap-2 pt-2 border-t border-slate-800">
                <input 
                    type="text" 
                    id="readerAiInput" 
                    placeholder="Tanya apapun tentang teks..." 
                    class="flex-1 bg-navy-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400"
                    onkeydown="if(event.key === 'Enter') sendReaderAiMessage()"
                >
                <button onclick="sendReaderAiMessage()" class="bg-cyan-500 hover:bg-cyan-400 text-navy-950 font-bold px-3 py-2 rounded-xl text-xs transition">
                    ➤
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts for Reader Interactivity -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentFontSize = 18;
        let isReaderTtsActive = false;
        let readerUtterance = null;

        // Reading Progress Tracking on Scroll
        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById('readingProgressBar').style.width = scrolled + "%";
        });

        // Font Size Adjuster
        function adjustFontSize(delta) {
            currentFontSize = Math.max(14, Math.min(26, currentFontSize + delta));
            document.getElementById('bookContentText').style.fontSize = currentFontSize + 'px';
            document.getElementById('fontSizeDisplay').textContent = currentFontSize + 'px';
        }

        // Theme Switcher
        function setReaderTheme(theme) {
            document.body.className = 'min-h-screen font-sans theme-' + theme;
        }

        // Floating Bot Drawer Toggle
        function toggleReaderAiDrawer() {
            const drawer = document.getElementById('readerAiDrawer');
            drawer.classList.toggle('hidden');
        }

        function askReaderAi(question) {
            document.getElementById('readerAiInput').value = question;
            sendReaderAiMessage();
        }

        async function sendReaderAiMessage() {
            const input = document.getElementById('readerAiInput');
            const question = input.value.trim();
            if (!question) return;

            const chatBox = document.getElementById('readerAiChatBox');

            // Append student message
            const userMsg = document.createElement('div');
            userMsg.className = 'p-2.5 rounded-xl bg-cyan-600 text-white text-right';
            userMsg.textContent = question;
            chatBox.appendChild(userMsg);
            input.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;

            // Generate AI Response
            const botMsg = document.createElement('div');
            botMsg.className = 'p-3 rounded-xl bg-navy-900 border border-slate-800 text-slate-300';
            botMsg.textContent = 'Menganalisis bab...';
            chatBox.appendChild(botMsg);
            chatBox.scrollTop = chatBox.scrollHeight;

            setTimeout(() => {
                if (question.includes('Pesan Moral') || question.includes('moral')) {
                    botMsg.textContent = '💡 Inti Moral Bab Ini: Kejujuran budi pekerti dan ketabahan menghadapi ketidakadilan jauh lebih mulia daripada sekadar memburu kedudukan atau pujian semu orang lain.';
                } else if (question.includes('Tokoh')) {
                    botMsg.textContent = '👥 Tokoh Utama: Minke (pemuda pribumi cerdas HBS) dan Nyai Ontosoroh (sosok ibu mandiri nan tangguh penegak martabat martabat keluarga).';
                } else {
                    botMsg.textContent = '✨ Wawasan untuk Siswa: Buku ini melatih kita untuk berpikir kritis, tidak mudah menerima keadaan tanpa perjuangan belajar, dan selalu menghargai kawan tanpa memandang latar belakang.';
                }
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 600);
        }

        // Reader Text-To-Speech
        function toggleReaderTTS() {
            if (!('speechSynthesis' in window)) {
                alert('Browser tidak mendukung Text to Speech');
                return;
            }

            if (isReaderTtsActive) {
                window.speechSynthesis.cancel();
                isReaderTtsActive = false;
                document.getElementById('readerTtsIcon').textContent = '🎧';
                document.getElementById('readerTtsBtn').classList.remove('bg-rose-500');
                document.getElementById('readerTtsBtn').classList.add('bg-cyan-500');
            } else {
                const text = document.getElementById('bookContentText').innerText;
                readerUtterance = new SpeechSynthesisUtterance(text);
                readerUtterance.lang = 'id-ID';
                readerUtterance.rate = 1.0;

                readerUtterance.onend = () => {
                    isReaderTtsActive = false;
                    document.getElementById('readerTtsIcon').textContent = '🎧';
                };

                window.speechSynthesis.speak(readerUtterance);
                isReaderTtsActive = true;
                document.getElementById('readerTtsIcon').textContent = '⏹️';
                document.getElementById('readerTtsBtn').classList.remove('bg-cyan-500');
                document.getElementById('readerTtsBtn').classList.add('bg-rose-500');
            }
        }
    </script>
</body>
</html>
