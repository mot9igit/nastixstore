<div class="nsCart cart {$count > 0 ? 'full' : ''}">
    <div class="empty">
        <a href="{$_modx->makeUrl(9)}" class="inliner vam">
			<span class="carticon">
				<i class="fa fa-shopping-cart"></i>
				<span class="count ns_total_count">{$count}</span>
			</span>
            <div class="cart-info hidden-sm">
                <span class="title">Корзина</span>
                <span class="info">
					<span class="ns_total_cost">{$cost}</span> <i class="fa fa-ruble"></i>
				</span>
            </div>
        </a>
    </div>
</div>