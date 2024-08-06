{include '../layouts/head.tpl'}
{include '../layouts/header.tpl'}
<div class="table-list-container">
    <h3 class="table-title">Lista de productos</h3>
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
        {foreach from=$products item=$item}
            <tr class="table-body-row">
                <td>{$item->name}</td>
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
    </tbody>
    </table>
    {if $admin}
        <div class="add-btn-container">
            <a class="add-product-btn" href="{BASE_URL}/add">Agregar</a>
        </div>
    {/if}
</div>
{include '../layouts/footer.tpl'}