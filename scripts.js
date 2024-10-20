function toggleMenu() {
    var menu = document.getElementById('side-menu');
    var content = document.querySelector('.content');
    if (menu.classList.contains('open')) {
        menu.classList.remove('open');
        content.classList.remove('menu-open');
    } else {
        menu.classList.add('open');
        content.classList.add('menu-open');
    }
}

function toggleSubmenu(id) {
    var submenu = document.getElementById(id);
    if (submenu.style.display === 'none' || submenu.style.display === '') {
        submenu.style.display = 'block';
    } else {
        submenu.style.display = 'none';
    }
}
