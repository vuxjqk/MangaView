<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-tags mr-2"></i>
                {{ __('Quản Lý Thể Loại') }}
            </h2>
            <a href="{{ route('genres.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out shadow-lg hover:shadow-xl">
                <i class="fas fa-plus mr-2"></i>
                Thêm Thể Loại
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Alert -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 relative"
                    role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="absolute top-0 right-0 px-4 py-3"
                        onclick="this.parentElement.style.display='none'">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Search and Filter Section -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('genres.index') }}" class="flex-1 max-w-md">
                            <div class="relative">
                                <input type="text" name="search" value="{{ $search }}"
                                    placeholder="Tìm kiếm thể loại..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                @if ($search)
                                    <a href="{{ route('genres.index') }}"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </form>

                        <!-- Stats -->
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="flex items-center">
                                <i class="fas fa-list mr-1"></i>
                                Tổng: {{ $genres->total() }} thể loại
                            </span>
                            @if ($search)
                                <span class="flex items-center text-blue-600">
                                    <i class="fas fa-filter mr-1"></i>
                                    Kết quả: {{ $genres->count() }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Genres Table -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6">
                    @if ($genres->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-hashtag mr-1"></i>
                                            ID
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-tag mr-1"></i>
                                            Tên thể loại
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-link mr-1"></i>
                                            Slug
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-align-left mr-1"></i>
                                            Mô tả
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-calendar mr-1"></i>
                                            Ngày tạo
                                        </th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-cogs mr-1"></i>
                                            Thao tác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($genres as $genre)
                                        <tr class="hover:bg-gray-50 transition duration-300">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $genre->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $genre->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <code
                                                    class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">{{ $genre->slug }}</code>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                                {{ $genre->description ?: 'Chưa có mô tả' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $genre->created_at->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <a href="{{ route('genres.show', $genre) }}"
                                                        class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition duration-300"
                                                        title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('genres.edit', $genre) }}"
                                                        class="text-yellow-600 hover:text-yellow-800 p-2 rounded-lg hover:bg-yellow-50 transition duration-300"
                                                        title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('genres.destroy', $genre) }}" method="POST"
                                                        class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition duration-300"
                                                            title="Xóa"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa thể loại này?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-4">
                            @foreach ($genres as $genre)
                                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                            <h3 class="text-lg font-medium text-gray-900">{{ $genre->name }}</h3>
                                        </div>
                                        <span class="text-sm text-gray-500">#{{ $genre->id }}</span>
                                    </div>

                                    <div class="space-y-2 text-sm">
                                        <div class="flex items-center">
                                            <i class="fas fa-link text-gray-400 mr-2 w-4"></i>
                                            <code
                                                class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">{{ $genre->slug }}</code>
                                        </div>

                                        @if ($genre->description)
                                            <div class="flex items-start">
                                                <i class="fas fa-align-left text-gray-400 mr-2 w-4 mt-1"></i>
                                                <p class="text-gray-600 text-sm">
                                                    {{ Str::limit($genre->description, 100) }}</p>
                                            </div>
                                        @endif

                                        <div class="flex items-center">
                                            <i class="fas fa-calendar text-gray-400 mr-2 w-4"></i>
                                            <span
                                                class="text-gray-500">{{ $genre->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-center justify-end space-x-2 mt-4 pt-3 border-t border-gray-100">
                                        <a href="{{ route('genres.show', $genre) }}"
                                            class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition duration-300">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('genres.edit', $genre) }}"
                                            class="text-yellow-600 hover:text-yellow-800 p-2 rounded-lg hover:bg-yellow-50 transition duration-300">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('genres.destroy', $genre) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition duration-300"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa thể loại này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6 flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Hiển thị {{ $genres->firstItem() }} - {{ $genres->lastItem() }}
                                trong tổng số {{ $genres->total() }} kết quả
                            </div>
                            <div class="flex items-center space-x-2">
                                {{ $genres->appends(['search' => $search])->links() }}
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div
                                class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-tags text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                @if ($search)
                                    Không tìm thấy thể loại nào
                                @else
                                    Chưa có thể loại nào
                                @endif
                            </h3>
                            <p class="text-gray-500 mb-6">
                                @if ($search)
                                    Không có thể loại nào khớp với từ khóa "{{ $search }}"
                                @else
                                    Hãy tạo thể loại đầu tiên cho website truyện tranh của bạn
                                @endif
                            </p>
                            @if ($search)
                                <a href="{{ route('genres.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-300">
                                    <i class="fas fa-times mr-2"></i>
                                    Xóa bộ lọc
                                </a>
                            @else
                                <a href="{{ route('genres.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tạo thể loại đầu tiên
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-submit search form -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.form.submit();
                }, 500);
            });
        });
    </script>
</x-app-layout>
