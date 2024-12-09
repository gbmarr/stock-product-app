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
    <form class="form-container-category" enctype="multipart/form-data" action="{if isset($category)}{BASE_URL}/category/update/{$category->idcat}
        {else}{BASE_URL}/category/store{/if}" method="POST">
        <div class="form-input-container">
            <label for="name">Nombre</label>
            <input type="text" name="catname" value={$category->catname|default:""} >
        </div>
        <div class="form-input-container">
            <label for="catimage">Imagen:</label>
            <input type="file" name="catimage" id="catimage" >
        </div>
        {if $category}
            <div class="form-input-container">
                <label for="catimage-view">Imagen actual:</label>
                <img src="{BASE_URL}/{$category->catimage}" class="catimage-view" alt="Imagen de {$category->catname}" />
            </div>
        {/if}
        <div class="form-btn-container">
            <button class="add-category-btn" type="submit">
            {if $category}Actualizar{else}Crear{/if}
            </button>
            <a class="delete-category-btn" href="{BASE_URL}/category">Cancelar</a>
        </div>
    </form>
</div>
{include '../layouts/footer.tpl'}