{include '../layouts/head.tpl'}
{include '../layouts/header.tpl'}
<div class="table-list-container">
    <h3 class="table-title">Lista de productos</h3>
    <form class="form-filter" method="POST" action="{BASE_URL}/list">
        <label class="form-filter-label" for="category_filter">Ver por categoría:</label>
        <select class="form-filter-select" name="category_filter" id="category_filter">
            <option value="">Todas las categorías</option>
            {foreach from=$categories item=$category}
            <option value="{$category->idcat}" {if $filter != null && $category->idcat == $filter}selected{/if}>{$category->catname}</option>
            {/foreach}
        </select>
        <button class="form-filter-button" type="submit">Aplicar filtro</button>
    </form>
    <table class="table">
    <thead class="table-head">
        <tr class="table-head-row">
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Imagen</th>
            {if $admin}
                <th>Acciones</th>
            {/if}
        </tr>
    </thead>
    <tbody class="table-body">
    {if ($products != null && !empty($products))}
        {foreach from=$products item=$item}
            <tr class="table-body-row">
                <td>{$item->prodname}</td>
                <td>{$item->description}</td>
                <td>{$item->catdescription}</td>
                <td>{$item->price}</td>
                <td>
                {if $item->stock}
                    Disponible
                {else}
                    No disponible
                {/if}
                </td>
                <td>
                    <img class="table-img" src="{$item->imgproduct}" />
                </td>
                {if $admin}
                <td>
                    <a class="edit-product-btn" href="{BASE_URL}/edit/{$item->idproduct}">Editar</a>
                    <a class="delete-product-btn" href="{BASE_URL}/delete/{$item->idproduct}">Eliminar</a>
                </td>
                {/if}
            </tr>
        {/foreach}
    {else}
        <tr class="table-body-row">
            <td colspan="6">No hay productos</td>
        </tr>
    {/if}
    </tbody>
    </table>
    {if $admin}
        <div class="add-btn-container">
            <a class="add-product-btn" href="{BASE_URL}/add">Agregar</a>
        </div>
    {/if}
</div>
{include '../layouts/footer.tpl'}