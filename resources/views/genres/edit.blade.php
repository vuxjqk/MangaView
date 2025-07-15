<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-edit mr-2"></i>
                {{ __('Chỉnh Sửa Thể Loại') }}
            </h2>
            <div class="flex items-center space-x-3">
                <a href="{{ route('genres.show', $genre) }}"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                    <i class="fas fa-eye mr-2"></i>
                    Xem Chi Tiết
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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                    <i class="fas fa-edit text-yellow-500 mr-2"></i>
                                    Chỉnh Sửa Thể Loại: {{ $genre->name }}
                                </h3>
                                <p class="text-gray-600">Cập nhật thông tin thể loại truyện tranh</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-hashtag mr-1"></i>
                                    ID: {{ $genre->id }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Tạo: {{ $genre->created_at->format('d/m/Y H:i') }}
                                </div>
                                @if ($genre->updated_at != $genre->created_at)
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        Sửa: {{ $genre->updated_at->format('d/m/Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('genres.update', $genre) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Tên thể loại -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag mr-1"></i>
                                Tên thể loại <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $genre->name) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 @error('name') border-red-500 @enderror"
                                placeholder="Ví dụ: Hành động, Tình cảm, Kinh dị..." required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-link mr-1"></i>
                                Slug URL <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $genre->slug) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 @error('slug') border-red-500 @enderror"
                                placeholder="Ví dụ: hanh-dong, tinh-cam, kinh-di..." required>
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Slug sẽ được sử dụng trong URL. Chỉ dùng chữ thường, số và dấu gạch ngang.
                            </p>
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Mô tả -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-1"></i>
                                Mô tả thể loại
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 @error('description') border-red-500 @enderror"
                                placeholder="Nhập mô tả chi tiết về thể loại này...">{{ old('description', $genre->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Comparison Section -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-history mr-1"></i>
                                So sánh thay đổi
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <div class="font-medium text-gray-600 mb-1">Giá trị hiện tại:</div>
                                    <div class="space-y-1">
                                        <div class="flex items-center">
                                            <span class="text-gray-500 w-16">Tên:</span>
                                            <span class="font-medium">{{ $genre->name }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-gray-500 w-16">Slug:</span>
                                            <code
                                                class="px-2 py-1 bg-gray-200 text-gray-800 text-xs rounded">{{ $genre->slug }}</code>
                                        </div>
                                        <div class="flex items-start">
                                            <span class="text-gray-500 w-16">Mô tả:</span>
                                            <span class="text-gray-700">{{ $genre->description ?: 'Chưa có' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-600 mb-1">Giá trị mới:</div>
                                    <div class="space-y-1">
                                        <div class="flex items-center">
                                            <span class="text-gray-500 w-16">Tên:</span>
                                            <span class="font-medium text-blue-600"
                                                id="preview-name">{{ $genre->name }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-gray-500 w-16">Slug:</span>
                                            <code class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded"
                                                id="preview-slug">{{ $genre->slug }}</code>
                                        </div>
                                        <div class="flex items-start">
                                            <span class="text-gray-500 w-16">Mô tả:</span>
                                            <span class="text-blue-600"
                                                id="preview-description">{{ $genre->description ?: 'Chưa có' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('genres.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out">
                                <i class="fas fa-times mr-2"></i>
                                Hủy
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out shadow-lg hover:shadow-xl">
                                <i class="fas fa-save mr-2"></i>
                                Cập Nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const descriptionInput = document.getElementById('description');

            const previewName = document.getElementById('preview-name');
            const previewSlug = document.getElementById('preview-slug');
            const previewDescription = document.getElementById('preview-description');

            // Generate slug function
            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .replace(/[áàảãạâấầẩẫậăắằẳẵặ]/g, 'a')
                    .replace(/[éèẻẽẹêếềểễệ]/g, 'e')
                    .replace(/[íìỉĩị]/g, 'i')
                    .replace(/[óòỏõọôốồổỗộơớờởỡợ]/g, 'o')
                    .replace(/[úùủũụưứừửữự]/g, 'u')
                    .replace(/[ýỳỷỹỵ]/g, 'y')
                    .replace(/đ/g, 'd')
                    .replace(/[^a-z0-9\s-]/g, '')
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }

            // Auto-generate slug from name
            nameInput.addEventListener('input', function() {
                if (slugInput.value === '{{ $genre->slug }}' || slugInput.dataset.autoGenerated !==
                    'false') {
                    slugInput.value = generateSlug(this.value);
                    slugInput.dataset.autoGenerated = 'true';
                }
                previewName.textContent = this.value || '{{ $genre->name }}';
            });

            // Slug input handler
            slugInput.addEventListener('input', function() {
                this.dataset.autoGenerated = 'false';
                previewSlug.textContent = this.value || '{{ $genre->slug }}';
            });

            // Description preview
            descriptionInput.addEventListener('input', function() {
                previewDescription.textContent = this.value || 'Chưa có';
            });

            // Form submission confirmation
            document.querySelector('form').addEventListener('submit', function(e) {
                const hasChanges =
                    nameInput.value !== '{{ $genre->name }}' ||
                    slugInput.value !== '{{ $genre->slug }}' ||
                    descriptionInput.value !== '{{ $genre->description }}';

                if (!hasChanges) {
                    e.preventDefault();
                    alert('Không có thay đổi nào để cập nhật.');
                    return false;
                }

                if (!confirm('Bạn có chắc chắn muốn cập nhật thể loại này?')) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
</x-app-layout>
