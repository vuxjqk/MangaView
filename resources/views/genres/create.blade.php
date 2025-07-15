<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-tags mr-2"></i>
                {{ __('Thêm Thể Loại Mới') }}
            </h2>
            <a href="{{ route('genres.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                <i class="fas fa-arrow-left mr-2"></i>
                Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">
                            <i class="fas fa-plus-circle text-blue-500 mr-2"></i>
                            Tạo Thể Loại Truyện Tranh
                        </h3>
                        <p class="text-gray-600">Điền thông tin để tạo thể loại mới cho website truyện tranh</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('genres.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Tên thể loại -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag mr-1"></i>
                                Tên thể loại <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
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
                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
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
                                placeholder="Nhập mô tả chi tiết về thể loại này...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
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
                                Tạo Thể Loại
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-generate slug script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

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

            nameInput.addEventListener('input', function() {
                if (slugInput.value === '' || slugInput.dataset.autoGenerated !== 'false') {
                    slugInput.value = generateSlug(this.value);
                    slugInput.dataset.autoGenerated = 'true';
                }
            });

            slugInput.addEventListener('input', function() {
                this.dataset.autoGenerated = 'false';
            });
        });
    </script>
</x-app-layout>
