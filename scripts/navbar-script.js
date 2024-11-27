function toggleMenu() {
    const navList = document.getElementById('navList');
    const menuIcon = document.getElementById('menu-icon-open');
    const menuIconClose = document.getElementById('menu-icon-close');
    const body = document.body;

    navList.classList.toggle('show');
    const isMenuOpen = navList.classList.contains('show');

    if(isMenuOpen){
        menuIcon.style.display = 'none';
        menuIconClose.style.display = 'block';
        body.classList.add('no-scroll');
    }else{
        menuIcon.style.display = 'block';
        menuIconClose.style.display = 'none';
        body.classList.remove('no-scroll');
    }
}