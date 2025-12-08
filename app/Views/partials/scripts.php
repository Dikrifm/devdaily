<script>
    function initUI() {
        const html = document.documentElement; 
        const themeText = document.getElementById('theme-text');
        const header = document.getElementById('sticky-header');

        // Theme Check
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) { 
            html.classList.add('dark'); 
            if(themeText) themeText.innerText = '☀️ TERANG'; 
        } else { 
            html.classList.remove('dark'); 
            if(themeText) themeText.innerText = '🌙 GELAP'; 
        }

        // Scroll Listener
        window.onscroll = () => { 
            const currentHeader = document.getElementById('sticky-header');
            if (currentHeader && !currentHeader.classList.contains('hidden') && window.scrollY > 10) { 
                currentHeader.classList.add('scrolled'); 
            } else if(currentHeader) { 
                currentHeader.classList.remove('scrolled'); 
            } 
        };
    }

    function toggleSidebar() { 
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        if(sidebar && overlay) {
            sidebar.classList.toggle('-translate-x-full'); 
            overlay.classList.toggle('hidden'); 
        }
    }
    
    function toggleTheme() { 
        const html = document.documentElement;
        html.classList.contains('dark') ? localStorage.theme = 'light' : localStorage.theme = 'dark'; 
        initUI(); 
    }

    // Init
    initUI();
    
    // HTMX Event Hook
    document.addEventListener('htmx:afterSwap', function(evt) {
        initUI();
        window.scrollTo(0, 0);
        const sidebar = document.getElementById('sidebar');
        if(sidebar && !sidebar.classList.contains('-translate-x-full')) {
            toggleSidebar();
        }
    });
</script>
