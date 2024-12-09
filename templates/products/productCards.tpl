{include '../layouts/head.tpl'}
{include '../layouts/header.tpl'}
<div class="card-container">
{if ($products != null && !empty($products))}
    {foreach $products as $item}
        <div class="card">
            <div class="card-header">
                <img class="card-img" src="{$item->imgproduct}" alt="Imagen de {$item->prodname}" />
                <h5 class="card-title">{$item->prodname}</h5>
            </div>
            <div class="card-body">
                <p class="card-desc">Descripción: {$item->description}</p>
                <p class="card-cat">Categoría: {$item->catdescription}</p>
                <p class="card-price">Precio: {$item->price}</p>
            </div>
            <div class="card-data">
                {if $item->stock} <p class="card-stock">Disponible</p>
                {else} <p class="card-stock nodisp">No disponible</p> {/if}
                <a class="card-link-detail" href="{BASE_URL}/detail/{$item->idproduct}">Detalle</a>
            </div>
        </div>
    {/foreach}
{else}
    <div class="card">
        <div class="card-header">
            <img class="card-img" src="images/imagenPorDefault.jpg" alt="Imagen de no-products" />
            <h5 class="card-title">No hay productos</h5>
        </div>
        <div class="card-body">
            <p class="card-desc">Contactese con el administrador.</p>
        </div>
        <div class="card-data">
        </div>
    </div>
{/if}
</div>

{include '../layouts/footer.tpl'}