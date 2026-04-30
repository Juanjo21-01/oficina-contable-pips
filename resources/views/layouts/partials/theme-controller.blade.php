<script>
    function getStoredTheme() {
        var stored = localStorage.getItem('theme');
        if (!stored) {
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            stored = prefersDark ? 'dark' : 'light';
            localStorage.setItem('theme', stored);
        }
        return stored;
    }

    function applyStoredTheme() {
        var stored = getStoredTheme();
        var isDark = stored === 'dark';

        document.documentElement.classList.toggle('dark', isDark);

        if (window.Alpine && Alpine.store && Alpine.store('theme')) {
            Alpine.store('theme').isDark = isDark;
        }
    }

    function ensureThemeConsistency() {
        var stored = getStoredTheme();
        var isDark = stored === 'dark';
        var hasDark = document.documentElement.classList.contains('dark');

        if (hasDark !== isDark) {
            document.documentElement.classList.toggle('dark', isDark);
        }
    }

    function initCharts() {
        if (!window.Chart) {
            return;
        }

        var canvases = document.querySelectorAll('canvas[data-chart]');
        if (!canvases || canvases.length === 0) {
            return;
        }

        var isDark = document.documentElement.classList.contains('dark');
        var gridColor = isDark ? 'rgba(148,163,184,0.12)' : 'rgba(100,116,139,0.12)';
        var tickColor = isDark ? '#94a3b8' : '#64748b';

        for (var i = 0; i < canvases.length; i += 1) {
            var canvas = canvases[i];
            var rawData = canvas.getAttribute('data-chart');
            if (!rawData) {
                continue;
            }

            var chartData;
            try {
                chartData = JSON.parse(rawData);
            } catch (error) {
                continue;
            }

            var chartOptions = {};
            var rawOptions = canvas.getAttribute('data-chart-options');
            if (rawOptions) {
                try {
                    chartOptions = JSON.parse(rawOptions);
                } catch (error) {
                    chartOptions = {};
                }
            }

            chartOptions.responsive = true;
            chartOptions.maintainAspectRatio = false;
            chartOptions.plugins = chartOptions.plugins || {};
            chartOptions.plugins.legend = chartOptions.plugins.legend || {};
            chartOptions.plugins.legend.position = chartOptions.plugins.legend.position || 'top';
            chartOptions.plugins.legend.labels = chartOptions.plugins.legend.labels || {};
            chartOptions.plugins.legend.labels.color = tickColor;
            chartOptions.plugins.legend.labels.font = chartOptions.plugins.legend.labels.font || {};
            if (chartOptions.plugins.legend.labels.font.size == null) {
                chartOptions.plugins.legend.labels.font.size = 12;
            }

            chartOptions.plugins.title = chartOptions.plugins.title || {};
            if (chartOptions.plugins.title.display == null) {
                chartOptions.plugins.title.display = false;
            }

            chartOptions.scales = chartOptions.scales || {};
            chartOptions.scales.x = chartOptions.scales.x || {};
            chartOptions.scales.x.ticks = chartOptions.scales.x.ticks || {};
            chartOptions.scales.x.ticks.color = tickColor;
            chartOptions.scales.x.grid = chartOptions.scales.x.grid || {};
            chartOptions.scales.x.grid.color = gridColor;

            chartOptions.scales.y = chartOptions.scales.y || {};
            chartOptions.scales.y.ticks = chartOptions.scales.y.ticks || {};
            chartOptions.scales.y.ticks.color = tickColor;
            chartOptions.scales.y.grid = chartOptions.scales.y.grid || {};
            chartOptions.scales.y.grid.color = gridColor;

            if (Chart.getChart) {
                var existing = Chart.getChart(canvas);
                if (existing) {
                    existing.destroy();
                }
            }

            new Chart(canvas.getContext('2d'), {
                type: canvas.getAttribute('data-chart-type') || 'line',
                data: chartData,
                options: chartOptions,
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        applyStoredTheme();
        initCharts();

        if (!window.__themeObserverAttached) {
            window.__themeObserverAttached = true;
            var observer = new MutationObserver(function(mutations) {
                for (var i = 0; i < mutations.length; i += 1) {
                    if (mutations[i].attributeName === 'class') {
                        ensureThemeConsistency();
                    }
                }
            });
            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class'],
            });
        }
    });

    document.addEventListener('livewire:navigated', function() {
        applyStoredTheme();
        setTimeout(applyStoredTheme, 0);
        requestAnimationFrame(applyStoredTheme);
        initCharts();
    });
</script>
