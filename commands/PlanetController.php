<?php

namespace app\commands;

use app\models\Planet;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class PlanetController
 *
 * @package app\commands
 *
 * @author Alexander Schilling
 */
class PlanetController extends Controller
{

    /** @var int */
    private const ITEMS = 5;

    /** @var string */
    private const NOT_OLDER_THAN = 'P30D';

    /**
     * Alias for fetch
     *
     * @throws \Exception
     */
    public function actionIndex()
    {
        return $this->actionFetch();
    }

    /**
     * Action fetch posts form rss feeds
     *
     * @throws \Exception
     */
    public function actionFetch()
    {

        $feedList = \Yii::$app->params['planetFeeds'];

        if (empty($feedList)) {
            print "Пожалуйста добавьте хотя бы одну RSS ленту в config/params.php.\n";
            return ExitCode::OK;
        }

        // emulate rss reader

        ini_set('user_agent', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:16.0) Gecko/20100101 Firefox/16.0');

        foreach ($feedList as $feed => $author) {

            if (!$xml = simplexml_load_file($feed)) {
                break;
            }

            if (!isset($xml->channel[0]->item)) {
                break;
            }

            $i = self::ITEMS;

            foreach ($xml->channel[0]->item as $item) {

                if ($i-- == 0) {
                    break;
                }

                // posts not older than x days

                $today = new \DateTime();
                $today = $today->getTimestamp();
                $date = new \DateTime($item->pubDate);
                $date->add(new \DateInterval(self::NOT_OLDER_THAN));
                $date = $date->getTimestamp();

                if ($today > $date) break;

                $title = (string)$item->title;

                // check title in db

                $model = Planet::findOne(['title' => $title]);

                if (!$model) {

                    // save data

                    $model = new Planet();

                    $model->title = $title;
                    $model->description = (string)$item->description;
                    $model->guid = (string)$item->guid;
                    $model->link = (string)$item->link;
                    $model->pub_date = strtotime((string)$item->pubDate) ? strtotime((string)$item->pubDate) : time();
                    $model->author = $author;
                    $model->status_id = Planet::STATUS_PUBLIC;

                }

                // error on save

                if (!$model->save()) {
                    print_r($model->getErrors());
                }

            }

        }

        return ExitCode::OK;

    }

}
