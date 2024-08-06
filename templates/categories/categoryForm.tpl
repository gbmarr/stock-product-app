{include '../layouts/head.tpl'}
{include '../layouts/header.tpl'}
<div class="category-page-container">
    <h3 class="category-page-title">
        {if $category}
            Editar categoría
        {else}
            Crear categoría
        {/if}
    </h3>
    <form class="form-container-category" action="{if isset($category)}{BASE_URL}/category/update/{$category->idcat}
        {else}{BASE_URL}/category/store{/if}" method="POST">
        <div class="form-input-container">
            <label for="name">Nombre</label>
            <input type="text" name="name" value={$category->name|default:""}>
        </div>
        <button class="add-category-btn" type="submit">{if $category}Actualizar{else}Crear{/if}</button>
        <a class="delete-category-btn" href="{BASE_URL}/category">Cancelar</a>
    </form>
</div>
{include '../layouts/footer.tpl'}