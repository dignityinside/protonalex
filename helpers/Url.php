<?php

namespace app\helpers;

/**
 * Url helper
 *
 * @author Alexander Schilling
 */
class Url
{

    /**
     * Returns query string
     *
     * @param array $params Params
     *
     * @return string
     */
    public static function getQueryString(array $params)
    {

        // Remove page number if page=1
        if (isset($params['page']) && $params['page'] == 1) {
            unset($params['page'], $params['per-page']);
        }

        if (!count($params)) {
            return '';
        }

        return '?' . http_build_query($params);

    }

}
