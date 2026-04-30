<script>
    (function() {
        var stored = localStorage.getItem('theme');
        if (!stored) {
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            stored = prefersDark ? 'dark' : 'light';
            localStorage.setItem('theme', stored);
        }
        document.documentElement.classList.toggle('dark', stored === 'dark');
    })();
</script>
