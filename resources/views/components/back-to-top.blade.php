<button id="backToTop" 
    class="fixed bottom-6 right-6 p-3 rounded-full cursor-pointer transition-all duration-300 opacity-0 translate-y-10 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 z-50 animate-gradient-button shadow-lg hover:shadow-xl"
    aria-label="Back to top">
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
</button>

<style>
    @keyframes gradient-button {
        0% { background-position: 0% 0%; }
        25% { background-position: 50% 50%; }
        50% { background-position: 100% 100%; }
        75% { background-position: 50% 50%; }
        100% { background-position: 0% 0%; }
    }
    
    .animate-gradient-button {
        background: linear-gradient(135deg, 
            #007a99,    /* Medium cyan */
            #005580,    /* Medium blue */
            #008080,    /* Medium teal */
            #006666,    /* Medium cyan-green */
            #2e8b57,    /* Medium sea green */
            #2b6a8b,    /* Medium steel blue */
            #007a99     /* Back to first color */
        );
        background-size: 400% 400%;
        animation: gradient-button 7s ease infinite;
    }
</style>