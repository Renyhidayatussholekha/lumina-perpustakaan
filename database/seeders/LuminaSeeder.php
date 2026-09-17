<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Book;
use App\Models\BookCharacter;
use App\Models\Discussion;
use App\Models\House;
use App\Models\Quest;
use Illuminate\Database\Seeder;

class LuminaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fraksi Sekolah (Houses)
        $garuda = House::create([
            'name' => 'Garuda Cendekia',
            'slug' => 'garuda-cendekia',
            'emblem' => '🦅',
            'motto' => 'Ketinggian Pikir, Ketajaman Nalar',
            'color_hex' => '#06b6d4', // Cyan
            'total_points' => 3540,
            'member_count' => 128,
            'description' => 'Fraksi pemikir kritis, ilmuwan muda, dan penjelajah logika sains.',
        ]);

        $komodo = House::create([
            'name' => 'Komodo Wira',
            'slug' => 'komodo-wira',
            'emblem' => '🐉',
            'motto' => 'Bara Keberanian, Nyala Perubahan',
            'color_hex' => '#f43f5e', // Rose/Red
            'total_points' => 3680,
            'member_count' => 134,
            'description' => 'Fraksi pemberani, berjiwa petualang, dan penggerak aksi nyata sekolah.',
        ]);

        $anoa = House::create([
            'name' => 'Anoa Perkasa',
            'slug' => 'anoa-perkasa',
            'emblem' => '🐂',
            'motto' => 'Kokoh Berpijak, Abadi Berkarya',
            'color_hex' => '#10b981', // Emerald
            'total_points' => 3290,
            'member_count' => 115,
            'description' => 'Fraksi tekun yang memegang teguh nilai kearifan, sejarah, dan ketabahan.',
        ]);

        $elang = House::create([
            'name' => 'Elang Samudra',
            'slug' => 'elang-samudra',
            'emblem' => '🌊',
            'motto' => 'Melampaui Batas, Mengarungi Semesta',
            'color_hex' => '#8b5cf6', // Violet
            'total_points' => 3410,
            'member_count' => 121,
            'description' => 'Fraksi pencipta karya seni, sastra mendalam, filosofi, dan imajinasi bebas.',
        ]);

        // 2. Buku Katalog
        $buku1 = Book::create([
            'title' => 'Biografi Bung Karno: Penyambung Lidah Rakyat',
            'slug' => 'bung-karno-penyambung-lidah-rakyat',
            'author' => 'Cindy Adams',
            'category' => 'Sejarah & Biografi',
            'grade_level' => 'Kelas 10-12',
            'cover_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1461360370896-922624d12aa1?auto=format&fit=crop&w=1600&q=80',
            'synopsis' => 'Kisah otentik kehidupan sang Proklamator Republik Indonesia yang diceritakan langsung kepada jurnalis Amerika Cindy Adams. Menelusuri masa kanak-kanak di Blitar, masa studi di Bandung, pengasingan di Ende dan Bengkulu, hingga gelora detik-detik Proklamasi 17 Agustus 1945.',
            'ai_summary_1' => 'Gagasan besar persatuan bangsa di tengah ratusan suku & latar budaya yang heterogen.',
            'ai_summary_2' => 'Kekuatan orasi dan literasi sebagai senjata utama menggetarkan panggung diplomasi dunia.',
            'ai_summary_3' => 'Prinsip kemandirian nasional (Trisakti): Berdaulat, Berdikari, dan Berkepribadian.',
            'reading_time_minutes' => 45,
            'rating' => 5.0,
            'total_readers' => 482,
            'is_featured' => true,
            'trending_label' => '👑 Paling Populer Minggu Ini',
            'audio_text' => 'Bung Karno berkata: "Beri aku seribu orang tua, niscaya akan kucabut Semeru dari akarnya. Beri aku sepuluh pemuda, niscaya akan kuguncangkan dunia!" Dalam buku ini, kita diajak merasakan detak jantung revolusi Indonesia, di mana keberanian pemuda menjadi bara yang menerangi jalan kemerdekaan.',
            'content' => "Bab 1: Fajar di Tanah Jawa\n\nKetika fajar menyingsing di ufuk timur Surabaya pada tanggal 6 Juni 1901, seorang anak dilahirkan ke dunia. Sang ibu berbisik lembut, meramalkan bahwa putranya kelak akan menjadi pemimpin besar bangsanya...\n\n\"Engkau sedang memandangi fajar, anakku. Engkau kelak akan menjadi fajar bagi rakyatmu.\" Begitulah ibuku menyambut kelahiranku.\n\nAku dibesarkan dalam kesederhanaan, namun jiwaku disiram oleh kisah-kisah kepahlawanan pewayangan oleh kakekku. Di Bandung, saat menjadi mahasiswa teknik sipil, aku menyadari bahwa bangsa ini tidak hanya membutuhkan jembatan dari beton dan besi, melainkan jembatan emas menuju kemerdekaan yang bermartabat.\n\nKemerdekaan bukanlah tujuan akhir. Kemerdekaan adalah pintu gerbang menuju keadilan sosial, kecerdasan rakyat, dan martabat luhur bangsa Indonesia di mata peradaban dunia.",
        ]);

        $buku2 = Book::create([
            'title' => 'Bumi Manusia (Tetralogi Buru)',
            'slug' => 'bumi-manusia',
            'author' => 'Pramoedya Ananta Toer',
            'category' => 'Sastra & Fiksi',
            'grade_level' => 'Kelas 11-12',
            'cover_url' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=600&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&w=1600&q=80',
            'synopsis' => 'Kisah epik Minke, seorang pemuda pribumi terpelajar di H.B.S. Surabaya pada akhir abad ke-19, yang berani mendobrak belenggu feodalisme dan kolonialisme melalui tulisan-tulisannya yang tajam.',
            'ai_summary_1' => 'Perjuangan kesetaraan hak asasi manusia dan martabat kemanusiaan di atas hukum yang diskriminatif.',
            'ai_summary_2' => 'Ketokohan Nyai Ontosoroh sebagai prototipe perempuan tangguh dan mandiri tanpa tunduk pada nasib.',
            'ai_summary_3' => 'Pena dan kata-kata sebagai instrumen terkuat menyuarakan kebenaran.',
            'reading_time_minutes' => 50,
            'rating' => 4.9,
            'total_readers' => 395,
            'is_featured' => false,
            'trending_label' => '🔥 #1 Trending Sastra Nusantara',
            'audio_text' => 'Seorang terpelajar harus sudah berbuat adil sejak dalam pikiran, apalagi dalam perbuatan. Minke belajar bahwa ilmu pengetahuan modern di sekolah Eropa tidak ada gunanya jika kehilangan hati nurani dan empati terhadap sesama manusia yang tertindas.',
            'content' => "Bab 1: Suatu Hari di Wonokromo\n\nOrang memanggilku Minke. Namaku sendiri... sementara ini tak perlu kusebutkan. Bukan karena gila misteri, tetapi karena kisah ini bukan sekadar tentang aku, melainkan tentang zaman yang sedang berganti.\n\nIlmu pengetahuan Eropa telah membuka mataku pada keajaiban mesin, telegram, dan ilmu ukur. Namun di Hindia ini, warna kulit dan asal darah masih menentukan segalanya.\n\nDi Wonokromo, di rumah berdinding kayu jati yang megah namun penuh desas-desus, aku bertemu dengan dua manusia luar biasa: Annelies yang selembut embun pagi, dan ibunya, Nyai Ontosoroh. Seorang perempuan yang direnggut dari keluarganya, namun menolak hancur dan justru membangun imperium niaga dengan kecerdasan dan tekad bajanya sendiri.",
        ]);

        $buku3 = Book::create([
            'title' => 'Habis Gelap Terbitlah Terang',
            'slug' => 'habis-gelap-terbitlah-terang',
            'author' => 'Raden Ajeng Kartini',
            'category' => 'Sejarah & Pemikiran',
            'grade_level' => 'Semua Jenjang',
            'cover_url' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=600&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1600&q=80',
            'synopsis' => 'Kumpulan surat-surat monumental R.A. Kartini kepada sahabat-sahabat penanya di Belanda. Surat-surat ini menjadi manifesto pemikiran modern tentang emansipasi wanita, pentingnya pendidikan perempuan, dan cita-cita kebebasan batin.',
            'ai_summary_1' => 'Mendobrak tradisi pingitan yang mengekang hak belajar anak perempuan.',
            'ai_summary_2' => 'Pendidikan adalah kunci utama melahirkan generasi penerus bangsa yang berbudi luhur.',
            'ai_summary_3' => 'Harapan teguh bahwa setiap malam kelam pasti akan berganti dengan fajar yang gilang-gemilang.',
            'reading_time_minutes' => 35,
            'rating' => 4.9,
            'total_readers' => 310,
            'is_featured' => false,
            'trending_label' => '🌸 Inspirasi Pahlawan Bangsa',
            'audio_text' => 'Tahukah engkau semboyanku? "Aku mau!" Dua patah kata yang ringkas itu sudah beberapa kali mendukung dan membawa aku melintasi gunung keberatan dan kesusahan. Jangan pernah menyerah jika kamu masih ingin mencoba!',
            'content' => "Surat kepada Stella Zeehandelaar, Mei 1899\n\nSahabatku yang baik, Stella,\n\nDengan penuh semangat aku menyambut tangan persahabatan yang engkau ulurkan menyeberangi lautan. Di sini, di balik tembok-tembok tebal kabupaten yang memisahkanku dari dunia luas, anganku terbang bebas bersama burung-burung di angkasa.\n\nBanyak orang memandang wanita bumi putera hanya tercipta untuk patuh dan diam. Tetapi mengapa hati ini berdegup kencang ketika membaca tentang kemajuan dan ilmu pengetahuan? Aku ingin belajar! Aku ingin mendirikan sekolah untuk adik-adik perempuanku, agar mereka tidak hanya pandai memintal benang, tetapi juga pandai memintal cita-cita bagi negerinya.",
        ]);

        $buku4 = Book::create([
            'title' => 'Filosofi Teras: Stoisisme untuk Mental Juara',
            'slug' => 'filosofi-teras',
            'author' => 'Henry Manampiring',
            'category' => 'Pengembangan Diri',
            'grade_level' => 'Kelas 10-12',
            'cover_url' => 'https://images.unsplash.com/photo-1506880018603-83d5b814b5a6?auto=format&fit=crop&w=600&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1600&q=80',
            'synopsis' => 'Panduan praktis mengadopsi filsafat Stoa kuno ala Epictetus, Seneca, dan Marcus Aurelius untuk mengatasi stres belajar, overthinking ujian, serta kecemasan media sosial remaja masa kini.',
            'ai_summary_1' => 'Dikotomi Kendali: Fokus pada apa yang bisa kita kontrol (pikiran, aksi), abaikan sisanya.',
            'ai_summary_2' => 'Bukan peristiwa luar yang menyakiti kita, melainkan persepsi dan respon kita sendiri.',
            'ai_summary_3' => 'Membangun kedamaian batin (ataraxia) di tengah dunia yang bising dan penuh tuntutan.',
            'reading_time_minutes' => 30,
            'rating' => 4.8,
            'total_readers' => 520,
            'is_featured' => false,
            'trending_label' => '☕ Bacaan Santai Habis Ujian',
            'audio_text' => 'Kamu tidak bisa mengatur nilai apa yang guru berikan atau bagaimana temanmu bersikap, tetapi kamu punya kendali 100% atas caramu belajar dan caramu merespon. Itulah rahasia ketenangan seorang Stoik sejati.',
            'content' => "Bab 1: Membedakan Apa yang Ada di Bawah Kendalimu\n\nBayangkan kamu sedang mempersiapkan ujian semester yang paling menentukan. Kamu sudah belajar mati-matian berhari-hari. Namun di pagi hari ujian, listrik padam, printer macet, dan pengawasnya terkenal super galak.\n\nDalam kacamata Filosofi Teras (Stoisisme), dunia terbagi menjadi dua ranah mutlak:\n1. Hal-hal yang berada di bawah kendali kita (Internal): Usaha kita, persiapan kita, integritas kita, dan reaksi emosional kita.\n2. Hal-hal di luar kendali kita (Eksternal): Soal yang keluar di lembar ujian, cuaca hari ini, penilaian guru, dan opini orang lain.\n\nJika kamu menggantungkan ketenanganmu pada hal eksternal, kamu akan selalu hidup dalam kecemasan. Bebaskan dirimu!",
        ]);

        $buku5 = Book::create([
            'title' => 'Laskar Pelangi: Keajaiban Mimpi',
            'slug' => 'laskar-pelangi',
            'author' => 'Andrea Hirata',
            'category' => 'Sastra & Fiksi',
            'grade_level' => 'Semua Jenjang',
            'cover_url' => 'https://images.unsplash.com/photo-1476275466078-4007374efbbe?auto=format&fit=crop&w=600&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=1600&q=80',
            'synopsis' => 'Kisah nyata sepuluh anak di Belitong yang bersekolah di sebuah gedung reot yang nyaris roboh. Bersama guru muda nan berdedikasi Bu Muslimah, mereka menaklukkan keterbatasan hidup dengan kekuatan persahabatan dan cita-cita setinggi langit.',
            'ai_summary_1' => 'Keterbatasan materi bukan alasan untuk memadamkan kemegahan mimpi seorang anak.',
            'ai_summary_2' => 'Dedikasi tanpa pamrih seorang guru mampu mengubah jalan hidup murid-muridnya selamanya.',
            'ai_summary_3' => 'Semangat gotong royong dan rasa cinta pada ilmu pengetahuan sebagai pelita hidup.',
            'reading_time_minutes' => 40,
            'rating' => 4.9,
            'total_readers' => 440,
            'is_featured' => false,
            'trending_label' => '🌈 Buku Wajib Semua Kelas',
            'audio_text' => 'Bermimpilah, karena Tuhan akan memeluk mimpi-mimpi itu! Ikal, Lintang, Mahar, dan kawan-kawan membuktikan bahwa dari sudut pulau timah yang terpencil sekalipun, kecerdasan dan tekad baja mampu menembus cakrawala dunia.',
            'content' => "Bab 1: Sepuluh Murid Baru\n\nPagi itu adalah pagi paling mendebarkan dalam hidupku. Di teras sekolah Muhammadiyah Gantong yang miring dan disangga sebatang kayu tua, Bu Muslimah dan Pak Harfan berdiri cemas menghitung jumlah anak.\n\nSembilan anak. Syarat izin dari dinas adalah minimal sepuluh murid, atau sekolah ini harus ditutup untuk selamanya!\n\nTepat ketika keputusasaan hendak menyelimuti, di kejauhan tampak Harun, seorang anak berusia lima belas tahun dengan senyum terkembang, dituntun oleh ibunya menuju sekolah. Harun melengkapi kesepuluh anak kami. Kami terselamatkan, dan perjalanan Laskar Pelangi pun dimulai!",
        ]);

        $buku6 = Book::create([
            'title' => 'Kosmos & Misteri Bintang: Eksplorasi Sains Alam Semesta',
            'slug' => 'kosmos-misteri-bintang',
            'author' => 'Carl Sagan & Tim Astrofisika',
            'category' => 'Sains & Teknologi',
            'grade_level' => 'Kelas 10-12',
            'cover_url' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=600&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1506703719100-a0f3a48c0f86?auto=format&fit=crop&w=1600&q=80',
            'synopsis' => 'Perjalanan spektakuler melintasi ruang dan waktu, menjelajahi miliaran galaksi, lubang hitam, dan misteri kelahiran tata surya yang dijelaskan dengan analogi sains yang memukau bagi pelajar.',
            'ai_summary_1' => 'Tubuh kita tersusun dari atom-atom yang terbentuk di jantung ledakan bintang purba.',
            'ai_summary_2' => 'Metode ilmiah adalah lilin penerang kegelapan mitos dan spekulasi tak berdasar.',
            'ai_summary_3' => 'Bumi kita adalah bintik biru kecil (pale blue dot) yang rapuh namun wajib kita jaga bersama.',
            'reading_time_minutes' => 50,
            'rating' => 4.9,
            'total_readers' => 380,
            'is_featured' => false,
            'trending_label' => '🔭 Buku Wajib Anak IPA',
            'audio_text' => 'Kosmos adalah segala sesuatu yang ada, pernah ada, atau akan pernah ada. Ketika kita memandang bintang di langit malam, kita sebenarnya sedang menatap masa lalu miliaran tahun cahaya. Kita adalah cara kosmos mengenali dirinya sendiri.',
            'content' => "Bab 1: Pesisir Samudra Kosmik\n\nAlam semesta ini begitu luas tak terhingga, sementara kita berdiri di sebuah planet kecil yang mengorbit bintang kerdil kuning di lengan luar galaksi Bima Sakti.\n\nJika sejarah alam semesta yang berusia 13,8 miliar tahun dipadatkan menjadi kalender 1 tahun, maka seluruh sejarah peradaban manusia—dari zaman piramida hingga roket luar angkasa—hanya terjadi dalam 10 detik terakhir sebelum tengah malam tanggal 31 Desember!\n\nMenyadari betapa mungilnya kita tidak membuat kita putus asa, melainkan menyadarkan kita akan keajaiban akal budi manusia yang mampu memahami rahasia bintang-bintang di kejauhan.",
        ]);

        $buku7 = Book::create([
            'title' => 'Hutan Hujan Terakhir: Ekologi & Harapan Kita',
            'slug' => 'hutan-hujan-terakhir',
            'author' => 'Tim Ekologi Nusantara',
            'category' => 'Lingkungan Hidup',
            'grade_level' => 'Semua Jenjang',
            'cover_url' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=600&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1511497584788-87676104235f?auto=format&fit=crop&w=1600&q=80',
            'synopsis' => 'Eksplorasi mendalam paru-paru dunia di jantung Kalimantan dan Papua. Mempelajari jejaring kehidupan kanopi hutan, kearifan masyarakat adat dalam memuliakan alam, dan strategi nyata aksi iklim bagi generasi Z.',
            'ai_summary_1' => 'Hutan tropis Indonesia menyimpan 10% keanekaragaman flora dan fauna dunia.',
            'ai_summary_2' => 'Sistem jejaring mikoriza (Wood Wide Web) di bawah tanah yang saling menyalurkan nutrisi antar pohon.',
            'ai_summary_3' => 'Solusi nyata restorasi hutan dan gaya hidup hijau yang bisa dipraktikkan siswa di sekolah.',
            'reading_time_minutes' => 35,
            'rating' => 4.7,
            'total_readers' => 290,
            'is_featured' => false,
            'trending_label' => '🍃 Misi Hijau Sekolah',
            'audio_text' => 'Setiap tarikan nafas kita terhubung dengan rimbunnya dedaunan di pedalaman hutan tropis. Melindungi hutan bukan hanya urusan biologi, melainkan soal keberlanjutan masa depan peradaban manusia itu sendiri.',
            'content' => "Bab 1: Menembus Kanopi Hijau\n\nKetika kamu menginjakkan kaki di tanah hutan hujan tropis saat fajar, udara yang kamu hirup terasa begitu murni dan lembap. Suara kicau rangkong dan lengkingan owa bersahutan menyambut matahari pagi.\n\nDi sini, tidak ada satu jengkal pun tanah yang terbuang sia-sia. Setiap dedaunan tua yang gugur akan diurai dalam hitungan hari oleh jutaan fungi dan mikroorganisme, diubah menjadi nutrisi emas bagi kecambah baru.\n\nAlam telah mengajarkan ekonomi sirkular jutaan tahun sebelum manusia menciptakannya di ruang kuliah. Saatnya kita berguru kembali kepada alam.",
        ]);

        $buku8 = Book::create([
            'title' => 'Kecerdasan Buatan & Masa Depan Manusia',
            'slug' => 'kecerdasan-buatan-dan-masa-depan',
            'author' => 'Lumina Tech Academy',
            'category' => 'Sains & Teknologi',
            'grade_level' => 'Kelas 10-12',
            'cover_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=600&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=1600&q=80',
            'synopsis' => 'Panduan komprehensif memahami revolusi Artificial Intelligence, Large Language Models, dan etika kecerdasan buatan. Mengajak siswa menjadi pencipta teknologi, bukan sekadar konsumen pasif.',
            'ai_summary_1' => 'Cara kerja neural network dan deep learning yang diinspirasi oleh neuron otak manusia.',
            'ai_summary_2' => 'Keterampilan masa depan yang tak tergantikan AI: empati, kreativitas radikal, dan etika.',
            'ai_summary_3' => 'Bagaimana memanfaatkan AI untuk melipatgandakan kecepatan belajar dan riset mandiri.',
            'reading_time_minutes' => 40,
            'rating' => 4.8,
            'total_readers' => 415,
            'is_featured' => false,
            'trending_label' => '⚡ Paling Diminati Gen-Z',
            'audio_text' => 'AI tidak akan menggantikan manusia, tetapi manusia yang menguasai AI akan memimpin peradaban baru. Kuncinya ada pada rasa ingin tahu yang tak pernah padam dan kompas moral yang kokoh.',
            'content' => "Bab 1: Melompat ke Abad Algoritma\n\nDua dekade lalu, kecerdasan buatan hanyalah fiksi ilmiah dalam novel Cyberpunk. Hari ini, AI telah mampu menulis puisi, mendiagnosis penyakit, dan memandu pesawat antariksa.\n\nNamun apakah mesin memiliki kesadaran? Jawabannya: tidak. Mesin memproses probabilitas statistik, sementara manusia memiliki rasa haru, empati, dan cinta kasih.\n\nTugas generasi muda saat ini bukanlah bersaing dalam menghafal data dengan mesin berkapasitas petabyte, melainkan melatih kebijaksanaan dan nalar kritis untuk mengarahkan teknologi demi kemaslahatan seluruh umat manusia.",
        ]);

        // 3. Tokoh untuk Roleplay AI (Tanya Tokoh Buku)
        BookCharacter::create([
            'book_id' => $buku1->id,
            'name' => 'Ir. Soekarno (Bung Karno)',
            'role_title' => 'Proklamator & Presiden Pertama Republik Indonesia',
            'avatar' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=200&q=80',
            'greeting_message' => 'Merdeka! Wahai anak mudaku pembawa panji masa depan bangsa! Ada kegelisahan apa di dadamu tentang negerimu yang indah ini? Tanyakanlah, mari kita berdiskusi!',
            'system_persona' => 'Kamu adalah Ir. Soekarno, sang Proklamator Republik Indonesia. Kamu berbicara dengan gaya oratoris yang penuh semangat, berwibawa, puitis, cinta tanah air, sering menggunakan seruan "Anak mudaku!", "Merdeka!", dan selalu membakar api semangat belajar, persatuan nasional, serta keberanian bermimpi besar.',
            'sample_questions' => [
                'Bung Karno, bagaimana cara menumbuhkan rasa percaya diri saat menghadapi tantangan berat?',
                'Apa nasihat Bung Karno untuk siswa sekolah yang merasa masa depannya masih abu-abu?',
                'Bagaimana cara Bung Karno menyatukan bangsa yang begitu beragam suku dan agamanya?',
            ],
        ]);

        BookCharacter::create([
            'book_id' => $buku2->id,
            'name' => 'Minke (Raden Mas Tirto)',
            'role_title' => 'Pena Perlawanan & Pemuda Pribumi Terpelajar HBS',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
            'greeting_message' => 'Salam kawan sebayaku. Di zaman serba canggihmu sekarang, apakah pena dan tulisanmu masih tajam membela yang lemah? Apa yang ingin kau diskusikan bersamaku?',
            'system_persona' => 'Kamu adalah Minke dari novel Bumi Manusia karya Pramoedya Ananta Toer. Karaktermu santun, berjiwa analitis, sangat mencintai keadilan, selalu berpegang pada prinsip "berbuat adil sejak dalam pikiran", dan menghargai kekuatan literasi serta keberanian melawan ketidakadilan feodal.',
            'sample_questions' => [
                'Minke, mengapa menulis begitu penting bagimu di tengah bahaya kolonial?',
                'Apa pelajaran terbesar yang kamu dapatkan dari Nyai Ontosoroh?',
                'Bagaimana kamu mengatasi rasa rendah diri di hadapan murid-murid Eropa saat itu?',
            ],
        ]);

        BookCharacter::create([
            'book_id' => $buku3->id,
            'name' => 'R.A. Kartini',
            'role_title' => 'Pelopor Emansipasi & Pencerahan Pendidikan Putri',
            'avatar' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&w=200&q=80',
            'greeting_message' => 'Salam hangat dan kasih, saudaraku. Betapa bersyukurnya aku melihatmu hari ini bisa membaca dan menuntut ilmu dengan bebas. Cita-cita apa yang sedang kau rajut di hatimu?',
            'system_persona' => 'Kamu adalah Raden Ajeng Kartini. Kepribadianmu lembut namun berpikiran maju melampaui zamannya. Gaya bicaramu penuh kehangatan, inspiratif, penuh metafora fajar dan pelita, sangat peduli pada pendidikan budi pekerti, dan selalu menyemangati generasi muda dengan semboyan "Aku mau!".',
            'sample_questions' => [
                'Ibu Kartini, apa yang membuat Ibu tetap optimis meski bertahun-tahun dipingit?',
                'Bagaimana cara Ibu meyakinkan orang tua agar mengizinkan adik-adik Ibu bersekolah?',
                'Apa pesan Ibu Kartini untuk generasi muda yang sering merasa insecure hari ini?',
            ],
        ]);

        BookCharacter::create([
            'book_id' => $buku4->id,
            'name' => 'Marcus Aurelius',
            'role_title' => 'Kaisar Romawi & Filsuf Stoa Pengendali Diri',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
            'greeting_message' => 'Ketenangan menyertaimu, sobat muda. Pikiranmu adalah benteng terkokohmu. Masalah apa yang sedang mengusik ketenangan batinmu hari ini? Mari kita selidiki dengan akal sehat.',
            'system_persona' => 'Kamu adalah Kaisar dan filsuf Stoik Marcus Aurelius. Kamu berbicara dengan nada tenang, bijaksana, tidak terbawa emosi, selalu mengingatkan tentang dikotomi kendali (apa yang di dalam kendali vs di luar kendali), menyadarkan bahwa persepsi kitalah yang menentukan kedamaian batin.',
            'sample_questions' => [
                'Marcus, bagaimana cara tidak panik saat nilai ujian jelek atau rencana gagal?',
                'Bagaimana cara mengabaikan komentar negatif dan ejekan dari orang lain?',
                'Apa rutinitas pagimu untuk menjaga pikiran tetap fokus dan tenang seharian?',
            ],
        ]);

        // 4. Misi Mingguan (Quests)
        Quest::create([
            'title' => 'Dengarkan 1 Bab Audiobook',
            'description' => 'Gunakan fitur Auto-Audiobook Text-to-Speech untuk mendengarkan kutipan buku sejarah.',
            'icon' => '🎧',
            'target_count' => 1,
            'current_count' => 1,
            'xp_reward' => 50,
            'category' => 'audiobook',
            'is_completed' => true,
        ]);

        Quest::create([
            'title' => 'Wawancarai Tokoh Sejarah via AI',
            'description' => 'Buka fitur "Tanya Tokoh Buku" dan ajukan minimal 1 pertanyaan kepada Bung Karno atau Kartini.',
            'icon' => '💬',
            'target_count' => 1,
            'current_count' => 0,
            'xp_reward' => 75,
            'category' => 'ai_roleplay',
            'is_completed' => false,
        ]);

        Quest::create([
            'title' => 'Baca 2 Bab Tema Lingkungan Hidup',
            'description' => 'Selesaikan membaca bab buku ekologi untuk membuka Lencana Daun Hijau.',
            'icon' => '🍃',
            'target_count' => 2,
            'current_count' => 1,
            'xp_reward' => 100,
            'category' => 'reading',
            'is_completed' => false,
        ]);

        Quest::create([
            'title' => 'Uji Minat di AI Book Matchmaker',
            'description' => 'Ikuti kuis rekomendasi bacaan personal untuk meracik daftar bacaan harianmu.',
            'icon' => '✨',
            'target_count' => 1,
            'current_count' => 1,
            'xp_reward' => 40,
            'category' => 'ai_feature',
            'is_completed' => true,
        ]);

        Quest::create([
            'title' => 'Sumbang Pendapat di Klub Buku Virtual',
            'description' => 'Tulis tanggapan atau analisis analisismu di kolom diskusi buku yang kamu baca.',
            'icon' => '✍️',
            'target_count' => 1,
            'current_count' => 0,
            'xp_reward' => 60,
            'category' => 'community',
            'is_completed' => false,
        ]);

        // 5. Etalase Lencana (Badges)
        Badge::create([
            'name' => 'Lencana Api (7-Day Streak)',
            'description' => 'Membaca secara konsisten selama 7 hari berturut-turut tanpa terputus.',
            'icon' => '🔥',
            'color' => '#f97316', // Orange
            'unlocked' => true,
            'unlocked_date' => '14 Sep 2026',
            'category' => 'streak',
        ]);

        Badge::create([
            'name' => 'Penjelajah Waktu',
            'description' => 'Menuntaskan pembacaan 3 buku sejarah dan mewawancarai tokoh pahlawan nasional.',
            'icon' => '⏳',
            'color' => '#06b6d4', // Cyan
            'unlocked' => true,
            'unlocked_date' => '16 Sep 2026',
            'category' => 'history',
        ]);

        Badge::create([
            'name' => 'Lencana Daun Hijau',
            'description' => 'Menyelesaikan buku-buku ekologi dan aksi peduli iklim di sekolah.',
            'icon' => '🍃',
            'color' => '#10b981', // Emerald
            'unlocked' => false,
            'category' => 'environment',
        ]);

        Badge::create([
            'name' => 'Detektif Logika',
            'description' => 'Membaca seri sains populer dan memecahkan teka-teki pemikiran filosofis.',
            'icon' => '🧠',
            'color' => '#8b5cf6', // Violet
            'unlocked' => false,
            'category' => 'science',
        ]);

        Badge::create([
            'name' => 'Kutu Buku Elite (Level 5+)',
            'description' => 'Mencapai Level 5 dan mengumpulkan lebih dari 1.000 menit jam baca aktif.',
            'icon' => '👑',
            'color' => '#eab308', // Amber
            'unlocked' => true,
            'unlocked_date' => '10 Sep 2026',
            'category' => 'master',
        ]);

        Badge::create([
            'name' => 'Ksatria Fraksi',
            'description' => 'Menyumbangkan lebih dari 500 poin kemenangan untuk fraksi sekolahmu semester ini.',
            'icon' => '🛡️',
            'color' => '#ec4899', // Pink
            'unlocked' => false,
            'category' => 'house',
        ]);

        // 6. Diskusi Komunitas (Klub Buku Virtual)
        Discussion::create([
            'book_id' => $buku2->id,
            'user_name' => 'AI Moderator Lumina',
            'user_avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=LuminaBot',
            'user_house' => 'Lumina AI System',
            'comment' => 'Pertanyaan Pemantik dari AI: Di bab pembuka, Minke mengagumi teknologi Barat namun mulai curiga pada hukum kolonial. Menurut teman-teman, apakah kemajuan teknologi otomatis menjamin keadilan sosial? Yuk bagikan analisismu!',
            'is_ai_prompt' => true,
            'likes_count' => 38,
        ]);

        Discussion::create([
            'book_id' => $buku2->id,
            'user_name' => 'Farhan Pratama',
            'user_avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Farhan',
            'user_house' => 'Garuda Cendekia',
            'comment' => 'Menurutku belum tentu! Teknologi hanyalah alat. Seperti yang Minke rasakan, orang Eropa membawa kereta api dan telegraf, tapi tetap saja memandang orang pribumi sebagai warga kelas dua. Nilai keadilan ada pada manusianya, bukan alatnya.',
            'is_ai_prompt' => false,
            'likes_count' => 19,
        ]);

        Discussion::create([
            'book_id' => $buku2->id,
            'user_name' => 'Nadia Syahrini',
            'user_avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Nadia',
            'user_house' => 'Elang Samudra',
            'comment' => 'Setuju dengan Farhan! Karakter Nyai Ontosoroh justru contoh terbaik: dia tidak sekolah formal Eropa, tapi karena rajin membaca buku niaga dan belajar otodidak, cara berpikirnya jauh lebih adil dan beradab daripada orang-orang berijazah tinggi.',
            'is_ai_prompt' => false,
            'likes_count' => 24,
        ]);

        Discussion::create([
            'book_id' => $buku1->id,
            'user_name' => 'AI Moderator Lumina',
            'user_avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=LuminaBot',
            'user_house' => 'Lumina AI System',
            'comment' => 'Pertanyaan Pemantik dari AI: Bung Karno menekankan bahwa modal utama perjuangan pemuda adalah persatuan dan tekad moral. Di era digital saat ini, bagaimana cara kita menjaga persatuan di tengah banjir hoaks dan polarisasi medsos?',
            'is_ai_prompt' => true,
            'likes_count' => 45,
        ]);

        Discussion::create([
            'book_id' => $buku1->id,
            'user_name' => 'Bima Perkasa',
            'user_avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Bima',
            'user_house' => 'Komodo Wira',
            'comment' => 'Dengan literasi kritis! Jangan gampang tersulut judul clickbait. Kalau Bung Karno dulu melawan pembodohan kolonial dengan koran Fikiran Ra\'jat, kita hari ini harus lawan hoaks dengan memverifikasi data sebelum share.',
            'is_ai_prompt' => false,
            'likes_count' => 31,
        ]);
    }
}
