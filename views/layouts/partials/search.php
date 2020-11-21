<div class="nav navbar-nav navbar-right">
    <div class="widget-content search">
        <?= \yii\helpers\Html::beginForm('/search', 'get', ['id' => 'search-form-nav', 'class' => 'navbar-form']) ?>
            <div class="form-group nospace">
                <input type="text" class="form-control" id="search" name="text" placeholder="Поиск" autocomplete="off" value="">
                <input type="hidden" name="searchid" value="2433156"/>
                <input type="hidden" name="l10n" value="ru"/>
                <input type="hidden" name="reqenc" value="utf-8"/>
            </div>
        <?= \yii\helpers\Html::endForm() ?>
    </div>
</div>
