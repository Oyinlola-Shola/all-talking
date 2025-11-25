
// Toggle theme
function toggleTheme() {
    const isDark = document.getElementById('themeToggle').checked;
    const theme = isDark ? 'dark' : 'light';
    
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
}