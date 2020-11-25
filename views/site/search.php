<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Поиск по сайту';

$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);
?>

<div class="site-search">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="ya-site-form ya-site-form_inited_no" onclick="return {'action':'https://protonduck.com/search','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'Поиск по сайту protonduck.com','suggest':true,'target':'_self','tld':'ru','type':2,'usebigdictionary':true,'searchid':2433156,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':null,'input_placeholderColor':'#000000','input_borderColor':'#7f9db9'}"><form action="https://yandex.ru/search/site/" method="get" target="_self" accept-charset="utf-8"><input type="hidden" name="searchid" value="2328465"/><input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value="utf-8"/><input type="search" name="text" value=""/><input type="submit" value="Найти"/></form></div><style>.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script>(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>

    <div id="ya-site-results" onclick="return {'tld': 'ru','language': 'ru','encoding': 'utf-8','htmlcss': '1.x','updatehash': true}"></div><script>(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0];s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Results.init();})})(window,document,'yandex_site_callbacks');</script>

</div>
