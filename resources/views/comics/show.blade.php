<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('comics.index') }}" class="text-gray-600 hover:text-gray-800 transition duration-200">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                    <i class="fas fa-book-open mr-2 text-indigo-600"></i>
                    Chi tiết truyện tranh
                </h2>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('comics.edit', $comic) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Chỉnh sửa
                </a>
                <form action="{{ route('comics.destroy', $comic) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa truyện tranh này?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                <button
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-heart mr-2"></i>
                    Yêu thích
                </button>
                <button
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-share mr-2"></i>
                    Chia sẻ
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Comic Info Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Cover Image -->
                        <div class="lg:col-span-1">
                            <div class="relative">
                                <img src="{{ $comic->cover_image ? asset('storage/' . $comic->cover_image) : 'https://via.placeholder.com/400x600?text=No+Cover' }}"
                                    alt="{{ $comic->title }}" class="w-full max-w-sm mx-auto rounded-lg shadow-md">

                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
                                    @if ($comic->status == 'completed')
                                        <span
                                            class="bg-green-500 text-white px-3 py-1 rounded-full text-sm flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Hoàn thành
                                        </span>
                                    @else
                                        <span
                                            class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm flex items-center">
                                            <i class="fas fa-clock mr-1"></i>
                                            Đang ra
                                        </span>
                                    @endif
                                </div>

                                <!-- Language Badge -->
                                <div class="absolute top-4 left-4">
                                    @if ($comic->language == 'vi')
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">🇻🇳 Tiếng
                                            Việt</span>
                                    @else
                                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm">🇺🇸
                                            English</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Comic Details -->
                        <div class="lg:col-span-2">
                            <div class="mb-6">
                                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $comic->title }}</h1>
                                <p class="text-gray-600 text-lg mb-4">{{ $comic->author ?? 'Chưa rõ tác giả' }}</p>

                                <!-- Stats -->
                                <div class="flex flex-wrap gap-6 mb-6">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-eye mr-2 text-blue-500"></i>
                                        <span class="font-semibold">{{ number_format($comic->views) }}</span>
                                        <span class="ml-1">lượt xem</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-star mr-2 text-yellow-500"></i>
                                        <span class="font-semibold">{{ number_format($comic->rating, 1) }}</span>
                                        <span class="ml-1">/ 5</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-heart mr-2 text-red-500"></i>
                                        <span class="font-semibold">1.2K</span>
                                        <span class="ml-1">yêu thích</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-calendar mr-2 text-green-500"></i>
                                        <span>{{ $comic->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                <!-- Genres (Mock data) -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold mb-3 flex items-center">
                                        <i class="fas fa-tags mr-2 text-indigo-600"></i>
                                        Thể loại
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        @php
                                            $colorClasses = [
                                                ['bg-indigo-100', 'text-indigo-800'],
                                                ['bg-purple-100', 'text-purple-800'],
                                                ['bg-pink-100', 'text-pink-800'],
                                                ['bg-green-100', 'text-green-800'],
                                                ['bg-yellow-100', 'text-yellow-800'],
                                                ['bg-blue-100', 'text-blue-800'],
                                                ['bg-red-100', 'text-red-800'],
                                                ['bg-teal-100', 'text-teal-800'],
                                            ];
                                        @endphp
                                        @if ($comic->genres->count() > 0)
                                            @foreach ($comic->genres as $item)
                                                @php
                                                    $color = $colorClasses[$loop->index % count($colorClasses)];
                                                @endphp
                                                <span
                                                    class="{{ $color[0] }} {{ $color[1] }} px-3 py-1 rounded-full text-sm">
                                                    {{ $item->name }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                                ---
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-wrap gap-4 mb-6">
                                    <button
                                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center shadow-lg">
                                        <i class="fas fa-play mr-2"></i>
                                        Đọc từ đầu
                                    </button>
                                    <button
                                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center">
                                        <i class="fas fa-bookmark mr-2"></i>
                                        Đọc tiếp
                                    </button>
                                    <button
                                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center">
                                        <i class="fas fa-bell mr-2"></i>
                                        Theo dõi
                                    </button>
                                </div>

                                <!-- Description -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold mb-3 flex items-center">
                                        <i class="fas fa-align-left mr-2 text-indigo-600"></i>
                                        Mô tả
                                    </h3>
                                    <div class="prose max-w-none">
                                        <p class="text-gray-700 leading-relaxed">
                                            {{ $comic->description ?? 'Chưa có mô tả cho truyện này.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chapters Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex justify-between">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-list mr-2"></i>
                        Danh sách chương (24 chương)
                    </h3>
                    <a class="font-semibold text-white"
                        href="{{ route('chapters.create') }}?comic_id={{ $comic->id }}">Thêm chương</a>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <button
                                class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg hover:bg-indigo-200 transition duration-200 flex items-center">
                                <i class="fas fa-sort-numeric-down mr-2"></i>
                                Mới nhất
                            </button>
                            <button
                                class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition duration-200 flex items-center">
                                <i class="fas fa-sort-numeric-up mr-2"></i>
                                Cũ nhất
                            </button>
                        </div>
                        <div class="text-sm text-gray-600">
                            Cập nhật: 2 giờ trước
                        </div>
                    </div>

                    <!-- Chapters List -->
                    <div class="space-y-2">
                        @foreach ($comic->chapters as $item)
                            <div
                                class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="flex items-center space-x-3">
                                    <span
                                        class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $item->chapter_number }}</span>
                                    <div>
                                        <h4 class="font-medium text-gray-800 hover:text-indigo-600 cursor-pointer">
                                            Chương {{ $item->chapter_number }}:{{ $item->title }}
                                        </h4>
                                        <p class="text-sm text-gray-500">{{ $item->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if ($item->created_at->diffInHours(now()) < 24)
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Mới</span>
                                    @endif
                                    <a href="{{ route('chapters.show', $item) }}"
                                        class="text-gray-400 hover:text-gray-600 transition duration-200">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Load More -->
                    <div class="text-center mt-6">
                        <button
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg transition duration-200 flex items-center mx-auto">
                            <i class="fas fa-chevron-down mr-2"></i>
                            Xem thêm chương
                        </button>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-comments mr-2"></i>
                        Bình luận (156)
                    </h3>
                </div>
                <div class="p-6">
                    <!-- Comment Form -->
                    <div class="mb-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <textarea placeholder="Viết bình luận của bạn..."
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 resize-none"
                                rows="3"></textarea>
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex items-center space-x-2">
                                    <button class="text-gray-500 hover:text-gray-700 transition duration-200">
                                        <i class="fas fa-smile"></i>
                                    </button>
                                    <button class="text-gray-500 hover:text-gray-700 transition duration-200">
                                        <i class="fas fa-image"></i>
                                    </button>
                                </div>
                                <button
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Gửi
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Comments List -->
                    <div class="space-y-4">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="flex space-x-3">
                                <img src="https://ui-avatars.com/api/?name=User+{{ $i }}&background=random"
                                    alt="User {{ $i }}" class="w-10 h-10 rounded-full">
                                <div class="flex-1">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-gray-800">Độc giả {{ $i }}</h4>
                                            <span class="text-sm text-gray-500">{{ rand(1, 24) }} giờ trước</span>
                                        </div>
                                        <p class="text-gray-700">
                                            {{ $i == 1
                                                ? 'Truyện hay quá! Mong tác giả sẽ ra chương mới sớm.'
                                                : ($i == 2
                                                    ? 'Nhân vật chính ngầu quá, đặc biệt là ở chương này.'
                                                    : 'Cảm ơn tác giả đã mang đến một tác phẩm tuyệt vời như vậy!') }}
                                        </p>
                                        <div class="flex items-center space-x-4 mt-3">
                                            <button
                                                class="text-gray-500 hover:text-indigo-600 transition duration-200 flex items-center">
                                                <i class="fas fa-thumbs-up mr-1"></i>
                                                <span>{{ rand(5, 20) }}</span>
                                            </button>
                                            <button
                                                class="text-gray-500 hover:text-indigo-600 transition duration-200 flex items-center">
                                                <i class="fas fa-reply mr-1"></i>
                                                Trả lời
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <!-- Load More Comments -->
                    <div class="text-center mt-6">
                        <button
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg transition duration-200 flex items-center mx-auto">
                            <i class="fas fa-chevron-down mr-2"></i>
                            Xem thêm bình luận
                        </button>
                    </div>
                </div>
            </div>

            <!-- Related Comics -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-heart mr-2"></i>
                        Truyện cùng thể loại
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        @for ($i = 1; $i <= 6; $i++)
                            <div
                                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 transform hover:scale-105">
                                <div class="relative">
                                    <img src="https://via.placeholder.com/200x280?text=Comic+{{ $i }}"
                                        alt="Related Comic {{ $i }}" class="w-full h-40 object-cover">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
                                        <button
                                            class="opacity-0 hover:opacity-100 bg-white text-gray-800 px-3 py-1 rounded-full text-sm transition duration-300">
                                            Xem
                                        </button>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h4
                                        class="font-semibold text-sm text-gray-800 line-clamp-2 hover:text-indigo-600 transition duration-200">
                                        Tên truyện liên quan {{ $i }}
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-1">Chương {{ rand(10, 50) }}</p>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .prose {
            max-width: none;
        }
    </style>

    <script>
        // Auto-expand description if too long
        document.addEventListener('DOMContentLoaded', function() {
            const description = document.querySelector('.prose p');
            if (description && description.textContent.length > 200) {
                const fullText = description.textContent;
                const shortText = fullText.substring(0, 200) + '...';

                description.innerHTML = shortText +
                    ' <button class="text-indigo-600 hover:text-indigo-800 transition duration-200 ml-2" onclick="toggleDescription(this)">Xem thêm</button>';

                window.toggleDescription = function(button) {
                    const p = button.parentElement;
                    if (button.textContent === 'Xem thêm') {
                        p.innerHTML = fullText +
                            ' <button class="text-indigo-600 hover:text-indigo-800 transition duration-200 ml-2" onclick="toggleDescription(this)">Thu gọn</button>';
                    } else {
                        p.innerHTML = shortText +
                            ' <button class="text-indigo-600 hover:text-indigo-800 transition duration-200 ml-2" onclick="toggleDescription(this)">Xem thêm</button>';
                    }
                };
            }
        });

        // Smooth scroll to comments
        function scrollToComments() {
            document.querySelector('.comments-section').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Rating system (mock)
        function rateComic(stars) {
            // Implementation for rating system
            console.log('Rated:', stars, 'stars');
        }
    </script>
</x-app-layout>
