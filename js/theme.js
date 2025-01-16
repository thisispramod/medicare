$(document).ready(function() {
    // Check for saved theme preference
    const currentTheme = localStorage.getItem('theme') || 'light';
    applyTheme(currentTheme);

    // Theme toggle button click handler
    $('#themeToggle').on('click', function() {
        const newTheme = $('body').hasClass('dark-mode') ? 'light' : 'dark';
        applyTheme(newTheme);
        localStorage.setItem('theme', newTheme);
    });

    // Function to apply theme
    function applyTheme(theme) {
        if (theme === 'dark') {
            $('body').addClass('dark-mode');
            $('.theme-icon-light').show();
            $('.theme-icon-dark').hide();
        } else {
            $('body').removeClass('dark-mode');
            $('.theme-icon-light').hide();
            $('.theme-icon-dark').show();
        }

        // Update colors for different elements
        updateThemeColors();
    }

    // Function to update colors based on theme
    function updateThemeColors() {
        if ($('body').hasClass('dark-mode')) {
            // Dark mode colors
            $('body').css('background-color', '#121212');
            $('.bg-white').addClass('dark-bg').css('background-color', '#1a1a1a');
            $('.text-gray-600').addClass('dark-text').css('color', '#e0e0e0');
            $('.text-gray-700').addClass('dark-text').css('color', '#f0f0f0');
            $('.text-gray-900, .text-blue-900').addClass('dark-text').css('color', '#ffffff');
            $('.bg-blue-900').addClass('dark-bg-blue').css('background-color', '#1a237e');
            $('input, textarea').addClass('dark-input')
                .css({
                    'background-color': '#2d2d2d',
                    'color': '#ffffff',
                    'border-color': '#404040'
                });
            $('.shadow-lg').css('box-shadow', '0 4px 6px rgba(0, 0, 0, 0.5)');
        } else {
            // Light mode colors
            $('body').css('background-color', '#ffffff');
            $('.dark-bg').removeClass('dark-bg').css('background-color', '#ffffff');
            $('.dark-text').removeClass('dark-text').css('color', '');
            $('.dark-bg-blue').removeClass('dark-bg-blue').css('background-color', '');
            $('.dark-input').removeClass('dark-input')
                .css({
                    'background-color': '#ffffff',
                    'color': '#000000',
                    'border-color': '#e2e8f0'
                });
            $('.shadow-lg').css('box-shadow', '0 10px 15px -3px rgba(0, 0, 0, 0.1)');
        }
    }
});
