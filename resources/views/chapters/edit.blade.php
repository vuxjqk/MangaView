<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <i class="fas fa-edit mr-2 text-blue-600"></i>
                {{ __('Chỉnh sửa Chapter') }}
            </h2>
            <a href="{{ route('comics.show', $comic) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Comic Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <i class="fas fa-book text-blue-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $comic->title }}</h3>
                            <p class="text-sm text-gray-600">Chỉnh sửa chapter: {{ $chapter->title }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('chapters.update', $chapter) }}" method="POST" enctype="multipart/form-data"
                        id="chapterForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="comic_id" value="{{ $comic->id }}">

                        <!-- Chapter Info Section -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-green-600"></i>
                                Thông tin Chapter
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-heading mr-1"></i>
                                        Tiêu đề Chapter
                                    </label>
                                    <input type="text" id="title" name="title"
                                        value="{{ old('title', $chapter->title) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                        placeholder="Nhập tiêu đề chapter..." required>
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Chapter Number -->
                                <div>
                                    <label for="chapter_number" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-sort-numeric-up mr-1"></i>
                                        Số Chapter
                                    </label>
                                    <input type="number" id="chapter_number" name="chapter_number"
                                        value="{{ old('chapter_number', $chapter->chapter_number) }}" min="1"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                        placeholder="Nhập số chapter..." required>
                                    @error('chapter_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Premium Toggle -->
                            <div class="mt-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_premium" value="1"
                                        {{ old('is_premium', $chapter->is_premium) ? 'checked' : '' }} class="sr-only">
                                    <div class="relative">
                                        <div
                                            class="toggle-bg w-12 h-6 bg-gray-200 rounded-full shadow-inner transition duration-200">
                                        </div>
                                        <div
                                            class="toggle-dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition duration-200">
                                        </div>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-700 flex items-center">
                                        <i class="fas fa-crown mr-1 text-yellow-500"></i>
                                        Chapter Premium
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Current Images Section -->
                        @if ($chapter->chapter_images->count() > 0)
                            <div class="mb-8">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-images mr-2 text-indigo-600"></i>
                                    Ảnh hiện tại
                                    <span class="text-sm text-gray-500 ml-2">({{ $chapter->chapter_images->count() }}
                                        ảnh)</span>
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach ($chapter->chapter_images->sortBy('page_number') as $image)
                                        <div class="relative bg-white rounded-lg shadow-md overflow-hidden">
                                            <img src="{{ asset('storage/' . $image->image_url) }}"
                                                alt="Page {{ $image->page_number }}" class="w-full h-32 object-cover">
                                            <div class="p-2">
                                                <p class="text-xs text-gray-600">Trang {{ $image->page_number }}</p>
                                                <p class="text-xs text-gray-500">{{ strtoupper($image->format) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                                        <p class="text-sm text-yellow-800">
                                            <strong>Lưu ý:</strong> Nếu bạn tải lên ảnh mới, tất cả ảnh hiện tại sẽ bị
                                            thay thế.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Image Upload Section -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-images mr-2 text-purple-600"></i>
                                {{ $chapter->chapter_images->count() > 0 ? 'Thay thế ảnh Chapter' : 'Ảnh Chapter' }}
                                <span class="text-sm text-gray-500 ml-2">(Tối đa 4MB mỗi ảnh)</span>
                            </h4>

                            <!-- Upload Area -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition duration-200 bg-gray-50"
                                id="uploadArea">
                                <div class="mb-4">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-600 mb-2">
                                        {{ $chapter->chapter_images->count() > 0 ? 'Kéo thả ảnh mới vào đây hoặc' : 'Kéo thả ảnh vào đây hoặc' }}
                                    </p>
                                    <button type="button" onclick="document.getElementById('images').click()"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                        <i class="fas fa-folder-open mr-2"></i>
                                        {{ $chapter->chapter_images->count() > 0 ? 'Chọn ảnh mới' : 'Chọn ảnh' }}
                                    </button>
                                </div>
                                <p class="text-sm text-gray-500">
                                    Hỗ trợ: JPG, JPEG, PNG, WEBP
                                </p>
                                @if ($chapter->chapter_images->count() > 0)
                                    <p class="text-sm text-gray-500 mt-2">
                                        Để trống nếu không muốn thay đổi ảnh
                                    </p>
                                @endif
                            </div>

                            <input type="file" id="images" name="images[]" multiple accept="image/*"
                                class="hidden" {{ $chapter->chapter_images->count() > 0 ? '' : 'required' }}>

                            @error('images')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preview Area -->
                        <div id="previewArea" class="mb-8 hidden">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-eye mr-2 text-indigo-600"></i>
                                Xem trước ảnh mới
                            </h4>
                            <div id="imagePreview" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <!-- Preview images will be inserted here -->
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Vui lòng kiểm tra kỹ thông tin trước khi cập nhật
                            </div>
                            <div class="flex space-x-3">
                                <button type="button"
                                    onclick="window.location.href='{{ route('comics.show', $comic->id) }}'"
                                    class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                                    <i class="fas fa-times mr-2"></i>
                                    Hủy
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-200 flex items-center">
                                    <i class="fas fa-save mr-2"></i>
                                    Cập nhật Chapter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .toggle-bg {
            transition: background-color 0.2s;
        }

        .toggle-dot {
            transition: transform 0.2s;
        }

        input[type="checkbox"]:checked+div .toggle-bg {
            background-color: #3b82f6;
        }

        input[type="checkbox"]:checked+div .toggle-dot {
            transform: translateX(100%);
        }

        .preview-item {
            position: relative;
            group: hover;
        }

        .preview-item:hover .remove-btn {
            opacity: 1;
        }

        .remove-btn {
            opacity: 0;
            transition: opacity 0.2s;
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('images');
            const previewArea = document.getElementById('previewArea');
            const imagePreview = document.getElementById('imagePreview');
            let selectedFiles = [];

            // Check if there are existing images
            const hasExistingImages = {{ $chapter->chapter_images->count() > 0 ? 'true' : 'false' }};

            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('border-blue-400', 'bg-blue-50');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-400', 'bg-blue-50');

                const files = Array.from(e.dataTransfer.files);
                handleFiles(files);
            });

            // File input change
            fileInput.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);
                handleFiles(files);
            });

            function handleFiles(files) {
                selectedFiles = [...selectedFiles, ...files];
                updateFileInput();
                showPreview();
            }

            function updateFileInput() {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
            }

            function showPreview() {
                if (selectedFiles.length > 0) {
                    previewArea.classList.remove('hidden');
                    imagePreview.innerHTML = '';

                    selectedFiles.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const previewItem = document.createElement('div');
                            previewItem.className =
                                'preview-item relative bg-white rounded-lg shadow-md overflow-hidden group';
                            previewItem.innerHTML = `
                                <img src="${e.target.result}" alt="Preview" class="w-full h-32 object-cover">
                                <div class="p-2">
                                    <p class="text-xs text-gray-600 truncate">${file.name}</p>
                                    <p class="text-xs text-gray-500">Trang ${index + 1}</p>
                                </div>
                                <button type="button" 
                                        onclick="removeFile(${index})"
                                        class="remove-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition duration-200">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            `;
                            imagePreview.appendChild(previewItem);
                        };
                        reader.readAsDataURL(file);
                    });
                } else {
                    previewArea.classList.add('hidden');
                }
            }

            // Make removeFile function global
            window.removeFile = function(index) {
                selectedFiles.splice(index, 1);
                updateFileInput();
                showPreview();
            };

            // Form validation
            document.getElementById('chapterForm').addEventListener('submit', function(e) {
                // Only require images if there are no existing images
                if (!hasExistingImages && selectedFiles.length === 0) {
                    e.preventDefault();
                    alert('Vui lòng chọn ít nhất một ảnh cho chapter!');
                    return false;
                }

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang cập nhật...';
                submitBtn.disabled = true;
            });
        });
    </script>
</x-app-layout>
