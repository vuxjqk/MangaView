<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $chapter->title }} - Chapter {{ $chapter->chapter_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        .reader-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .reader-content {
            background: #1a1a1a;
            min-height: 100vh;
        }

        .image-container {
            transition: all 0.3s ease;
        }

        .image-container img {
            transition: transform 0.3s ease;
        }

        .image-container:hover img {
            transform: scale(1.02);
        }

        .control-panel {
            backdrop-filter: blur(10px);
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .mode-button {
            transition: all 0.3s ease;
        }

        .mode-button.active {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
        }

        .progress-bar {
            transition: width 0.3s ease;
        }

        .horizontal-scroll {
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
        }

        .horizontal-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .horizontal-scroll::-webkit-scrollbar-track {
            background: #2d2d2d;
        }

        .horizontal-scroll::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 4px;
        }

        .page-indicator {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            z-index: 1000;
        }

        .zoom-controls {
            position: fixed;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            z-index: 1000;
        }

        .loading-spinner {
            display: none;
        }

        .loading-spinner.active {
            display: block;
        }

        .chapter-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .vertical-mode .chapter-image {
            margin-bottom: 10px;
        }

        .horizontal-mode .chapter-image {
            display: inline-block;
            margin-right: 10px;
            height: 100vh;
            width: auto;
        }

        .fullscreen-mode {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: #000;
            z-index: 9999;
        }

        .reader-header {
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navigation-arrows {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1000;
        }

        .navigation-arrows button {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .navigation-arrows button:hover {
            background: rgba(102, 126, 234, 0.8);
            transform: scale(1.1);
        }

        .left-arrow {
            left: 20px;
        }

        .right-arrow {
            right: 20px;
        }
    </style>
</head>

<body class="bg-gray-900">
    <div class="reader-container">
        <!-- Header -->
        <div class="reader-header">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center justify-between">
                    <!-- Back Button & Info -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('comics.show', $chapter->comic_id) }}"
                            class="text-white hover:text-blue-400 transition duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Quay lại
                        </a>
                        <div class="text-white">
                            <h1 class="text-lg font-semibold">{{ $chapter->title }}</h1>
                            <p class="text-sm text-gray-300">Chapter {{ $chapter->chapter_number }}</p>
                        </div>
                    </div>

                    <!-- Premium Badge -->
                    @if ($chapter->is_premium)
                        <div
                            class="flex items-center bg-yellow-500 text-black px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-crown mr-1"></i>
                            Premium
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Control Panel -->
        <div class="control-panel sticky top-16 z-50 p-4">
            <div class="container mx-auto flex items-center justify-between">
                <!-- Reading Mode Toggle -->
                <div class="flex items-center space-x-2">
                    <button id="verticalMode"
                        class="mode-button active px-4 py-2 rounded-lg text-white bg-gray-600 hover:bg-gray-500">
                        <i class="fas fa-arrows-alt-v mr-2"></i>
                        Cuộn dọc
                    </button>
                    <button id="horizontalMode"
                        class="mode-button px-4 py-2 rounded-lg text-white bg-gray-600 hover:bg-gray-500">
                        <i class="fas fa-arrows-alt-h mr-2"></i>
                        Cuộn ngang
                    </button>
                </div>

                <!-- Controls -->
                <div class="flex items-center space-x-4">
                    <!-- Zoom Controls -->
                    <div class="flex items-center space-x-2">
                        <button id="zoomOut" class="text-white hover:text-blue-400 p-2">
                            <i class="fas fa-search-minus"></i>
                        </button>
                        <span id="zoomLevel" class="text-white text-sm">100%</span>
                        <button id="zoomIn" class="text-white hover:text-blue-400 p-2">
                            <i class="fas fa-search-plus"></i>
                        </button>
                    </div>

                    <!-- Fullscreen -->
                    <button id="fullscreenBtn" class="text-white hover:text-blue-400 p-2">
                        <i class="fas fa-expand"></i>
                    </button>

                    <!-- Settings -->
                    <div class="relative">
                        <button id="settingsBtn" class="text-white hover:text-blue-400 p-2">
                            <i class="fas fa-cog"></i>
                        </button>
                        <div id="settingsMenu"
                            class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-xl hidden">
                            <div class="p-4">
                                <div class="mb-3">
                                    <label class="block text-white text-sm mb-2">Độ sáng</label>
                                    <input type="range" id="brightnessSlider" min="50" max="150"
                                        value="100" class="w-full">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-white text-sm mb-2">Tốc độ cuộn</label>
                                    <select id="scrollSpeed" class="w-full bg-gray-700 text-white rounded p-2">
                                        <option value="slow">Chậm</option>
                                        <option value="medium" selected>Trung bình</option>
                                        <option value="fast">Nhanh</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="sticky top-24 z-40 bg-gray-800 h-1">
            <div id="progressBar" class="progress-bar h-full bg-gradient-to-r from-blue-500 to-purple-600"
                style="width: 0%"></div>
        </div>

        <!-- Reader Content -->
        <div class="reader-content">
            <div id="readerImages" class="vertical-mode">
                @foreach ($chapter->chapter_images()->orderBy('page_number')->get() as $image)
                    <div class="image-container" data-page="{{ $image->page_number }}">
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Trang {{ $image->page_number }}"
                            class="chapter-image" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Navigation Arrows -->
        <div class="navigation-arrows">
            <button class="left-arrow" id="prevPage">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="right-arrow" id="nextPage">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <!-- Page Indicator -->
        <div class="page-indicator">
            <span id="currentPage">1</span> / <span id="totalPages">{{ $chapter->chapter_images()->count() }}</span>
        </div>

        <!-- Loading Spinner -->
        <div class="loading-spinner fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="text-white text-center">
                <i class="fas fa-spinner fa-spin text-4xl mb-4"></i>
                <p>Đang tải...</p>
            </div>
        </div>

        <!-- Chapter Navigation -->
        <div class="bg-gray-800 p-6 mt-8">
            <div class="container mx-auto">
                <div class="flex items-center justify-between">
                    @if ($chapter->chapter_number > 1)
                        <a href="{{ route('chapters.show', $chapter->chapter_number - 1) }}"
                            class="flex items-center text-white hover:text-blue-400 transition duration-200">
                            <i class="fas fa-chevron-left mr-2"></i>
                            Chapter trước
                        </a>
                    @else
                        <div></div>
                    @endif

                    <div class="text-center text-white">
                        <p class="text-sm text-gray-400">Cảm ơn bạn đã đọc!</p>
                        <div class="flex items-center justify-center space-x-4 mt-2">
                            <button class="hover:text-red-400 transition duration-200">
                                <i class="fas fa-heart mr-1"></i>
                                Yêu thích
                            </button>
                            <button class="hover:text-blue-400 transition duration-200">
                                <i class="fas fa-share mr-1"></i>
                                Chia sẻ
                            </button>
                        </div>
                    </div>

                    <a href="{{ route('chapters.show', $chapter->chapter_number + 1) }}"
                        class="flex items-center text-white hover:text-blue-400 transition duration-200">
                        Chapter sau
                        <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const readerImages = document.getElementById('readerImages');
            const verticalModeBtn = document.getElementById('verticalMode');
            const horizontalModeBtn = document.getElementById('horizontalMode');
            const zoomInBtn = document.getElementById('zoomIn');
            const zoomOutBtn = document.getElementById('zoomOut');
            const zoomLevel = document.getElementById('zoomLevel');
            const fullscreenBtn = document.getElementById('fullscreenBtn');
            const settingsBtn = document.getElementById('settingsBtn');
            const settingsMenu = document.getElementById('settingsMenu');
            const brightnessSlider = document.getElementById('brightnessSlider');
            const progressBar = document.getElementById('progressBar');
            const currentPageSpan = document.getElementById('currentPage');
            const totalPagesSpan = document.getElementById('totalPages');
            const prevPageBtn = document.getElementById('prevPage');
            const nextPageBtn = document.getElementById('nextPage');

            let currentZoom = 100;
            let currentMode = 'vertical';
            let currentPageIndex = 0;
            const totalPages = {{ $chapter->chapter_images()->count() }};

            // Mode switching
            verticalModeBtn.addEventListener('click', function() {
                switchMode('vertical');
            });

            horizontalModeBtn.addEventListener('click', function() {
                switchMode('horizontal');
            });

            function switchMode(mode) {
                currentMode = mode;

                if (mode === 'vertical') {
                    readerImages.className = 'vertical-mode';
                    verticalModeBtn.classList.add('active');
                    horizontalModeBtn.classList.remove('active');
                } else {
                    readerImages.className = 'horizontal-mode horizontal-scroll';
                    horizontalModeBtn.classList.add('active');
                    verticalModeBtn.classList.remove('active');
                }

                updateProgress();
            }

            // Zoom controls
            zoomInBtn.addEventListener('click', function() {
                if (currentZoom < 200) {
                    currentZoom += 25;
                    applyZoom();
                }
            });

            zoomOutBtn.addEventListener('click', function() {
                if (currentZoom > 50) {
                    currentZoom -= 25;
                    applyZoom();
                }
            });

            function applyZoom() {
                const images = document.querySelectorAll('.chapter-image');
                images.forEach(img => {
                    img.style.transform = `scale(${currentZoom / 100})`;
                });
                zoomLevel.textContent = currentZoom + '%';
            }

            // Fullscreen
            fullscreenBtn.addEventListener('click', function() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                    fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
                } else {
                    document.exitFullscreen();
                    fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
                }
            });

            // Settings menu
            settingsBtn.addEventListener('click', function() {
                settingsMenu.classList.toggle('hidden');
            });

            // Brightness control
            brightnessSlider.addEventListener('input', function() {
                const brightness = this.value;
                document.body.style.filter = `brightness(${brightness}%)`;
            });

            // Progress tracking
            function updateProgress() {
                if (currentMode === 'vertical') {
                    window.addEventListener('scroll', function() {
                        const scrolled = window.pageYOffset;
                        const maxHeight = document.body.scrollHeight - window.innerHeight;
                        const progress = (scrolled / maxHeight) * 100;
                        progressBar.style.width = progress + '%';

                        // Update current page based on scroll position
                        const images = document.querySelectorAll('.image-container');
                        images.forEach((img, index) => {
                            const rect = img.getBoundingClientRect();
                            if (rect.top <= window.innerHeight / 2 && rect.bottom >= window
                                .innerHeight / 2) {
                                currentPageIndex = index;
                                currentPageSpan.textContent = index + 1;
                            }
                        });
                    });
                } else {
                    readerImages.addEventListener('scroll', function() {
                        const scrolled = this.scrollLeft;
                        const maxWidth = this.scrollWidth - this.clientWidth;
                        const progress = (scrolled / maxWidth) * 100;
                        progressBar.style.width = progress + '%';
                    });
                }
            }

            // Navigation arrows
            prevPageBtn.addEventListener('click', function() {
                if (currentPageIndex > 0) {
                    currentPageIndex--;
                    scrollToPage(currentPageIndex);
                }
            });

            nextPageBtn.addEventListener('click', function() {
                if (currentPageIndex < totalPages - 1) {
                    currentPageIndex++;
                    scrollToPage(currentPageIndex);
                }
            });

            function scrollToPage(pageIndex) {
                const images = document.querySelectorAll('.image-container');
                if (images[pageIndex]) {
                    images[pageIndex].scrollIntoView({
                        behavior: 'smooth',
                        block: currentMode === 'vertical' ? 'start' : 'nearest',
                        inline: currentMode === 'horizontal' ? 'start' : 'nearest'
                    });
                    currentPageSpan.textContent = pageIndex + 1;
                }
            }

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                switch (e.key) {
                    case 'ArrowLeft':
                        if (currentPageIndex > 0) {
                            currentPageIndex--;
                            scrollToPage(currentPageIndex);
                        }
                        break;
                    case 'ArrowRight':
                        if (currentPageIndex < totalPages - 1) {
                            currentPageIndex++;
                            scrollToPage(currentPageIndex);
                        }
                        break;
                    case 'f':
                    case 'F':
                        fullscreenBtn.click();
                        break;
                    case 'v':
                    case 'V':
                        verticalModeBtn.click();
                        break;
                    case 'h':
                    case 'H':
                        horizontalModeBtn.click();
                        break;
                }
            });

            // Initialize
            updateProgress();
            totalPagesSpan.textContent = totalPages;

            // Hide loading spinner
            document.querySelector('.loading-spinner').classList.remove('active');

            // Auto-hide controls after inactivity
            let hideControlsTimeout;

            function resetHideControlsTimeout() {
                clearTimeout(hideControlsTimeout);
                hideControlsTimeout = setTimeout(() => {
                    // Hide controls logic here if needed
                }, 3000);
            }

            document.addEventListener('mousemove', resetHideControlsTimeout);
            document.addEventListener('keydown', resetHideControlsTimeout);
        });
    </script>
</body>

</html>
