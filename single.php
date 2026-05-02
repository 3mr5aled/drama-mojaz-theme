<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Drama_Mojaz_Theme
 * 
 * Drama Mojaz Theme is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 */

get_header(); ?>

<!-- Sticky Reading Progress Bar - Top of page -->
<div class="fixed top-[30px] left-0 right-0 z-[55] pointer-events-none md:top-[30px] reading-bar-master opacity-0 -translate-y-5 transition-all duration-500">
    <div class="bg-white/95 backdrop-blur-xl border-b border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] py-1.5 px-4 md:px-8 flex items-center justify-between">
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="flex-shrink-0 w-2 h-2 rounded-full bg-primary animate-pulse shadow-[0_0_8px_rgba(var(--primary-rgb),0.5)]"></div>
            <span class="current-section-title text-[25px] md:text-[25px] font-black kufi text-gray-800 truncate max-w-[200px] md:max-w-xl">
                <?php the_title(); ?>
            </span>
        </div>
        <div class="reading-percentage text-[25px] md:text-[25px] font-black kufi text-primary/80 bg-primary/5 px-2 py-0.5 rounded-full border border-primary/10">0%</div>
    </div>
    <div class="h-1 bg-gray-100/50 overflow-hidden">
        <div class="reading-progress-bar h-full bg-gradient-to-r from-primary/50 via-primary to-primary w-0 transition-all duration-300 ease-out relative shadow-[0_0_15px_rgba(var(--primary-rgb),0.6)]">
            <!-- Glow Head -->
            <div class="absolute right-0 top-0 h-full w-12 bg-gradient-to-r from-transparent to-white/40 blur-sm"></div>
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-2 h-2 bg-white rounded-full shadow-[0_0_10px_#fff]"></div>
        </div>
    </div>
</div>

<!-- ResponsiveVoice Library -->
<?php if (sports_news_get_opt('show_audio_player', true)) : 
    $rv_api_key = sports_news_get_opt('audio_player_api_key', 'Oynxp8Hd');
?>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=<?php echo esc_attr($rv_api_key); ?>"></script>
<?php endif; ?>

<?php
$post_layout = sports_news_get_opt('post_layout_design', 'design-1');
get_template_part('template-parts/post/common-styles');
get_template_part('template-parts/post/' . $post_layout);
?>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const masterContainer = document.querySelector('.reading-bar-master');
    const progressBar = document.querySelector('.reading-progress-bar');
    const sectionTitle = document.querySelector('.current-section-title');
    const percentageText = document.querySelector('.reading-percentage');
    const readingTimeElement = document.querySelector('.reading-time'); // New element for reading time
    const article = document.querySelector('article');
    const defaultTitle = sectionTitle ? sectionTitle.innerText : '';
    
    if (masterContainer && article) {
        const headings = Array.from(article.querySelectorAll('h2, h3'));
        let ticking = false;
        
        function updateProgress() {
            const articleRect = article.getBoundingClientRect();
            const articleTop = articleRect.top + window.scrollY;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrollTop = window.scrollY;
            
            // 1. Calculate Progress
            const startOffset = articleTop - 150;
            const endOffset = articleTop + articleHeight - windowHeight;
            let progress = 0;
            
            if (scrollTop > startOffset) {
                progress = ((scrollTop - startOffset) / (endOffset - startOffset)) * 100;
            }
            
            const finalProgress = Math.min(Math.max(progress, 0), 100);
            
            // Update UI elements
            if (progressBar) progressBar.style.width = finalProgress + '%';
            if (percentageText) percentageText.innerText = Math.round(finalProgress) + '%';
            
            // 2. Detect Current Section
            let currentHeading = defaultTitle;
            const scrollThreshold = 150; // Heading is considered "active" when it passes this point from top
            
            for (let i = headings.length - 1; i >= 0; i--) {
                const heading = headings[i];
                const headingTop = heading.getBoundingClientRect().top;
                
                if (headingTop < scrollThreshold) {
                    currentHeading = heading.innerText;
                    break;
                }
            }
            
            if (sectionTitle && sectionTitle.innerText !== currentHeading) {
                sectionTitle.style.opacity = '0';
                setTimeout(() => {
                    sectionTitle.innerText = currentHeading;
                    sectionTitle.style.opacity = '1';
                }, 200);
            }
            
            // 3. Visibility Logic
            if (scrollTop < 50 || finalProgress <= 0) {
                masterContainer.classList.add('opacity-0', '-translate-y-5');
                masterContainer.classList.remove('opacity-100', 'translate-y-0');
                masterContainer.style.opacity = '0';
            } else if (finalProgress < 100) {
                masterContainer.classList.remove('opacity-0', '-translate-y-5');
                masterContainer.classList.add('opacity-100', 'translate-y-0');
                masterContainer.style.opacity = '1';
            } else {
                // End of article - stay visible but slightly transparent
                masterContainer.classList.remove('opacity-0', '-translate-y-5');
                masterContainer.classList.add('opacity-100', 'translate-y-0');
                masterContainer.style.opacity = '0.9';
            }
            
            ticking = false;
        }
        
        function onScroll() {
            if (!ticking) {
                requestAnimationFrame(updateProgress);
                ticking = true;
            }
        }
        
        window.addEventListener('scroll', onScroll, { passive: true });
        updateProgress(); // Run once on load
        
        // Add CSS transition for smooth title fading
        if (sectionTitle) {
            sectionTitle.style.transition = 'opacity 0.2s ease';
        }
        
        // Update reading time display periodically
        setInterval(() => {
            if (readingTimeElement) {
                const readingTimes = calculateReadingTime();
                const currentTimeFormatted = formatTime(readingTimes.current);
                const totalTimeFormatted = formatTime(readingTimes.total);
                
                readingTimeElement.textContent = `${currentTimeFormatted} / ${totalTimeFormatted}`;
            }
        }, 1000); // Update every second

        // --- Premium Audio Player Logic (ResponsiveVoice) ---
        <?php if (sports_news_get_opt('show_audio_player', true)) : ?>
        const audioPlayer = document.querySelector('.audio-reading-player');
        if (audioPlayer) {
            const playPauseBtn = document.getElementById('audioPlayPauseBtn');
            const speedBtn = document.getElementById('audioSpeedBtn');
            const progressArea = document.getElementById('audioProgressArea');
            const progressFill = document.getElementById('audioProgressFill');
            const progressHandle = document.getElementById('audioProgressHandle');
            const currentTimeEl = document.getElementById('audioCurrentTime');
            const contentDiv = document.getElementById('articleContent');
            
            let isPlaying = false;
            let currentRate = 1;
            const rates = [1, 1.25, 1.5, 2];
            let rateIndex = 0;
            
            let totalEstimatedSeconds = 0;
            let currentSeconds = 0;
            let progressInterval = null;

            function updateTimeDisplay(seconds) {
                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                currentTimeEl.innerText = `${mins}:${secs.toString().padStart(2, '0')}`;
            }

            function updateProgressUI() {
                const percent = (currentSeconds / totalEstimatedSeconds) * 100;
                const safePercent = Math.min(percent, 100);
                progressFill.style.width = safePercent + '%';
                progressHandle.style.right = safePercent + '%';
                updateTimeDisplay(currentSeconds);
            }

            function estimateDuration(text) {
                const words = text.trim().split(/\s+/).length;
                // Average Arabic speech is ~120 words per minute
                return (words / 120) * 60;
            }

            function togglePlayback() {
                checkAndRunResponsiveVoice(function() {
                    if (isPlaying) {
                        responsiveVoice.pause();
                        isPlaying = false;
                        playPauseBtn.innerHTML = '<i class="ri-play-fill text-3xl"></i>';
                        clearInterval(progressInterval);
                    } else {
                        if (responsiveVoice.isPlaying()) {
                            responsiveVoice.resume();
                            startInterval();
                        } else {
                            startNewSpeech();
                        }
                        isPlaying = true;
                        playPauseBtn.innerHTML = '<i class="ri-pause-fill text-3xl"></i>';
                    }
                });
            }

            function startNewSpeech() {
                const textToRead = Array.from(contentDiv.querySelectorAll('p, h2, h3'))
                    .map(el => el.innerText.trim())
                    .filter(t => t.length > 5)
                    .join('. ');

                if (textToRead.length < 10) return;

                totalEstimatedSeconds = estimateDuration(textToRead) / currentRate;
                currentSeconds = 0;

                responsiveVoice.speak(textToRead, 'Arabic Male', {
                    rate: currentRate,
                    onstart: function() {
                        startInterval();
                    },
                    onend: function() {
                        stopPlayback();
                    }
                });
            }

            function startInterval() {
                clearInterval(progressInterval);
                progressInterval = setInterval(() => {
                    currentSeconds += 0.5;
                    if (currentSeconds > totalEstimatedSeconds + 5) { // Padding for inaccuracies
                        clearInterval(progressInterval);
                    }
                    updateProgressUI();
                }, 500);
            }

            function stopPlayback() {
                isPlaying = false;
                clearInterval(progressInterval);
                currentSeconds = totalEstimatedSeconds;
                updateProgressUI();
                playPauseBtn.innerHTML = '<i class="ri-play-fill text-3xl"></i>';
                
                // Reset for next time if it ended naturally
                setTimeout(() => {
                    currentSeconds = 0;
                    progressFill.style.width = '0%';
                    progressHandle.style.right = '0%';
                    updateTimeDisplay(0);
                }, 1000);
            }

            playPauseBtn.addEventListener('click', togglePlayback);

            progressArea.addEventListener('click', function(e) {
                const rect = progressArea.getBoundingClientRect();
                const offsetX = e.clientX - rect.left;
                const percentage = 1 - (offsetX / rect.width); // RTL logic
                const safePercentage = Math.max(0, Math.min(1, percentage));

                checkAndRunResponsiveVoice(function() {
                    const fullText = Array.from(contentDiv.querySelectorAll('p, h2, h3'))
                        .map(el => el.innerText.trim())
                        .filter(t => t.length > 5)
                        .join('. ');

                    if (fullText.length < 10) return;

                    responsiveVoice.cancel();
                    
                    // Simple text-based seeking
                    const seekCharIndex = Math.floor(fullText.length * safePercentage);
                    const remainingText = fullText.substring(seekCharIndex);
                    
                    totalEstimatedSeconds = estimateDuration(fullText) / currentRate;
                    currentSeconds = totalEstimatedSeconds * safePercentage;
                    updateProgressUI();

                    responsiveVoice.speak(remainingText, 'Arabic Male', {
                        rate: currentRate,
                        onstart: function() {
                            isPlaying = true;
                            playPauseBtn.innerHTML = '<i class="ri-pause-fill text-3xl"></i>';
                            startInterval();
                        },
                        onend: function() {
                            stopPlayback();
                        }
                    });
                });
            });

            speedBtn.addEventListener('click', function() {
                rateIndex = (rateIndex + 1) % rates.length;
                currentRate = rates[rateIndex];
                speedBtn.innerText = 'x' + currentRate;
                
                if (isPlaying || responsiveVoice.isPlaying()) {
                    // Restart at same position with new rate
                    const rect = progressArea.getBoundingClientRect(); // This is just for dummy ref or we use currentSeconds
                    const currentPercent = currentSeconds / totalEstimatedSeconds;
                    
                    responsiveVoice.cancel();
                    
                    const fullText = Array.from(contentDiv.querySelectorAll('p, h2, h3'))
                        .map(el => el.innerText.trim())
                        .filter(t => t.length > 5)
                        .join('. ');
                    
                    const seekCharIndex = Math.floor(fullText.length * currentPercent);
                    const remainingText = fullText.substring(seekCharIndex);
                    
                    totalEstimatedSeconds = estimateDuration(fullText) / currentRate;
                    // Keep currentSeconds relative to progress
                    
                    responsiveVoice.speak(remainingText, 'Arabic Male', {
                        rate: currentRate,
                        onstart: function() {
                            isPlaying = true;
                            playPauseBtn.innerHTML = '<i class="ri-pause-fill text-3xl"></i>';
                            startInterval();
                        },
                        onend: function() {
                            stopPlayback();
                        }
                    });
                }
            });

            // Helper function to check and wait for ResponsiveVoice
            function checkAndRunResponsiveVoice(callback) {
                if (typeof responsiveVoice !== 'undefined' && responsiveVoice.voiceSupport()) {
                    callback();
                } else {
                    let attempts = 0;
                    const interval = setInterval(() => {
                        attempts++;
                        if (typeof responsiveVoice !== 'undefined' && responsiveVoice.voiceSupport()) {
                            clearInterval(interval);
                            callback();
                        } else if (attempts > 20) {
                            clearInterval(interval);
                            console.error('ResponsiveVoice not available');
                        }
                    }, 200);
                }
            }
        }
        <?php endif; ?>
    }
});
</script>



<?php get_footer(); ?>
