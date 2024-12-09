{include '../layouts/head.tpl'}
{include '../layouts/header.tpl'}
    <div class="card-detail-container">
        <div class="card-detail-header">
            <img class="card-detail-img" src="{BASE_URL}/{$product->imgproduct}" />
            <h3 class="card-detail-title">{$product->prodname}</h3>
        </div>
        <div class="card-detail-body">
            <p class="card-detail-desc">{$product->description}</p>
            <p class="card-detail-price">Precio: {$product->price}</p>
            <p class="card-detail-cat">Categoría: {$product->catdescription}</p>
            {if $product->stock}
                <p class="card-detail-stock">Disponible</p>
                {else}
                    <p class="nodisp-detail">No disponible</p>
                {/if}
                <a class="card-detail-link" href="{BASE_URL}/home">Volver</a>
        </div>
    </div>
{include '../layouts/footer.tpl'}