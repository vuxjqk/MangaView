<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-eye mr-2"></i>
                {{ __('Chi Tiết Thể Loại') }}
            </h2>
            <div class="flex items-center space-x-3">
                <a href="{{ route('genres.edit', $genre) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                    <i class="fas fa-edit mr-2"></i>
                    Chỉnh Sửa
                </a>
                <a href="{{ route('genres.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay Lại
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Info Card -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="px-6 py-8">
                    <!-- Header with Badge -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-4"></div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $genre->name }}</h1>
                                <p class="text-gray-600 mt-1">Thể loại truyện tranh</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-hashtag mr-1"></i>
                                ID: {{ $genre->id }}
                            </div>
                        </div>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">
                                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                    Thông Tin Cơ Bản
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-20">Tên:</span>
                                        <span class="font-medium text-gray-900">{{ $genre->name }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-20">Slug:</span>
                                        <code
                                            class="px-2 py-1 bg-gray-200 text-gray-800 text-sm rounded">{{ $genre->slug }}</code>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-gray-500 w-20">Mô tả:</span>
                                        <div class="flex-1">
                                            @if ($genre->description)
                                                <p class="text-gray-700 leading-relaxed">{{ $genre->description }}</p>
                                            @else
                                                <span class="text-gray-400 italic">Chưa có mô tả</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">
                                    <i class="fas fa-clock text-green-500 mr-2"></i>
                                    Thời Gian
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-20">Tạo:</span>
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-plus text-green-600 mr-2"></i>
                                            <span
                                                class="text-gray-700">{{ $genre->created_at->format('d/m/Y H:i:s') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-20">Cập nhật:</span>
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-edit text-blue-600 mr-2"></i>
                                            <span
                                                class="text-gray-700">{{ $genre->updated_at->format('d/m/Y H:i:s') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-20">Tồn tại:</span>
                                        <div class="flex items-center">
                                            <i class="fas fa-hourglass-half text-purple-600 mr-2"></i>
                                            <span
                                                class="text-gray-700">{{ $genre->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- URL Preview Card -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="px-6 py-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-link text-blue-500 mr-2"></i>
                        URL Preview
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center space-x-2 mb-2">
                            <i class="fas fa-globe text-blue-500"></i>
                            <span class="text-sm text-gray-600">URL thể loại:</span>
                        </div>
                        <div class="font-mono text-sm bg-white border rounded p-2 text-blue-600">
                            {{ url('/genres/' . $genre->slug) }}
                        </div>
                        <div class="mt-3 flex items-center space-x-4">
                            <button onclick="copyToClipboard('{{ url('/genres/' . $genre->slug) }}')"
                                class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                <i class="fas fa-copy mr-1"></i>
                                Sao chép
                            </button>
                            <a href="{{ url('/genres/' . $genre->slug) }}" target="_blank"
                                class="text-green-600 hover:text-green-800 text-sm flex items-center">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                Mở trong tab mới
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card (if you have manga/comics relationship) -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="px-6 py-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-chart-bar text-purple-500 mr-2"></i>
                        Thống Kê
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-blue-600 mb-1">
                                {{-- {{ $genre->comics_count ?? 0 }} --}}
                                0
                            </div>
                            <div class="text-sm text-blue-800">
                                <i class="fas fa-book mr-1"></i>
                                Truyện tranh
                            </div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-green-600 mb-1">
                                {{-- {{ $genre->active_comics_count ?? 0 }} --}}
                                0
                            </div>
                            <div class="text-sm text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Đang hoạt động
                            </div>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-yellow-600 mb-1">
                                {{-- {{ $genre->popular_comics_count ?? 0 }} --}}
                                0
                            </div>
                            <div class="text-sm text-yellow-800">
                                <i class="fas fa-star mr-1"></i>
                                Phổ biến
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="px-6 py-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-cogs text-gray-500 mr-2"></i>
                        Hành Động
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('genres.edit', $genre) }}"
                            class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg">
                            <i class="fas fa-edit mr-2"></i>
                            Chỉnh Sửa Thể Loại
                        </a>

                        <a href="{{ route('genres.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg">
                            <i class="fas fa-plus mr-2"></i>
                            Tạo Thể Loại Mới
                        </a>

                        <button onclick="printGenreInfo()"
                            class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg">
                            <i class="fas fa-print mr-2"></i>
                            In Thông Tin
                        </button>

                        <form action="{{ route('genres.destroy', $genre) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa thể loại này? Hành động này không thể hoàn tác!')">
                                <i class="fas fa-trash mr-2"></i>
                                Xóa Thể Loại
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                showNotification('Đã sao chép URL vào clipboard!', 'success');
            }, function(err) {
                console.error('Could not copy text: ', err);
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showNotification('Đã sao chép URL vào clipboard!', 'success');
            });
        }

        // Print genre info
        function printGenreInfo() {
            const printContent = `
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
                    <h1 style="color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px;">
                        Chi Tiết Thể Loại: {{ $genre->name }}
                    </h1>
                    
                    <div style="margin: 20px 0;">
                        <h2 style="color: #666; font-size: 18px;">Thông Tin Cơ Bản</h2>
                        <table style="width: 100%; border-collapse: collapse; margin: 10px 0;">
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; width: 150px;"><strong>ID:</strong></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $genre->id }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;"><strong>Tên:</strong></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $genre->name }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;"><strong>Slug:</strong></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $genre->slug }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;"><strong>Mô tả:</strong></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $genre->description ?: 'Chưa có mô tả' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;"><strong>Ngày tạo:</strong></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $genre->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;"><strong>Cập nhật:</strong></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $genre->updated_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div style="margin: 20px 0;">
                        <h2 style="color: #666; font-size: 18px;">URL</h2>
                        <p style="background: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace;">
                            {{ url('/genres/' . $genre->slug) }}
                        </p>
                    </div>
                    
                    <div style="margin-top: 30px; text-align: center; color: #666; font-size: 12px;">
                        <p>In lúc: ${new Date().toLocaleString('vi-VN')}</p>
                    </div>
                </div>
            `;

            const printWindow = window.open('', '_blank');
            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.print();
        }

        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transition-all duration-300 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
                    ${message}
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>
</x-app-layout>
