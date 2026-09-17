<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Book;
use App\Models\BookCharacter;
use App\Models\Discussion;
use App\Models\House;
use App\Models\Quest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LuminaController extends Controller
{
    /**
     * Dummy profile siswa aktif untuk demo gamifikasi
     */
    private function getActiveStudent(): array
    {
        return [
            'name' => 'Rayhan Alfarizi',
            'grade' => 'Kelas 11 IPA 2',
            'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Rayhan',
            'house' => 'Garuda Cendekia',
            'house_color' => '#06b6d4',
            'house_emblem' => '🦅',
            'level' => 5,
            'level_title' => 'Kutu Buku Elite',
            'xp_current' => 1450,
            'xp_target' => 2000,
            'reading_minutes' => 1045,
            'streak_days' => 7,
            'books_finished' => 14,
        ];
    }

    /**
     * Dashboard Netflix-Style Lumina
     */
    public function index(): View
    {
        $featuredBook = Book::where('is_featured', true)->first() ?? Book::first();
        $allBooks = Book::with('characters')->get();

        $rows = [
            [
                'title' => 'Rekomendasi Spesial AI Untukmu',
                'badge' => '🤖 AI Curated',
                'subtitle' => 'Disesuaikan dengan riwayat bacamu dan minat sains',
                'books' => $allBooks->whereIn('id', [1, 2, 4, 6])->values(),
            ],
            [
                'title' => 'Trending di Kelas 10-12',
                'badge' => '🔥 Paling Banyak Dibaca',
                'subtitle' => 'Buku-buku yang sedang ramai didiskusikan pekan ini',
                'books' => $allBooks->whereIn('id', [2, 5, 8, 3])->values(),
            ],
            [
                'title' => 'Sastra Nusantara & Perjalanan Tokoh Bangsa',
                'badge' => '🇮🇩 Sejarah & Budaya',
                'subtitle' => 'Kenali pemikiran pendiri bangsa dan mahakarya sastra',
                'books' => $allBooks->whereIn('id', [1, 2, 3, 5])->values(),
            ],
            [
                'title' => 'Sains Masa Depan & Penjaga Bumi',
                'badge' => '🔬 Eksplorasi & Ekologi',
                'subtitle' => 'Jelajahi misteri alam semesta, AI, dan kelestarian hayati',
                'books' => $allBooks->whereIn('id', [6, 7, 8, 4])->values(),
            ],
        ];

        $houses = House::orderBy('total_points', 'desc')->get();
        $quests = Quest::take(3)->get();
        $characters = BookCharacter::with('book')->get();
        $student = $this->getActiveStudent();

        return view('lumina.index', compact('featuredBook', 'allBooks', 'rows', 'houses', 'quests', 'characters', 'student'));
    }

    /**
     * Halaman Detail Buku & Klub Diskusi
     */
    public function showBook(int $id): View
    {
        $book = Book::with(['characters', 'discussions'])->findOrFail($id);
        $relatedBooks = Book::where('id', '!=', $id)->take(4)->get();
        $student = $this->getActiveStudent();

        return view('lumina.book', compact('book', 'relatedBooks', 'student'));
    }

    /**
     * Ruang Baca Digital (Mode Fokus)
     */
    public function reader(int $id): View
    {
        $book = Book::with('characters')->findOrFail($id);
        $student = $this->getActiveStudent();

        return view('lumina.reader', compact('book', 'student'));
    }

    /**
     * Halaman Gamifikasi & Profil
     */
    public function gamification(): View
    {
        $houses = House::orderBy('total_points', 'desc')->get();
        $quests = Quest::all();
        $badges = Badge::all();
        $student = $this->getActiveStudent();

        // Top 10 Siswa Pembaca Sekolah
        $leaderboard = [
            ['rank' => 1, 'name' => 'Siti Nurhaliza', 'grade' => '12 IPS 1', 'house' => 'Komodo Wira', 'emblem' => '🐉', 'minutes' => 1840, 'points' => 920, 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Siti'],
            ['rank' => 2, 'name' => 'Rayhan Alfarizi (Kamu)', 'grade' => '11 IPA 2', 'house' => 'Garuda Cendekia', 'emblem' => '🦅', 'minutes' => 1045, 'points' => 740, 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Rayhan', 'is_me' => true],
            ['rank' => 3, 'name' => 'Aditya Pratama', 'grade' => '10 MIPA 3', 'house' => 'Elang Samudra', 'emblem' => '🌊', 'minutes' => 980, 'points' => 690, 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Aditya'],
            ['rank' => 4, 'name' => 'Karin Wijaya', 'grade' => '11 IPS 2', 'house' => 'Anoa Perkasa', 'emblem' => '🐂', 'minutes' => 920, 'points' => 650, 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Karin'],
            ['rank' => 5, 'name' => 'Dimas Anggara', 'grade' => '12 MIPA 1', 'house' => 'Garuda Cendekia', 'emblem' => '🦅', 'minutes' => 880, 'points' => 620, 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Dimas'],
            ['rank' => 6, 'name' => 'Zahra Amelia', 'grade' => '10 MIPA 1', 'house' => 'Komodo Wira', 'emblem' => '🐉', 'minutes' => 810, 'points' => 580, 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Zahra'],
            ['rank' => 7, 'name' => 'Rifqi Maulana', 'grade' => '11 MIPA 4', 'house' => 'Elang Samudra', 'emblem' => '🌊', 'minutes' => 790, 'points' => 540, 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Rifqi'],
            ['rank' => 8, 'name' => 'Bella Safitri', 'grade' => '10 IPS 3', 'house' => 'Anoa Perkasa', 'emblem' => '🐂', 'minutes' => 760, 'points' => 510, 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Bella'],
            ['rank' => 9, 'name' => 'Gilang Ramadhan', 'grade' => '12 IPS 3', 'house' => 'Garuda Cendekia', 'emblem' => '🦅', 'minutes' => 710, 'points' => 490, 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Gilang'],
            ['rank' => 10, 'name' => 'Amanda Putri', 'grade' => '11 MIPA 1', 'house' => 'Komodo Wira', 'emblem' => '🐉', 'minutes' => 670, 'points' => 460, 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Amanda'],
        ];

        return view('lumina.gamification', compact('houses', 'quests', 'badges', 'student', 'leaderboard'));
    }

    /**
     * API: AI Book Matchmaker (Kuis Minat Interaktif)
     */
    public function aiMatchmaker(Request $request): JsonResponse
    {
        $mood = $request->input('mood', 'santai');
        $interest = $request->input('interest', 'sejarah');
        $duration = (int) $request->input('duration', 30);

        $query = Book::with('characters');

        // Filter berdasarkan interest
        if ($interest === 'sejarah') {
            $books = $query->whereIn('category', ['Sejarah & Biografi', 'Sejarah & Pemikiran', 'Sastra & Fiksi'])->get();
            $reason = "Kamu sedang ingin menggali akar sejarah, kepemimpinan, dan nilai perjuangan pahlawan bangsa.";
        } elseif ($interest === 'sains') {
            $books = $query->whereIn('category', ['Sains & Teknologi', 'Lingkungan Hidup'])->get();
            $reason = "Logika analitismu sedang tinggi untuk mengeksplorasi rahasia kosmos dan teknologi masa depan.";
        } elseif ($interest === 'santai') {
            $books = $query->whereIn('category', ['Pengembangan Diri', 'Sastra & Fiksi'])->get();
            $reason = "Cocok untuk melepas penat setelah jam pelajaran dengan bacaan reflektif yang menenangkan jiwa.";
        } elseif ($interest === 'lingkungan') {
            $books = $query->whereIn('category', ['Lingkungan Hidup', 'Sains & Teknologi'])->get();
            $reason = "Semangat peduli bumi dan aksi nyata untuk kelestarian ekosistem alam nusantara.";
        } else {
            $books = $query->get();
            $reason = "Pilihan bacaan pilihan terbaik yang disesuaikan dengan profil belajarmu.";
        }

        if ($books->isEmpty()) {
            $books = Book::with('characters')->take(3)->get();
        }

        // Tambahkan skor kecocokan simulasi AI
        $results = $books->map(function ($book, $index) use ($duration) {
            $score = 98 - ($index * 4);
            $diff = abs($book->reading_time_minutes - $duration);
            if ($diff <= 10) {
                $score += 2;
            }
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'category' => $book->category,
                'cover_url' => $book->cover_url,
                'synopsis' => $book->synopsis,
                'reading_time_minutes' => $book->reading_time_minutes,
                'rating' => $book->rating,
                'match_score' => min(99, $score),
                'ai_highlight' => $book->ai_summary_1,
            ];
        });

        return response()->json([
            'status' => 'success',
            'ai_analysis' => $reason,
            'matched_books' => $results,
        ]);
    }

    /**
     * API: Tanya Tokoh Buku (Roleplay AI Chat)
     */
    public function roleplayChat(Request $request): JsonResponse
    {
        $characterId = $request->input('character_id');
        $userMessage = trim($request->input('message', ''));

        $character = BookCharacter::with('book')->find($characterId);

        if (!$character) {
            return response()->json([
                'status' => 'error',
                'reply' => 'Tokoh tidak ditemukan dalam pangkalan data Lumina.',
            ], 404);
        }

        $reply = $this->generateRoleplayResponse($character, $userMessage);

        return response()->json([
            'status' => 'success',
            'character_name' => $character->name,
            'role_title' => $character->role_title,
            'avatar' => $character->avatar,
            'reply' => $reply,
        ]);
    }

    /**
     * Mesin simulasi persona AI cerdas untuk karakter buku
     */
    private function generateRoleplayResponse(BookCharacter $character, string $prompt): string
    {
        $name = $character->name;
        $lower = strtolower($prompt);

        if (str_contains($name, 'Soekarno') || str_contains($name, 'Bung Karno')) {
            if (str_contains($lower, 'percaya diri') || str_contains($lower, 'takut') || str_contains($lower, 'ragu')) {
                return "Merdeka! Anak mudaku, ketakutan adalah hal yang manusiawi. Tetapi ingatlah: bangsa kita bukan bangsa tempe! Kita mewarisi darah para pelaut Sriwijaya dan pembangun Borobudur. Gantungkan cita-citamu setinggi langit! Jikalau engkau jatuh, engkau akan jatuh di antara bintang-bintang. Jadilah elang yang menantang badai, bukan ayam yang menciap di kolong lumbung!";
            }
            if (str_contains($lower, 'nasihat') || str_contains($lower, 'sekolah') || str_contains($lower, 'belajar')) {
                return "Belajarlah tanpa henti, anak mudaku! Di masa mudaku di HBS dan ITB Bandung, lilin kamarku tak pernah padam sebelum fajar menyapa karena membaca ratusan buku dunia. Buku adalah senjatamu. Jadikan sekolahmu laboratorium mencetak karakter, bukan sekadar memburu angka rapor!";
            }
            if (str_contains($lower, 'persatuan') || str_contains($lower, 'beda') || str_contains($lower, 'suku')) {
                return "Negara Republik Indonesia ini bukan milik sesuatu golongan, bukan milik sesuatu agama, bukan milik sesuatu suku, tetapi milik kita semua dari Sabang sampai Merauke! Jaga toleransi di sekolahmu, rangkul kawanmu yang berbeda keyakinan, karena dalam gotong royong itulah letak nyawa Indonesia!";
            }
            return "Pertanyaan yang bernas dari tunas muda bangsa! Selama dadamu masih berdegup dengan cinta tanah air dan akalmu haus akan ilmu pengetahuan, tidak ada kekuatan tirani mana pun di muka bumi yang sanggup merantai masa depanmu!";
        }

        if (str_contains($name, 'Kartini')) {
            if (str_contains($lower, 'optimis') || str_contains($lower, 'pingit') || str_contains($lower, 'sedih')) {
                return "Sahabat mudaku tercinta... Di masa pingitan empat dinding tebal itu, aku menyadari bahwa tubuhku boleh dikurung, tetapi jiwa dan pikiranku merdeka melintasi samudra. Ingatlah semboyanku: 'Aku Mau!'. Selama engkau masih memelihara api harapan di dalam dadamu, kegelapan tidak akan pernah mampu memadamkan cahayamu.";
            }
            if (str_contains($lower, 'perempuan') || str_contains($lower, 'pendidikan') || str_contains($lower, 'belajar')) {
                return "Pendidikan bagi seorang anak perempuan berarti mendidik sebuah peradaban. Ibu adalah pendidik pertama bagi anak-anaknya. Belajarlah setinggi mungkin, raihlah cita-citamu, dan jadilah perempuan yang berdaya, berbudi pekerti luhur, serta menebar kebaikan bagi nusa dan bangsa.";
            }
            return "Terima kasih atas pertanyanmu yang tulus. Jalan menuju kemajuan memang sering kali mendaki dan terjal, tetapi jangan pernah gentar. Habis gelap pasti terbitlah terang!";
        }

        if (str_contains($name, 'Minke')) {
            if (str_contains($lower, 'menulis') || str_contains($lower, 'buku') || str_contains($lower, 'pena')) {
                return "Kawan sebayaku, orang boleh pandai setinggi langit, tapi selama ia tidak menulis, ia akan hilang di dalam masyarakat dan dari sejarah. Menulis adalah bekerja untuk keabadian. Menulislah dengan kejujuran hati, meski kata-katamu terasa pahit bagi mereka yang gemar menindas!";
            }
            if (str_contains($lower, 'adil') || str_contains($lower, 'hukum') || str_contains($lower, 'teman')) {
                return "Pegang erat prinsip ini seumur hidupmu: seorang terpelajar harus sudah berbuat adil sejak dalam pikiran, apalagi dalam perbuatan. Jangan biarkan prasangka ras, suku, atau derajat sosial menumpulkan mata batinmu untuk melihat kebenaran sejati.";
            }
            return "Di tengah zaman yang terus berganti serba cepat ini, jaga integritas hatimu. Kekuatan terbesar manusia bukanlah pada senapan atau modal kekayaan, melainkan pada kemurnian akal budi dan tekad membela martabat sesama.";
        }

        if (str_contains($name, 'Marcus Aurelius')) {
            if (str_contains($lower, 'stres') || str_contains($lower, 'panik') || str_contains($lower, 'ujian') || str_contains($lower, 'cemas')) {
                return "Tarik nafas perlahan, sahabat muda. Dunia ini tidak memiliki kekuatan untuk mengacaukan batinmu; yang mengacaukannya adalah penilaianmu sendiri terhadap kejadian tersebut. Nilai ujian atau opini orang berada di luar kendalimu. Yang ada di bawah kendalimu adalah bagaimana caramu mempersiapkan diri dan bagaimana engkau merespons dengan bijaksana.";
            }
            if (str_contains($lower, 'marah') || str_contains($lower, 'kesal') || str_contains($lower, 'emosi')) {
                return "Bila engkau tersinggung oleh ketidaksopanan orang lain, segera berpalinglah pada dirimu sendiri dan tanyakan: kapan terakhir kali aku juga berbuat keliru? Membalas kebodohan dengan amarah hanya akan membuatmu menjadi cerminan dari hal yang kau benci.";
            }
            return "Fokuslah pada saat ini. Lakukan setiap tindakan dalam hidupmu—bahkan saat belajar di mejamu hari ini—seolah-olah itu adalah karya terbaik yang engkau persembahkan bagi kebajikan jiwamu.";
        }

        return "Salam dari alam literasi! Sebagai tokoh dalam buku ini, pesanku adalah selalulah membaca dengan kritis, resapi nilai-nilai kemanusiaan di dalamnya, dan jadikan ilmu pengetahuan sebagai pelita yang menerangi langkahmu di masa depan!";
    }

    /**
     * API: Tambah Komentar Diskusi Klub Buku
     */
    public function storeDiscussion(Request $request): JsonResponse
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'comment' => 'required|string|min:3',
        ]);

        $student = $this->getActiveStudent();

        $discussion = Discussion::create([
            'book_id' => $request->book_id,
            'user_name' => $student['name'],
            'user_avatar' => $student['avatar'],
            'user_house' => $student['house'],
            'comment' => $request->comment,
            'is_ai_prompt' => false,
            'likes_count' => 1,
        ]);

        // Beri tambahan 10 poin ke fraksi siswa!
        $house = House::where('name', $student['house'])->first();
        if ($house) {
            $house->increment('total_points', 10);
        }

        return response()->json([
            'status' => 'success',
            'discussion' => [
                'id' => $discussion->id,
                'user_name' => $discussion->user_name,
                'user_avatar' => $discussion->user_avatar,
                'user_house' => $discussion->user_house,
                'comment' => $discussion->comment,
                'likes_count' => $discussion->likes_count,
                'created_at' => 'Baru saja',
            ],
            'points_added' => 10,
            'house_name' => $student['house'],
        ]);
    }

    /**
     * API: Klaim Progres Quest Mingguan
     */
    public function claimQuest(Request $request): JsonResponse
    {
        $questId = $request->input('quest_id');
        $quest = Quest::find($questId);

        if (!$quest) {
            return response()->json(['status' => 'error', 'message' => 'Quest tidak ditemukan'], 404);
        }

        $quest->current_count = min($quest->target_count, $quest->current_count + 1);
        if ($quest->current_count >= $quest->target_count) {
            $quest->is_completed = true;
        }
        $quest->save();

        // Tambah poin ke fraksi
        $student = $this->getActiveStudent();
        $house = House::where('name', $student['house'])->first();
        if ($house) {
            $house->increment('total_points', $quest->xp_reward);
        }

        return response()->json([
            'status' => 'success',
            'quest' => $quest,
            'xp_earned' => $quest->xp_reward,
            'new_house_points' => $house ? $house->total_points : 0,
        ]);
    }
}
