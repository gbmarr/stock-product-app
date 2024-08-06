<header class="header">
    <h1 class="header-title">Product App</h1>
    <nav class="nav">
        <ul class="nav-list">
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
<main class="main-container">