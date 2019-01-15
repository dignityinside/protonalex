<?php

namespace app\commands;

use app\models\User;
use app\models\Video;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class VideoController
 *
 * @package app\commands
 *
 * @author Alexander Schilling
 */
class VideoController extends Controller
{

    /** @var int */
    private const ITEMS = 5;

    /** @var string */
    private const NOT_OLDER_THAN = 'P30D';

    public function init()
    {

        parent::init();

        \Yii::$app->user->setIdentity(User::findOne(['id' => \Yii::$app->params['video']['userId']]));

    }

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
     * Action fetch videos form rss feeds
     *
     * @throws \Exception
     */
    public function actionFetch()
    {

        $videoConfig = \Yii::$app->params['video'];

        if (empty($videoConfig)) {
            print "Пожалуйста отредактируйте Video в config/params.php.\n";
            return ExitCode::OK;
        }

        $this->emulateRssReader();

        foreach ($videoConfig as $key => $value) {

            if ($key === 'youtubeFeeds') {

                foreach ($value as $feed => $author) {
                    $this->parseYoutube($feed, $author);
                }

            }

        }

        return ExitCode::OK;

    }

    /**
     * Parse youtube videos from rss feed
     *
     * @param string $feed
     * @param string $author
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function parseYoutube(string $feed, string $author): array
    {

        if (!$xml = simplexml_load_file($feed)) {
            return [];
        }

        if (!isset($xml->entry)) {
            return [];
        }

        $i = self::ITEMS;

        foreach ($xml->entry as $video) {

            if ($i-- == 0) {
                break;
            }

            $date = new \DateTime($video->published);
            $data['published'] = $date->getTimestamp();

            $data['title'] = (string)$video->title;
            $data['description'] = (string)$video->children('http://search.yahoo.com/mrss/')->group->description;
            $data['code'] = (string)$video->children('http://www.youtube.com/xml/schemas/2015')->videoId;
            $data['platform'] = Video::PLATFORM_YOUTUBE;
            $data['thumbnail'] = (string)$video->children('http://search.yahoo.com/mrss/')->group->thumbnail->attributes()->url;

            $this->saveVideo($data, $author);

        }

        return [];

    }

    /**
     * Save video
     *
     * @param array $video
     * @param string $author
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function saveVideo(array $video, string $author): void
    {

        // videos not older than x days

        $today = new \DateTime();
        $today = $today->getTimestamp();

        $date = new \DateTime(date('d.m.Y H:i', $video['published']));
        $date->add(new \DateInterval(self::NOT_OLDER_THAN));
        $date = $date->getTimestamp();

        if ($today > $date) return;

        // check title in db

        $title = $video['title'];

        $model = Video::findOne(['title' => $title]);

        if (!$model) {

            // save data

            $model = new Video();

            $model->title = $title;
            $model->description = $video['description'];
            $model->code = $video['code'];
            $model->published = $video['published'];
            $model->author = $author;
            $model->status_id = \Yii::$app->params['video']['preModeration'] ? Video::STATUS_HIDDEN : Video::STATUS_PUBLIC;;
            $model->thumbnail = $video['thumbnail'];
            $model->platform = $video['platform'];
            $model->user_id = \Yii::$app->params['video']['userId'];

        }

        // error on save

        if (!$model->save()) {
            print_r($model->getErrors());
        }

    }

    /**
     * Emulate rss reader
     *
     * @return void
     */
    protected function emulateRssReader(): void
    {
        ini_set('user_agent', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:16.0) Gecko/20100101 Firefox/16.0');
    }
}
