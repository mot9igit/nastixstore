<p>Уважаемый покупатель! Ваш заказ успешно оформлен и поставлен в очередь на обработку. В ближайшее время с вами свяжется наш специалист для уточнения деталей заказа. Заказу был присвоен номер:</p>
<div class="text-center">
    <span class="order_num">{$order.id}</span>
</div>
<div class="nscart msgetorder">
    {foreach $products as $key => $product}
        <div class="order-item _mb-lg">
            <div class="grid _items-center _justify-between">
                <div class="gcell gcell--2">
                    {if ($key | resource: 'image')}
                        <img src="{$key | resource: 'image'}" alt="{$key | resource: 'pagetitle' | htmlent}" title="{$key | resource: 'pagetitle' | htmlent}">
                    {else}
                        <img src="{$_modx->getPlaceholder('+conf_noimage')}" alt="{$key | resource: 'pagetitle' | htmlent}" title="{$key | resource: 'pagetitle' | htmlent}"/>
                    {/if}
                </div>
                <div class="gcell gcell--6">
                    <p class="order-item__text">{$key | resource: 'pagetitle'}</p>
                </div>
                <div class="gcell gcell--3">
                    <div class="order-item__total">{$product.count}&nbsp;x&nbsp;<span>{$product.price}</span>&nbsp;<span>&#8381;</span></div>
                </div>
            </div>
        </div>
    {/foreach}
</div>

<h4>
    Итого:
    <strong>{$order.cost}</strong> руб.
</h4>
</div>