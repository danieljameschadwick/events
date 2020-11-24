document.addEventListener('DOMContentLoaded', () => {
    const html = document.querySelector('html');

    // On page load or when changing themes, best to add inline in `head` to avoid FOUC
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
        document.querySelector('#theme-icon').classList.add('dark');
    } else {
        html.classList.remove('dark');
    }

    // Whenever the user explicitly chooses to respect the OS preference
    // localStorage.removeItem('theme')
});

document.querySelector('#theme-icon').addEventListener('click', (event) => {
    const target = event.currentTarget;
    const html = document.querySelector('html');

    if (target.classList.contains('dark')) {
        target.classList.remove('dark');
        target.classList.add('light');

        html.classList.remove('dark');

        localStorage.theme = 'light';

        console.log(localStorage.theme);
        return;
    }

    if (target.classList.contains('light')) {
        target.classList.remove('light');
        target.classList.add('dark');

        html.classList.add('dark');

        localStorage.theme = 'dark';

        console.log(localStorage.theme);
        return;
    }

    target.classList.add('light');
});