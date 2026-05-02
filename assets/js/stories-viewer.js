(function ($) {
    'use strict';

    $(document).ready(function () {
        const $viewer = $('#storyViewer');
        const $image = $('#storyImage');
        const $authorAvatar = $('#storyAuthorAvatar');
        const $authorName = $('#storyAuthorName');
        const $time = $('#storyTime');
        const $title = $('#storyTitle');
        const $link = $('#storyLink');
        const $progressContainer = $('#storyProgress');
        const $items = $('.story-item');

        let currentIndex = 0;
        let progressTimer;
        const STORY_DURATION = 5000; // 5 seconds per story

        function openStory(index) {
            currentIndex = index;
            $viewer.removeClass('hidden').addClass('active');
            $('body').css('overflow', 'hidden');
            updateStoryContent();
            createProgressBars();
            startProgress();
        }

        function closeStory() {
            $viewer.removeClass('active').addClass('hidden');
            $('body').css('overflow', '');
            clearTimeout(progressTimer);
        }

        function createProgressBars() {
            $progressContainer.empty();
            $items.each(function (i) {
                const $segment = $('<div class="progress-segment"></div>');
                const $fill = $('<div class="progress-fill"></div>');
                $segment.append($fill);
                $progressContainer.append($segment);
            });
        }

        function updateStoryContent() {
            const $item = $items.eq(currentIndex);
            const data = $item.data();

            $image.attr('src', data.image);
            $image.removeClass('story-image-animate');
            if ($image.length) {
                void $image[0].offsetWidth;
            }
            $image.addClass('story-image-animate');
            $authorAvatar.attr('src', data.avatar);
            $authorName.text(data.author);
            $time.text(data.time);
            $title.text(data.title);
            $link.attr('href', data.url);

            // Update viewed status for progress bars
            const $segments = $('.progress-segment');
            $segments.each(function (i) {
                const $fill = $(this).find('.progress-fill');
                $fill.stop();

                if (i < currentIndex) {
                    $fill.css('width', '100%');
                } else if (i > currentIndex) {
                    $fill.css('width', '0%');
                }
            });
        }

        function startProgress() {
            const $currentFill = $('.progress-segment').eq(currentIndex).find('.progress-fill');
            $currentFill.css('width', '0%').animate({
                width: '100%'
            }, STORY_DURATION, 'linear', function () {
                if (currentIndex < $items.length - 1) {
                    currentIndex++;
                    updateStoryContent();
                    startProgress();
                } else {
                    closeStory();
                }
            });
        }

        function nextStory() {
            $('.progress-segment').eq(currentIndex).find('.progress-fill').stop().css('width', '100%');
            if (currentIndex < $items.length - 1) {
                currentIndex++;
                updateStoryContent();
                startProgress();
            } else {
                closeStory();
            }
        }

        function prevStory() {
            $('.progress-segment').eq(currentIndex).find('.progress-fill').stop().css('width', '0%');
            if (currentIndex > 0) {
                currentIndex--;
                updateStoryContent();
                startProgress();
            } else {
                updateStoryContent();
                startProgress();
            }
        }

        // Event Listeners
        $items.on('click', function () {
            openStory($(this).data('index'));
        });

        $('#storyClose').on('click', closeStory);

        $('#storyNext, #deskNext').on('click', function (e) {
            e.stopPropagation();
            nextStory();
        });

        $('#storyPrev, #deskPrev').on('click', function (e) {
            e.stopPropagation();
            prevStory();
        });

        // Close on ESC
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') closeStory();
        });

        // Pause on press / Resume on release (Conceptual)
        $image.on('mousedown touchstart', function () {
            const $currentFill = $('.progress-segment').eq(currentIndex).find('.progress-fill');
            $currentFill.stop();
            clearTimeout(progressTimer);
        }).on('mouseup touchend', function () {
            startProgress();
        });

    });

})(jQuery);
