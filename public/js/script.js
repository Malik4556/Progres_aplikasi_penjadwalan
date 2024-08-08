document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.querySelector('.toggle-btn');
    const sidebar = document.getElementById('sidebar');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('expand');
        });
    }
});
