<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <i class="fas fa-book-open mr-2 text-indigo-600"></i>
                {{ __('Thư viện truyện tranh') }}
            </h2>
            <a href="{{ route('comics.create') }}"
                class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Thêm truyện
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Section -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <!-- Search Button (Initially shown) -->
                    <div id="searchButton" class="text-center">
                        <button onclick="toggleSearch()"
                            class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-8 py-3 rounded-full text-lg font-semibold transition duration-300 shadow-lg transform hover:scale-105">
                            <i class="fas fa-search mr-2"></i>
                            Tìm kiếm truyện tranh
                        </button>
                    </div>

                    <!-- Search Form (Initially hidden) -->
                    <div id="searchForm" class="hidden">
                        <form method="GET" action="{{ route('comics.index') }}" class="flex items-center space-x-4">
                            <div class="flex-1 relative">
                                <input type="text" name="search" id="searchInput" value="{{ $search }}"
                                    placeholder="Nhập tên truyện tranh..."
                                    class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-lg"
                                    autocomplete="off">
                                <i
                                    class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-full transition duration-200 flex items-center">
                                <i class="fas fa-search mr-2"></i>
                                Tìm
                            </button>
                            <button type="button" onclick="toggleSearch()"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-full transition duration-200 flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Đóng
                            </button>
                        </form>

                        <!-- Search Results Info -->
                        @if ($search)
                            <div class="mt-4 flex items-center justify-between">
                                <p class="text-gray-600 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Tìm thấy {{ $comics->total() }} kết quả cho từ khóa: <span
                                        class="font-semibold text-indigo-600">"{{ $search }}"</span>
                                </p>
                                <a href="{{ route('comics.index') }}"
                                    class="text-indigo-600 hover:text-indigo-800 transition duration-200 flex items-center">
                                    <i class="fas fa-list mr-2"></i>
                                    Xem tất cả
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Filter/Sort Section -->
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <!-- Filter buttons -->
                        <div class="flex flex-wrap gap-2">
                            <button
                                class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-full hover:bg-indigo-200 transition duration-200 flex items-center">
                                <i class="fas fa-fire mr-2"></i>
                                Mới nhất
                            </button>
                            <button
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition duration-200 flex items-center">
                                <i class="fas fa-star mr-2"></i>
                                Đánh giá cao
                            </button>
                            <button
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition duration-200 flex items-center">
                                <i class="fas fa-eye mr-2"></i>
                                Xem nhiều
                            </button>
                            <button
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition duration-200 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                Hoàn thành
                            </button>
                        </div>

                        <!-- View toggle -->
                        <div class="flex items-center space-x-2">
                            <button id="gridView" onclick="toggleView('grid')"
                                class="p-2 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 transition duration-200">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button id="listView" onclick="toggleView('list')"
                                class="p-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition duration-200">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comics Grid -->
            <div id="comicsContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse($comics as $comic)
                    <div
                        class="comic-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:scale-105">
                        <!-- Cover Image -->
                        <div class="relative group">
                            <img src="{{ $comic->cover_image ? asset('storage/' . $comic->cover_image) : 'https://via.placeholder.com/300x400?text=No+Cover' }}"
                                alt="{{ $comic->title }}" class="w-full h-64 object-cover">

                            <!-- Overlay -->
                            <div
                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 transition duration-300 flex space-x-2">
                                    <a href="{{ route('comics.show', $comic) }}"
                                        class="bg-white text-gray-800 px-4 py-2 rounded-full hover:bg-gray-100 transition duration-200 flex items-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        Xem
                                    </a>
                                    <button
                                        class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition duration-200 flex items-center">
                                        <i class="fas fa-heart mr-2"></i>
                                        Yêu thích
                                    </button>
                                </div>
                            </div>

                            <!-- Status badge -->
                            <div class="absolute top-2 right-2">
                                @if ($comic->status == 'completed')
                                    <span
                                        class="bg-green-500 text-white px-2 py-1 rounded-full text-xs flex items-center">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Hoàn thành
                                    </span>
                                @else
                                    <span
                                        class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        Đang ra
                                    </span>
                                @endif
                            </div>

                            <!-- Language badge -->
                            <div class="absolute top-2 left-2">
                                @if ($comic->language == 'vi')
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">🇻🇳</span>
                                @else
                                    <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">🇺🇸</span>
                                @endif
                            </div>
                        </div>

                        <!-- Comic Info -->
                        <div class="p-4">
                            <h3
                                class="font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-indigo-600 transition duration-200">
                                {{ $comic->title }}
                            </h3>

                            @if ($comic->author)
                                <p class="text-sm text-gray-600 mb-2 flex items-center">
                                    <i class="fas fa-user-edit mr-1"></i>
                                    {{ $comic->author }}
                                </p>
                            @endif

                            <!-- Stats -->
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span class="flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    {{ number_format($comic->views) }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-star mr-1 text-yellow-500"></i>
                                    {{ number_format($comic->rating, 1) }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $comic->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-search text-6xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">
                            @if ($search)
                                Không tìm thấy truyện tranh nào
                            @else
                                Chưa có truyện tranh nào
                            @endif
                        </h3>
                        <p class="text-gray-500 mb-4">
                            @if ($search)
                                Thử tìm kiếm với từ khóa khác hoặc
                                <a href="{{ route('comics.index') }}"
                                    class="text-indigo-600 hover:text-indigo-800">xem tất cả truyện</a>
                            @else
                                Hãy thêm truyện tranh đầu tiên của bạn!
                            @endif
                        </p>
                        @if (!$search)
                            <a href="{{ route('comics.create') }}"
                                class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg transition duration-200 inline-flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                Thêm truyện tranh
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($comics->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-lg shadow-md p-4">
                        {{ $comics->appends(['search' => $search])->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .comic-card-list {
            display: flex;
            flex-direction: row;
            height: 200px;
        }

        .comic-card-list img {
            width: 150px;
            height: 200px;
            object-fit: cover;
        }

        .comic-card-list .p-4 {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>

    <script>
        // Toggle search form
        function toggleSearch() {
            const searchButton = document.getElementById('searchButton');
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');

            searchButton.classList.toggle('hidden');
            searchForm.classList.toggle('hidden');

            if (!searchForm.classList.contains('hidden')) {
                searchInput.focus();
            }
        }

        // Toggle view (grid/list)
        function toggleView(viewType) {
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');
            const container = document.getElementById('comicsContainer');
            const cards = document.querySelectorAll('.comic-card');

            if (viewType === 'grid') {
                gridView.classList.remove('bg-gray-100', 'text-gray-700');
                gridView.classList.add('bg-indigo-100', 'text-indigo-700');
                listView.classList.remove('bg-indigo-100', 'text-indigo-700');
                listView.classList.add('bg-gray-100', 'text-gray-700');

                container.className = 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6';
                cards.forEach(card => {
                    card.classList.remove('comic-card-list');
                });
            } else {
                listView.classList.remove('bg-gray-100', 'text-gray-700');
                listView.classList.add('bg-indigo-100', 'text-indigo-700');
                gridView.classList.remove('bg-indigo-100', 'text-indigo-700');
                gridView.classList.add('bg-gray-100', 'text-gray-700');

                container.className = 'space-y-4';
                cards.forEach(card => {
                    card.classList.add('comic-card-list');
                });
            }
        }

        // Auto-show search form if there's a search query
        @if ($search)
            document.addEventListener('DOMContentLoaded', function() {
                toggleSearch();
            });
        @endif

        // Auto-complete search functionality
        let searchTimeout;
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            const query = e.target.value;

            if (query.length > 2) {
                searchTimeout = setTimeout(() => {
                    // Here you can implement AJAX search for real-time results
                    console.log('Searching for:', query);
                }, 300);
            }
        });
    </script>
</x-app-layout>
