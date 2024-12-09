{include '../layouts/head.tpl'}
{include '../layouts/header.tpl'}
<!-- faltan redirecciones -->
<div class="table-list-container">
    <h3 class="table-title">Categorías</h3>
    <table class="table">
        <thead class="table-head">
            <tr class="table-head-row">
                <th>Nombre de categoría</th>
                <th>Imagen</th>
                {if $admin}
                    <th>Acciones</th>
                {/if}
            </tr>
        </thead>
        <tbody class="table-body">
        {if ($categories != null && !empty($categories))}
            {foreach from=$categories item=$category}
            <tr class="table-body-row table-category-row">
                <td>{$category->catname}</td>
                <td>
                <img class="table-img" src="{$category->catimage}" />
                </td>
                {if $admin}
                    <td>
                        <a class="edit-category-btn" href="{BASE_URL}/category/edit/{$category->idcat}">Editar</a>
                        <a class="delete-category-btn" href="{BASE_URL}/category/delete/{$category->idcat}">Eliminar</a>        
                    </td>
                {/if}
            </tr>    
            {/foreach}
        {else}
            <tr class="table-body-row">
                <td>No hay categorías</td>
            </tr>
        {/if}
        </tbody>
    </table>
    {if $admin}
        <div class="add-btn-container">
            <a class="add-category-btn" href="{BASE_URL}/category/add">Agregar categoría</a>
        </div>
    {/if}
</div>
{include '../layouts/footer.tpl'}