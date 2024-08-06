{include '../layouts/head.tpl'}
{include '../layouts/header.tpl'}
<!-- faltan redirecciones -->
<div class="table-list-container">
    <h3 class="table-title">Categorías</h3>
    <table class="table">
        <thead class="table-head">
            <tr class="table-head-row">
                <th>Nombre de categoría</th>
                {if $admin}
                    <th>Acciones</th>
                {/if}
            </tr>
        </thead>
        <tbody class="table-body">
            {foreach from=$categories item=$category}
            <tr class="table-body-row">
                <td>{$category->name}</td>
                {if $admin}
                    <td>
                        <a class="edit-category-btn" href="{BASE_URL}/category/edit/{$category->idcat}">Editar</a>
                        <a class="delete-category-btn" href="{BASE_URL}/category/delete/{$category->idcat}">Eliminar</a>        
                    </td>
                {/if}
            </tr>    
            {/foreach}
        </tbody>
    </table>
    {if $admin}
        <div class="add-btn-container">
            <a class="add-category-btn" href="{BASE_URL}/category/add">Agregar categoría</a>
        </div>
    {/if}
</div>
{include '../layouts/footer.tpl'}