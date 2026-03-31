<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Cookie;

class LanguageController extends Controller
{
    /**
     * 
     * @param string 
     */
    public function actionChange($lang)
    {
        if (in_array($lang, ['uz', 'ru', 'en'])) {
            
            $cookie = new Cookie([
                'name' => 'language',
                'value' => $lang,
                'expire' => time() + 86400 * 30,
                'domain' => '',
            ]);
            
            Yii::$app->getResponse()->getCookies()->add($cookie);
            
            Yii::$app->language = $lang;
        }

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }
}
