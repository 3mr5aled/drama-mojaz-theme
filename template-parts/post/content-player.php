<!-- Enhanced Audio Player -->
<div class="audio-reading-player mb-10 bg-[#f8f9fa] border border-gray-100 rounded-full py-2.5 px-6 flex items-center gap-4 md:gap-6 shadow-sm dir-rtl max-w-4xl mx-auto">
    <!-- Playback Speed -->
    <div class="relative">
        <button id="audioSpeedBtn" class="bg-gray-200/50 hover:bg-gray-200 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center rounded-full text-[10px] md:text-[11px] font-black text-gray-600 transition-all min-w-[32px] md:min-w-[40px]">
            x1
        </button>
    </div>

    <!-- Time -->
    <span id="audioCurrentTime" class="text-[10px] md:text-xs font-bold text-gray-400 min-w-[35px] text-center">0:00</span>

    <!-- Progress Bar -->
    <div class="flex-grow relative h-1 md:h-1.5 bg-gray-200 rounded-full cursor-pointer group" id="audioProgressArea">
        <div id="audioProgressFill" class="absolute top-0 right-0 h-full bg-gray-400 rounded-full" style="width: 0%"></div>
        <div id="audioProgressHandle" class="absolute top-1/2 -translate-y-1/2 w-3 md:w-3.5 h-3 md:h-3.5 bg-gray-900 rounded-full shadow-md z-10" style="right: 0%; transform: translate(50%, -50%);"></div>
    </div>

    <!-- Text Info -->
    <div class="text-right flex flex-col leading-tight hidden sm:flex">
        <span class="text-xs md:text-sm font-black kufi text-gray-900 mb-0.5">استمع للمقال</span>
        <span class="text-[8px] md:text-[9px] font-bold text-gray-400 kufi whitespace-nowrap">النص المسموع تلقائي ناتج عن نظام الي</span>
    </div>

    <!-- Play/Stop Button -->
    <button id="audioPlayPauseBtn" class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center text-gray-900 hover:text-primary transition-colors flex-shrink-0">
        <i class="ri-play-fill text-2xl md:text-3xl"></i>
    </button>
</div>
