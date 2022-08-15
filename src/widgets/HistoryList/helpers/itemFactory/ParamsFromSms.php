<?php

namespace app\widgets\HistoryList\helpers\itemFactory;

use app\models\Sms;
use app\widgets\HistoryList\helpers\itemFactory\contracts\ParamsCreatorInterface;
use Yii;

class ParamsFromSms implements ParamsCreatorInterface
{
    private Sms $sms;
    private CommonParams $commonParams;

    public function __construct(Sms $sms, CommonParams $commonParams)
    {
        $this->sms = $sms;
        $this->commonParams = $commonParams;
    }

    public function getViewName(): string
    {
        return ViewNameEnum::VIEW_COMMON;
    }

    public function getParams(): array
    {
        return [
            'userName' => $this->commonParams->getUserName(),
            'body' => $this->commonParams->getBody(),
            'footer' => $this->sms->direction == Sms::DIRECTION_INCOMING ?
                Yii::t('app', 'Incoming message from {number}', [
                    'number' => $this->sms->phone_from ?? ''
                ]) : Yii::t('app', 'Sent message to {number}', [
                    'number' => $this->sms->phone_to ?? ''
                ]),
            'footerDatetime' => $this->commonParams->getInsertTime(),
            'iconClass' => 'icon-sms bg-dark-blue'
        ];
    }
}
