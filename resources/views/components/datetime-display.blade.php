<div class="w-full bg-gray-100 text-gray-700 text-xs sm:text-sm py-1 px-4 flex items-center justify-between overflow-hidden border-b border-gray-200">
    <!-- Date Section -->
    <div class="flex-shrink-0 flex items-center space-x-1 sm:space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span id="date-display" class="font-medium whitespace-nowrap">
            Loading date...
        </span>
    </div>
    
    <!-- Timezone Section -->
    <div id="timezone-display" class="flex-shrink-0 flex items-center space-x-1 sm:space-x-2 text-[10px] sm:text-xs">
        <span id="wib-time" class="whitespace-nowrap">WIB: -:-</span>
        <span class="text-gray-400">|</span>
        <span id="wita-time" class="whitespace-nowrap">WITA: -:-</span>
        <span class="text-gray-400">|</span>
        <span id="wit-time" class="whitespace-nowrap">WIT: -:-</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function formatTime(date) {
        return date.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        });
    }

    function updateDateTime() {
        const now = new Date();
        
        // Format options for date
        const dateOptions = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            timeZone: 'Asia/Jakarta'
        };
        
        // Format the date
        const dateStr = now.toLocaleDateString('id-ID', dateOptions);
        document.getElementById('date-display').textContent = dateStr;
        
        // Update timezone times
        const wibTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }));
        const witaTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Makassar' }));
        const witTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Jayapura' }));
        
        document.getElementById('wib-time').textContent = `WIB: ${formatTime(wibTime)}`;
        document.getElementById('wita-time').textContent = `WITA: ${formatTime(witaTime)}`;
        document.getElementById('wit-time').textContent = `WIT: ${formatTime(witTime)}`;
    }
    
    // Update immediately and then every second
    updateDateTime();
    setInterval(updateDateTime, 1000);
});
</script>
