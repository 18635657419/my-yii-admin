<?php
namespace common\components\payment;

use Yii;
use Omnipay\Omnipay;

/**
 * Class AliPay
 * @package common\components\payment
 */
class AliPay
{
    protected $config;

    /**
     * 类型
     *
     * @var array
     */
    protected $type = [
        'pc' => 'Alipay_AopPage',
        'app' => 'Alipay_AopApp',
        'f2f' => 'Alipay_AopF2F',
        'wap' => 'Alipay_AopWap',
    ];

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 实例化类
     *
     * @param string $type
     * @return mixed
     */
    private function _create($type = 'Alipay_AopApp')
    {
        $gateway = Omnipay::create($type);
        $gateway->setSignType('RSA2'); // RSA/RSA2/MD5
        $gateway->setAppId($this->config['app_id']);
        $gateway->setAlipayPublicKey($this->config['ali_public_key']);
        $gateway->setPrivateKey($this->config['private_key']);
        $gateway->setNotifyUrl($this->config['notify_url']);

        return $gateway;
    }

    /**
     * 电脑网站支付
     *
     * @param $config
     *
     * 参数说明
     * $config = [
     *     'subject'      => 'test',
     *     'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
     *     'total_amount' => '0.01',
     * ]
     */
    public function pc($order)
    {
        $order['product_code'] = 'FAST_INSTANT_TRADE_PAY';

        $gateway = $this->_create('Alipay_AopPage');
        $request = $gateway->purchase();
        $request->setBizContent($order);

        /**
         * @var AopTradeAppPayResponse $response
         */
        $response = $request->send();
        $redirectUrl = $response->getRedirectUrl();

        /**
         * 直接跳转
         * return $response->redirect();
         */
        return $redirectUrl;
    }

    /**
     * APP支付
     *
     * 参数说明
     * $config = [
     *     'subject'      => 'test',
     *     'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
     *     'total_amount' => '0.01',
     * ]
     *
     * iOS 客户端
     * [[AlipaySDK defaultService] payOrder:orderString fromScheme:appScheme callback:^(NSDictionary *resultDic) {
     *      NSLog(@"reslut = %@",resultDic);
     * }];
     *
     * Android 客户端
     * PayTask alipay = new PayTask(PayDemoActivity.this);
     * Map<String, String> result = alipay.payV2(orderString, true);
     * @param $config
     * @param $notifyUrl
     * @return mixed
     */
    public function app($order)
    {
        $order['product_code'] = 'QUICK_MSECURITY_PAY';

        $gateway = $this->_create('Alipay_AopApp');
        $request = $gateway->purchase();
        $request->setBizContent($order);

        /**
         * @var AopTradeAppPayResponse $response
         */
        $response = $request->send();
        return $response->getOrderString();
    }

    /**
     * 面对面支付
     *
     * @param $order
     * @return mixed
     */
    public function f2f($order)
    {
        $gateway = $this->_create('Alipay_AopF2F');
        $request = $gateway->purchase();
        $request->setBizContent($order);

        /**
         * @var AopTradeAppPayResponse $response
         */
        $response = $request->send();
        return $response->getQrCode();
    }

    /**
     * 手机网站支付
     *
     * @param $order
     * @return mixed
     */
    public function wap($order)
    {
        $order['product_code'] = 'QUICK_WAP_PAY';

        $gateway = $this->_create('Alipay_AopWap');
        $request = $gateway->purchase();
        $request->setBizContent($order);

        /**
         * @var AopTradeAppPayResponse $response
         */
        $response = $request->send();

        /**
         * 直接跳转
         * return $response->redirect();
         */
        return $response->getRedirectUrl();
    }

    /**
     * 退款
     *
     *[
     *     'out_trade_no' => 'The existing Order ID',
     *     'trade_no' => 'The Transaction ID received in the previous request',
     *     'refund_amount' => 18.4,
     *     'out_request_no' => date('YmdHis') . mt_rand(1000, 9999)
     *  ]
     */
    public function refund(array $info)
    {
        $gateway = $this->_create();
        $request = $gateway->refund();
        $response = $request->setBizContent($info);

        return $response->getData();
    }

    /**
     * 扫码收款
     *
     * @return mixed
     */
    public function capture()
    {
        $gateway = $this->_create('Alipay_AopF2F');
        $request = $gateway->capture();

        return $request;
    }

    /**
     * 异步/同步通知
     *
     * @return mixed
     */
    public function notify()
    {
        $gateway = $this->_create();
        $request = $gateway->completePurchase();
        $request->setParams(array_merge(Yii::$app->request->post(), Yii::$app->request->get()));//Optional

        return $request;
    }
}
