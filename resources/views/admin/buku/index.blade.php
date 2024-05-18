@extends('admin.layout.layout')
@section('main')
    <div class="flex flex-col flex-1 w-full">
        @include('admin.layout.header')
        <main class="h-full pb-16 overflow-y-auto">
            <div class="container grid px-6 mx-auto">
                <div class="flex items-center justify-between">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        Jadwal
                    </h2>
                    <button @click="openModal"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Tambah buku
                    </button>
                </div>
                <!-- With actions -->
                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">gambar</th>
                                    <th class="px-4 py-3">Judul</th>
                                    <th class="px-4 py-3">Penulis</th>
                                    <th class="px-4 py-3">Tahun terbit</th>
                                    <th class="px-4 py-3">Genre</th>
                                    {{-- <th class="px-4 py-3">Sinopsis</th> --}}
                                    <th class="px-4 py-3">Kode buku</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($books as $book)
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="{{ $book->gambar ? asset('uploads/' . $book->gambar) : 'https://plus.unsplash.com/premium_photo-1677187301535-b46cec7b2cc8?q=80&w=1523&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
                                                    alt="" loading="lazy" />

                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm dark:text-white">
                                        {{ $book->judul }}
                                    </td>
                                    <td class="px-4 py-3 text-sm dark:text-white">
                                        {{ $book->penulis }}
                                    </td>
                                    <td class="px-4 py-3 text-sm dark:text-white">
                                        {{ $book->tahun_terbit }}
                                    </td>
                                    <td class="px-4 py-3 text-sm dark:text-white">
                                        {{ $book->gendre }}
                                    </td>
                                    {{-- <td class="px-4 py-3 text-sm dark:text-white">
                                        {{ $book->sinopsis }}
                                    </td> --}}
                                    <td class="px-4 py-3 text-sm dark:text-white">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                                            {{ $book->kode_buku }} </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-4 text-sm">
                                            <a href="{{ route('edit_buku', ['id' => $book->id_buku]) }}"
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Edit">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </a>

                                            @php
                                                $route = $book->status_pinjaman !== 1 ? 'pinjam_buku' : 'kembali_buku';
                                                $icon = $book->status_pinjaman !== 1 ? 'pinjam' : 'kembali';
                                            @endphp




                                            <form action="{{ route('delete_buku', ['id' => $book->id_buku]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="confirm('Apakah anda yakin ingin menghapus?')"
                                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                    aria-label="Delete">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            <a href="{{ route($route, ['id' => $book->id_buku]) }}"
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Edit">
                                                {!! $icon !!}
                                            </a>
                                        </div>
                                    </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div
                        class="flex px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <span class="flex items-center  col-span-3">
                            Showing {{ $books->firstItem() }}-{{ $books->lastItem() }} of {{ $books->total() }}
                        </span>
                        <div
                            class="flex px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                                {{ $books->links() }}
                            </span>
                        </div>

                    </div>
                    <!--end Pagination -->
                </div>
            </div>
        </main>

        <!-- Modal tambah hari-->
        <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
            <!-- Modal -->
            <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal"
                @keydown.escape="closeModal"
                class="w-full px-6 py-4 overflow-y-auto bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                role="dialog" id="modal">
                <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                <header class="flex justify-end">
                    <button
                        class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                        aria-label="close" @click="closeModal">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                            <path
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                    </button>
                </header>
                <!-- Modal tambah hari -->
                <div class="mt-4 mb-6">
                    <!-- Modal title -->
                    <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300  ">
                        Tambah Buku
                    </p>
                    <!-- Modal description -->
                    <form class="flex flex-col overflow-auto" action="{{ route('store_buku') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="grid md:grid-cols-2 xl:grid-cols-2">
                            <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Judul</span>
                                    <div
                                        class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <input name="judul"
                                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                            placeholder="masukan judul" />
                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Kode buku</span>
                                    <div
                                        class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <input name="kode_buku"
                                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                            placeholder="Kode buku / serial number" />
                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Penulis</span>
                                    <div
                                        class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <input name="penulis"
                                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                            placeholder="masukan penulis" />
                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Tahun terbit</span>
                                    <div
                                        class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <input type="date" name="tahun_terbit"
                                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                            placeholder="masukan tahun terbit" />
                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Gendre</span>
                                    <div
                                        class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <select name="gendre"
                                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                                            <option value="#" selected disabled>Pilih Gendre</option>
                                            @foreach ($genres as $genre)
                                                <option value="{{ $genre->nama }}" class="">
                                                    {{ $genre->nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Sinopsis</span>
                                    <div
                                        class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <textarea placeholder="Masukan sinopsis disini .." name="sinopsis"
                                            class="block w-full  mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"></textarea>
                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">

                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Kategori</span>
                                    <div
                                        class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <select name="kategori"
                                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                                            <option value="#" selected disabled>Pilih kategori</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id_kategori }}" class="">
                                                    {{ $kategori->kategori }}</option>
                                            @endforeach
                                        </select>

                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Gambar</span>
                                    <span class="text-gray-700 dark:text-gray-400">(Maksimal size 2 mb)</span>
                                    <div
                                        class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <input type="file" name="gambar"
                                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                            placeholder="Upload gambar" />

                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <button type="submit"
                            class="flex items-center justify-center p-3 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- End of modal update hari  -->
    </div>
@endsection
