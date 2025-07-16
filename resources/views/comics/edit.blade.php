<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <i class="fas fa-edit mr-2 text-indigo-600"></i>
                {{ __('Chỉnh sửa truyện tranh') }}
            </h2>
            <a href="{{ route('comics.show', $comic) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Card container -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-edit mr-2"></i>
                        Chỉnh sửa thông tin truyện tranh
                    </h3>
                </div>

                <!-- Form -->
                <div class="p-6">
                    <form action="{{ route('comics.update', $comic) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-heading mr-2 text-indigo-600"></i>
                                Tiêu đề truyện <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title"
                                value="{{ old('title', $comic->title) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('title') border-red-500 @enderror"
                                placeholder="Nhập tiêu đề truyện tranh..." required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Author -->
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user-edit mr-2 text-indigo-600"></i>
                                Tác giả
                            </label>
                            <input type="text" id="author" name="author"
                                value="{{ old('author', $comic->author) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('author') border-red-500 @enderror"
                                placeholder="Nhập tên tác giả...">
                            @error('author')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-2 text-indigo-600"></i>
                                Mô tả
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('description') border-red-500 @enderror"
                                placeholder="Nhập mô tả về truyện tranh...">{{ old('description', $comic->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Row for Status, Language, and Genres -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-info-circle mr-2 text-indigo-600"></i>
                                    Trạng thái
                                </label>
                                <select id="status" name="status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('status') border-red-500 @enderror">
                                    <option value="ongoing"
                                        {{ old('status', $comic->status) == 'ongoing' ? 'selected' : '' }}>
                                        <i class="fas fa-play-circle"></i> Đang tiến hành
                                    </option>
                                    <option value="completed"
                                        {{ old('status', $comic->status) == 'completed' ? 'selected' : '' }}>
                                        <i class="fas fa-check-circle"></i> Đã hoàn thành
                                    </option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Language -->
                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-language mr-2 text-indigo-600"></i>
                                    Ngôn ngữ
                                </label>
                                <select id="language" name="language"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('language') border-red-500 @enderror">
                                    <option value="vi"
                                        {{ old('language', $comic->language) == 'vi' ? 'selected' : '' }}>
                                        🇻🇳 Tiếng Việt
                                    </option>
                                    <option value="en"
                                        {{ old('language', $comic->language) == 'en' ? 'selected' : '' }}>
                                        🇺🇸 English
                                    </option>
                                </select>
                                @error('language')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Genres -->
                        <div>
                            <label for="genres" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tags mr-2 text-indigo-600"></i>
                                Thể loại
                            </label>
                            <select id="genres" name="genres[]" multiple
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('genres') border-red-500 @enderror">
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}"
                                        {{ in_array($genre->id, old('genres', $comic->genres->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Giữ phím Ctrl/Cmd để chọn nhiều thể loại</p>
                            @error('genres')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Current Cover Image -->
                        @if ($comic->cover_image)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-image mr-2 text-indigo-600"></i>
                                    Ảnh bìa hiện tại
                                </label>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $comic->cover_image) }}" alt="Current cover"
                                        class="h-32 w-24 object-cover rounded-lg border-2 border-gray-200">
                                    <div>
                                        <p class="text-sm text-gray-600">Ảnh bìa hiện tại</p>
                                        <p class="text-xs text-gray-500">Chọn ảnh mới để thay thế</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Cover Image -->
                        <div>
                            <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-image mr-2 text-indigo-600"></i>
                                {{ $comic->cover_image ? 'Thay đổi ảnh bìa' : 'Ảnh bìa' }}
                            </label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition duration-200">
                                <div class="space-y-1 text-center">
                                    <div class="flex text-sm text-gray-600">
                                        <label for="cover_image"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                                <span>{{ $comic->cover_image ? 'Chọn ảnh bìa mới' : 'Tải lên ảnh bìa' }}</span>
                                            </div>
                                            <input id="cover_image" name="cover_image" type="file"
                                                accept="image/*" class="sr-only">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 2MB</p>
                                </div>
                            </div>
                            @error('cover_image')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Preview area for uploaded image -->
                        <div id="imagePreview" class="hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-eye mr-2 text-indigo-600"></i>
                                Xem trước ảnh bìa mới:
                            </p>
                            <div class="relative inline-block">
                                <img id="previewImg"
                                    class="h-32 w-24 object-cover rounded-lg border-2 border-gray-200">
                                <button type="button" id="removeImage"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition duration-200">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <button type="button"
                                onclick="window.location.href='{{ route('comics.show', $comic) }}'"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Hủy
                            </button>
                            <button type="submit"
                                class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg transition duration-200 flex items-center shadow-lg">
                                <i class="fas fa-save mr-2"></i>
                                Cập nhật truyện tranh
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="text-sm font-medium text-blue-800 mb-2 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Hướng dẫn chỉnh sửa
                </h4>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Tiêu đề truyện là bắt buộc và không được vượt quá 255 ký tự</li>
                    <li>• Ảnh bìa chỉ chấp nhận các định dạng: JPG, JPEG, PNG, GIF (tối đa 2MB)</li>
                    <li>• Nếu không chọn ảnh mới, ảnh bìa cũ sẽ được giữ nguyên</li>
                    <li>• Bạn có thể thay đổi thể loại bằng cách chọn/bỏ chọn trong danh sách</li>
                    <li>• Các thay đổi sẽ có hiệu lực ngay sau khi cập nhật</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- JavaScript for image preview -->
    <script>
        document.getElementById('cover_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('removeImage').addEventListener('click', function() {
            document.getElementById('cover_image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
        });
    </script>
</x-app-layout>
