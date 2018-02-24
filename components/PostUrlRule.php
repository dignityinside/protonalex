<?php

namespace app\components;

use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use app\models\Post;

/**
 * Class PostUrlRule
 *
 * @package app\components
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
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

        if (preg_match('/^[a-zA-Z0-9_-]+$/', $pathInfo)) {

            if (Post::find()->where(['slug' => $pathInfo])->exists()) {
                return ['post/view', ['slug' => $pathInfo]];
            }

        }

        return false; // this rule does not apply

    }
}