<?php

namespace frontend\controllers;

use common\controller\FrontendController;
use common\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends FrontendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get','post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }




    //首页内容
    public function actionOrder()
    {

    }














    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
//        echo yii::t("app", "invalid{name}",['name'=>'数据']);
//        yii::error("invalid{name}", 'app');
//        exit;
        if (!Yii::$app->user->isGuest){
            return $this->redirect(['user/haha']);
        }
        $appid        = $this->APPID;
        $url          = "https://open.weixin.qq.com/connect/oauth2/authorize";
        $redirect_uri = urlencode(Url::to(['site/test'], true));
        $url          .= "?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=haha#wechat_redirect";

        $response = $this->redirect($url);

//        return $this->render('index');
    }


    //在这里获取code   再拿code 去获取网页授权access_token,openid,expires_in
    //{ "access_token":"ACCESS_TOKEN",
    //"expires_in":7200,
    //"refresh_token":"REFRESH_TOKEN",
    //"openid":"OPENID",
    //"scope":"SCOPE" }
    public function actionTest()
    {
        $code             = Yii::$app->request->get('code');
        $url              = "https://api.weixin.qq.com/sns/oauth2/access_token";
        $appid            = $this->APPID;
        $secret           = $this->APPSECRET;
        $url              .= "?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $result           = $this->https_request($url);
        $web_access_token = json_decode($result, true);

        $access_token  = $web_access_token['access_token'];
        $expires_in    = $web_access_token['expires_in'];
        $user_openid   = $web_access_token['openid'];
        $refresh_token = $web_access_token['refresh_token'];

        if ($user_openid) {
            $user = User::find()->where(['openid' => $user_openid])->one();
            if ($user) {
                Yii::$app->user->login($user,  3600 * 24 * 30);
                return $this->redirect(['user/index']);
            }
        }

        //根据access_token 获得用户的信息
        $url                 = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$user_openid&lang=zh_CN";
        $weixin_userinfo     = $this->https_request($url);
        $weixin_userinfo_arr = json_decode($weixin_userinfo, true);
//        var_dump($weixin_userinfo_arr);
//        exit;

        $user                = new User();
        $user->access_token  = $access_token;
        $user->expires_in    = $expires_in;
        $user->refresh_token = $refresh_token;
        $user->openid        = $weixin_userinfo_arr['openid'];
        $user->status        = 10;
        $user->username      = $weixin_userinfo_arr['nickname'];
        $user->nickname      = $weixin_userinfo_arr['nickname'];
        $user->sex           = $weixin_userinfo_arr['sex'];
        $user->province      = $weixin_userinfo_arr['province'];
        $user->city          = $weixin_userinfo_arr['city'];
        $user->country       = $weixin_userinfo_arr['country'];
        $user->headimgurl    = $weixin_userinfo_arr['headimgurl'];
        if (isset($weixin_userinfo_arr['privilege'])) {
            $user->privilege = json_encode($weixin_userinfo_arr['privilege']);
        }
        if (isset($weixin_userinfo_arr['unionid'])) {
            $user->unionid = $weixin_userinfo_arr['unionid'];
        }
        $user->created_at = time();
        if ($user->save()) {
            $user = User::find()->where(['openid' => $user_openid])->one();
            if ($user) {
                Yii::$app->user->login($user,  3600 * 24 * 30);
                return $this->redirect(['user/test']);
            }
        }
    }

    //刷新access_token
    //由于access_token拥有较短的有效期，
    //当access_token超时后，可以使用refresh_token进行刷新，refresh_token有效期为30天，
    //当refresh_token失效之后，需要用户重新授权
    //{ "access_token":"ACCESS_TOKEN",
    //"expires_in":7200,
    //"refresh_token":"REFRESH_TOKEN",
    //"openid":"OPENID",
    //"scope":"SCOPE" }
    public function actionTest2()
    {
        $appid = $this->APPID;
        $url   = "https://api.weixin.qq.com/sns/oauth2/refresh_token";
        $url   .= "?appid=$appid&grant_type=refresh_token&refresh_token=REFRESH_TOKEN";
    }


    //第四步：拉取用户信息(需scope为 snsapi_userinfo)
    //如果网页授权作用域为snsapi_userinfo，则此时开发者可以通过access_token和openid拉取用户信息了
    public function actionGetuserinfo()
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN";

        $result = $this->https_request($url);

    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
