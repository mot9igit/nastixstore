<div class="nsCart table-responsives">
    {if !count($products)}
    <div class="alert alert-info">Корзина пуста</div>
    {else}
    <table class="table table-cart">
        <tbody>
        <tr class="header">
            <th class="cart-image">&nbsp;</th>
            <th class="">Наименование</th>
            <th class="">Количество</th>
            <th class="">Цена</th>
            <!--<th class="">Сумма</th>-->
            <th class="">Удалить</th>
        </tr>
        {foreach $products as $key => $product}
            <tr id="key_{$key}">
                <td class="cart-image">
                    {if ($key | resource: 'image')}
                        <img src="{$key | resource: 'image'}" alt="{$key | resource: 'pagetitle' | htmlent}" title="{$key | resource: 'pagetitle' | htmlent}">
                    {else}
                        <img src="{$_modx->getPlaceholder('+conf_noimage')}" alt="{$key | resource: 'pagetitle' | htmlent}" title="{$key | resource: 'pagetitle' | htmlent}"/>
                    {/if}
                </td>
                <td class="">
                    <a href="{$key | url}">{$key | resource: 'pagetitle' | htmlent}</a><br>
                </td>
                <td class="count">
                    <form method="post" class="ns_form form-inline" role="form">
                        <input type="hidden" name="key" value="{$key}">
                        <input type="hidden" name="ns_action" value="cart/change">
                        <div class="form-group">
                            <input type="number" name="count" value="{$product.count}" max-length="4" class="input-sm form-control"> шт.
                        </div>
                    </form>
                </td>
                <td class="price"><span>{$product.price}</span> руб.</td>
                <!--
                <td class="nds_price">
                    <span>{$product.cost}</span> руб.
                </td>
                -->
                <td class="">
                    <form method="post" class="ns_form">
                        <input type="hidden" name="key" value="{$key}">
                        <input type="hidden" name="ns_action" value="cart/remove">
                        <button class="btn btn--cart" type="submit" title="Удалить"><i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </form>
                </td>
            </tr>
        {/foreach}

        <tr class="footer">
            <th class="total" colspan="2">Итого:</th>
            <th class="total_count"><span class="ns_total_count">{$total.count}</span> шт.</th>
            <th class="total_cost" ><span class="ns_total_cost">{$total.cost}</span> руб.</th>
            <th>&nbsp;</th>
        </tr>
        </tbody>
    </table>
{/if}
    <form class="form-horizontal ns_form" method="post">
        <input type="hidden" name="ns_action" value="order/submit">
        <div class="row">
            <div class="col-md-6">
                <h4>Данные получателя:</h4>
                <hr class="lines">
                <div class="form-group input-parent row required">
                    <label class="col-sm-3 control-label" for="email">
                        Email <span class="required-star">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" id="email" placeholder="Email" name="email" value="" class="form-control required">
                    </div>
                </div>
                <div class="form-group input-parent row required">
                    <label class="col-sm-3 control-label" for="receiver">
                        Получатель <span class="required-star">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" id="fullname" placeholder="Получатель" name="fullname" value="" class="form-control required">
                    </div>
                </div>
                <div class="form-group input-parent row">
                    <label class="col-sm-3 control-label" for="phone">
                        Телефон <span class="required-star">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" id="phone" placeholder="Телефон" name="phone" value="" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h4>Адрес доставки:</h4>
                <hr class="lines">
                <div class="form-group input-parent row">
                    <label class="col-sm-3 control-label" for="index">
                        <span class="required-star">*</span> Почтовый индекс		</label>
                    <div class="col-sm-9">
                        <input type="text" id="index" placeholder="Почтовый индекс" name="index" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group input-parent row">
                    <label class="col-sm-3 control-label" for="region">
                        <span class="required-star">*</span> Область		</label>
                    <div class="col-sm-9">
                        <input type="text" id="region" placeholder="Область" name="region" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group input-parent row">
                    <label class="col-sm-3 control-label" for="city">
                        <span class="required-star">*</span> Город		</label>
                    <div class="col-sm-9">
                        <input type="text" id="city" placeholder="Город" name="city" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group input-parent row">
                    <label class="col-sm-3 control-label" for="street">
                        <span class="required-star">*</span> Улица</label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="text" id="street" placeholder="Улица" name="street" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" id="house" placeholder="Дом" name="house" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" id="room" placeholder="Комната" name="room" value="" class="form-control">
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6" id="deliveries">
                <h4>Варианты доставки:</h4>
                <hr class="lines">
                <div class="form-group row">
                    <label class="col-sm-3 control-label">
                        <span class="required-star">*</span> Выберите доставку		</label>
                    <div class="col-sm-9">
                        {$_modx->runSnippet("ns_delivery")}
                    </div>
                </div>
            </div>

        </div>

        <hr>
        <div class="well row">
            <div class="offset-sm-2 col-sm-10">
                <h3>Итого:
                    <span class="ns_order_cost">{$total.cost}</span>
                    руб.	  </h3>
                <button type="submit" class="btn btn-blue ms2_link">
                    Сделать заказ!	  </button>
            </div>
        </div>
    </form>
</div>