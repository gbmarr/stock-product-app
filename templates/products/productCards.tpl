{include '../layouts/head.tpl'}
{include '../layouts/header.tpl'}
<div class="card-container">
{if ($products != null && !empty($products))}
    {foreach $products as $item}
        <div class="card">
            <div class="card-header">
                <img class="card-img" src="{$item->imgproduct}" />
                <h5 class="card-title">{$item->name}</h5>
            </div>
            <div class="card-body">
                <p class="card-desc">Descripción: {$item->description}</p>
                <p class="card-price">Precio: {$item->price}</p>
                <p class="card-cat">Categoría: {$item->catdescription}</p>
            </div>
            <div class="card-data">
                {if $item->stock} <p class="card-stock">Stock: Disponible</p>
                {else} <p class="card-stock">Stock: No disponible</p> {/if}
                <a class="card-link-detail" href="{BASE_URL}/detail/{$item->idproduct}">Detalle</a>
            </div>
        </div>
    {/foreach}
{/if}
</div>

{include '../layouts/footer.tpl'}