{include '../layouts/head.tpl'}
{include '../layouts/header.tpl'}
<div class="login-page-container">
<h3 class="login-page-title">Iniciar Sesión</h1>
        <form class="form-container" action="{BASE_URL}/auth" method="POST">
            <div class="form-input-container">
                <label for="email">Email:</label>
                <input type="email" name="email">
            </div>
            <div class="form-input-container">
                <label for="password">Contraseña:</label>
                <input type="password" name="password">
            </div>
            <button class="form-btn" type="submit">Ingresar</button>
        </form>
</div>
{include '../layouts/footer.tpl'}