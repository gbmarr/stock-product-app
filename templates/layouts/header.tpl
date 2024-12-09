<header class="header">
    <h1 class="header-title">Product App</h1>
    <nav class="nav">
        <button class="nav-menu-burger" type="button" onclick="toggleMenu()">
            <img id="menu-icon-open" src="https://api.iconify.design/stash:burger-classic.svg" />
        </button>
        <ul class="nav-list" id="navList">
            <img id="menu-icon-close" src="https://api.iconify.design/bx:x-circle.svg" onclick="toggleMenu()" />
            <li class="nav-list-item"><a href="{BASE_URL}/home">Inicio</a></li>
            <li class="nav-list-item"><a href="{BASE_URL}/list">Productos</a></li>
            <li class="nav-list-item"><a href="{BASE_URL}/category">Categorias</a></li>
        {if $user}
            <li class="nav-list-item logout"><a href="{BASE_URL}/logout">Logout</a></li>
        {else}
            <li class="nav-list-item"><a href="{BASE_URL}/login">Login</a></li>
        {/if}
        </ul>
    </nav>
</header>
<script src="scripts/navbar-script.js"></script>
<main class="main-container">