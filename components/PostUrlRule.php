<?php

namespace app\components;

use app\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use app\models\Post;

/**
 * Class PostUrlRule
 *
 * @package app\components
 *
 * @author Alexander Schilling
 */
class PostUrlRule extends BaseObject implements UrlRuleInterface
{

    /**
     * Create url
     *
     * @param \yii\web\UrlManager $manager
     * @param string              $route
     * @param array               $params
     *
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {

        if ($route === 'post/view') {

            if (isset($params['slug'])) {
                return $params['slug'];
            }

        } elseif ($route === 'post/tag') {

            if (!($tagName = ArrayHelper::remove($params, 'tagName'))) {
                return false;
            }

            return "/tag/$tagName" . Url::getQueryString($params);

        }

        return false; // this rule does not apply
    }

    /**
     * Parse request
     *
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request    $request
     *
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public function parseRequest($manager, $request)
    {

        $pathInfo = $request->getPathInfo();
        $parts = explode('/', $pathInfo);

        if (preg_match('/^[a-zA-Z0-9_-]+$/', $pathInfo)) {

            if (Post::find()->where(['slug' => $pathInfo])->exists()) {
                return ['post/view', ['slug' => $pathInfo]];
            }

        } elseif (isset($parts[0]) && $parts[0] === 'tag' && !empty($parts[1])) {
            return ['post/tag', ['tagName' => $parts[1]]];
        }

        return false; // this rule does not apply

    }
}