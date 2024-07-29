<?php

namespace App\Http\Controllers;

use App\Helpers\CBFHelper;
use App\Helpers\PengujianHelper;
use App\Models\M_buku;
use App\Models\M_kategori;
use App\Models\M_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class controller_buku extends Controller
{
    protected $user;
    protected $books;
    protected $kategoris;
    protected $genres;


    public function __construct()
    {
        $this->user = Auth::user();
        $this->kategoris = M_kategori::all();
        $this->books =   M_buku::paginate(10);
        $this->genres =  [
            (object) ['nama' => 'Horor'],
            (object) ['nama' => 'Romance'],
            (object) ['nama' => 'Edukasi'],
            (object) ['nama' => 'Fantasi'],
            (object) ['nama' => 'Fiksi Ilmiah'],
            (object) ['nama' => 'Misteri'],
            (object) ['nama' => 'Sejarah'],
            (object) ['nama' => 'Biografi'],
            (object) ['nama' => 'Komedi'],
            (object) ['nama' => 'Drama'],
        ];
    }

    public function show()
    {
        $user = $this->user;
        $books = $this->books;
        $title = 'Kelola Buku';
        $genres = $this->genres;
        $kategoris = $this->kategoris;
        return view('admin.buku.index', compact('books', 'user', 'title', 'genres', 'kategoris'));
    }

    // Menambahkan data Buku
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'tahun_terbit' => 'required|string|max:255',
            'gendre' => 'required|string|max:255',
            'sinopsis' => 'required|string',
            'kategori' => 'required|string|max:500',
            'kode_buku' => 'required|string|max:255|unique:tb_buku',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:10048',
        ]);

        // Tangani penyimpanan gambar yang diunggah
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
        }
        // Simpan data buku baru ke dalam database
        $buku = new M_buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->gendre = $request->gendre;
        $buku->sinopsis = $request->sinopsis;
        $buku->kategori = $request->kategori;
        $buku->kode_buku = $request->kode_buku;
        $buku->gambar = $imageName;
        $buku->save();
        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return redirect()->route('kelola-buku')->with('success', 'Data buku ' . $request->judul . ' berhasil ditambahkan');
    }

    // Menampilkan view edit Buku
    public function edit($id)
    {
        $title = 'Master buku';
        $book = M_buku::findOrFail($id);

        $genres = $this->genres;
        $kategoris = $this->kategoris;
        return view('admin.buku.edit', compact('title', 'book', 'genres', 'kategoris'));
    }

    // Mengedit data Buku
    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required|date',
            'gendre' => 'required|string|max:255',
            'sinopsis' => 'required|string|',
            'kategori' => 'required|string|max:255',
            'kode_buku' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10048',
        ]);
        $buku = M_buku::findOrFail($id);
        // Jika terdapat file gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($buku->gambar) {
                $gambarPath = public_path('uploads/' . $buku->gambar);
                if (file_exists($gambarPath)) {
                    unlink($gambarPath);
                }
            }
            // Simpan gambar baru dengan nama unik berdasarkan waktu
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

            // Set nama gambar baru ke atribut gambar buku
            $buku->gambar = $imageName;
        }

        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->gendre = $request->gendre;
        $buku->sinopsis = $request->sinopsis;
        $buku->kategori = $request->kategori;
        $buku->kode_buku = $request->kode_buku;
        $buku->save();

        return redirect()->route('kelola-buku')->with('success', 'Data buku berhasil diperbarui.');
    }

    // Menghjapus data Buku
    public function delete($id)
    {
        // Temukan buku berdasarkan ID
        $buku = M_buku::findOrFail($id);
        if ($buku->gambar) {
            $gambarPath = public_path('uploads/' . $buku->gambar);
            if (file_exists($gambarPath)) {
                unlink($gambarPath);
            }
        }
        // Hapus buku
        $buku->delete();

        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Data buku ' . $buku->nama . ' berhasil dihapus');
    }

    // Pencariaan Menggunakan CBF
    public function search(Request $request)
    {
        $categorys = M_kategori::all();
        $user = Auth::user();
        $title = 'Landing Page';
        $books = M_buku::orderBy('created_at', 'desc')->take(5)->get();
        $query = $request->input('query');

        $docBuku = M_buku::all();
        $documents = $docBuku->map(function ($book) {
            return $book->judul . ' ' . $book->sinopsis;
        })->toArray();

        $cbf = new CBFHelper();
        $similarities = $cbf->recommend($query, $documents);

        // ganti nilai 5 untuk jumlah rekomendasi
        $topMatches = array_slice(array_keys($similarities), 0, 10, true);
        
        $results = [];
        foreach ($topMatches as $index) {
            $results[] = [
                'book' => $docBuku[$index],
                'similarity' => $similarities[$index],
            ];
        }
        
        // return response()->json($results);
        $pengguna = M_user::paginate(200);
        $allBook = M_buku::paginate(1000);

        return view('siswa.dashboard.index', compact('user', 'title', 'books', 'results', 'pengguna', 'allBook', 'categorys'));
    }

    // Suggestions text search
    public function suggest(Request $request)
    {
        $query = $request->input('query');
        $books = M_buku::all();
        $documents = $books->map(function ($book) {
            return $book->judul . ' ' . $book->sinopsis;
        })->toArray();

        $cbf = new CBFHelper();
        $suggestions = [];

        foreach ($cbf->getSuggestions($query, $documents) as $key => $value) {
            $suggestions[] = $value;
        }

        return response()->json($suggestions);
    }

    // pengujian
    public function pengujian(Request $request)
    {
        $cbfHelper = new CBFHelper();
        $evaluationHelper = new PengujianHelper();

        $query = $request->input('query');
        $books = M_buku::all();
        $documents = $books->map(function ($book) {
            return $book->judul . ' ' . $book->sinopsis;
        })->toArray();

        $recommendations = $cbfHelper->recommend($query, $documents);

        // Hasil relevan
        $terms = preg_split('/\s+/', $cbfHelper->preprocess($query));
        $queryBuild = M_buku::query();

        foreach ($terms as $term) {
            $queryBuild->orWhere(function ($q) use ($term) {
                $q->where('judul', 'LIKE', '%' . $term . '%')
                    ->orWhere('sinopsis', 'LIKE', '%' . $term . '%');
            });
        }

        $relevant = array_keys($queryBuild->pluck('id_buku')->toArray());
        /** data buku relevant */
        // dd(array_keys($relevant));

        $results = [];
        $minimumSimilarities = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $totalDocuments = count($recommendations);

        foreach ($minimumSimilarities as $minSim) {
            $threshold = $minSim / 100;
            $filteredRecommendations = array_filter($recommendations, function ($value) use ($threshold) {
                // Log::info("Value : " . $value);
                return $value >= $threshold;
            });

            $retrieved = array_keys($filteredRecommendations);
            $relevantRetrieved = array_intersect($retrieved, $relevant);
            // dd($retrieved, $relevantRetrieved);

            $resRelevant = [];
            $resRetrieved = [];
            $resRelevantRetrieved = [];
            foreach ($relevant as $index) {
                $resRelevant[] = [
                    'book' => $books[$index]->judul,
                ];
            }
            foreach ($retrieved as $index) {
                $resRetrieved[] = [
                    'book' => $books[$index]->judul,
                ];
            }
            foreach ($relevantRetrieved as $index) {
                $resRelevantRetrieved[] = [
                    'book' => $books[$index]->judul,
                ];
            }

            // Log untuk debugging
            Log::info('Threshold: ' . $threshold);
            Log::info('Relevant : ' . print_r($resRelevant, true));
            Log::info('Retrived: ' . print_r($resRetrieved, true));
            Log::info('Relevant Retrieved: ' . print_r($resRelevantRetrieved, true));

            $evaluation = $evaluationHelper->evaluate($relevantRetrieved, $retrieved, $relevant, $totalDocuments);

            $results[] = [
                'minSim' => $minSim,
                'precision' => $evaluation['precision'],
                'accuracy' => $evaluation['accuracy'],
                'recall' => $evaluation['recall'],
                'fMeasure' => $evaluation['fMeasure']
            ];
        }

        return response()->json($results);
    }
}
