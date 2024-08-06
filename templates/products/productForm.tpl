{include '../layouts/head.tpl'}
{include '../layouts/header.tpl'}
<div class="product-page-container">
    <h3 class="product-page-title">{if $product}Editar producto{else}Crear producto{/if}</h3>
    <!-- falta action  dentro de la etiqueta form -->
    <form class="form-container-product" action="{if $product}{BASE_URL}/update/{$product->idproduct}
        {else}{BASE_URL}/store{/if}" method="POST">
        <div class="form-input-container">
            <label for="name">Nombre:</label>
            <input type="text" name="name" value="{$product->name|default:''}">
        </div>
        <div class="form-input-container">
            <label for="description">Descripción:</label>
            <textarea name="description" rows="5" >{$product->description|default:''}</textarea>
        </div>
        <div class="form-input-container">
            <label for="price">Precio:</label>
            <input type="number" name="price" value="{$product->price|default:''}">
        </div>
        <div class="form-input-container">
            <label for="idcategory">Categoría:</label>
            <select name="idcategory">
                {foreach from=$categories item=$category}
                    <option value={$category->idcat}
                        {if $product && $product->idcategory == $category->idcat}
                            selected{/if}>
                            {$category->name}
                    </option>
                {/foreach}
            </select>
        </div>
        <div class="form-input-container">
            <label for="stock">Stock:</label>
            <input type="checkbox" name="stock" value={if ($product === null)}false
                {else}{$product->stock}{/if}
                {if $product && $product->stock}checked{/if} />
        </div>
        <button class="add-product-btn" type="submit">{if $product}Actualizar{else}Crear{/if}</button>
        <a class="delete-product-btn" href="{BASE_URL}/list">Cancelar</a>
    </form>
</div>
{include '../layouts/footer.tpl'}