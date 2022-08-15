<?php

namespace app\widgets\HistoryList\helpers\itemFactory;

use app\models\Call;
use app\models\Sms;
use app\widgets\HistoryList\helpers\itemFactory\contracts\ParamsCreatorInterface;

class ParamsFromCall implements ParamsCreatorInterface
{
    private ?Call $call;
    private CommonParams $commonParams;

    public function __construct(?Call $call, CommonParams $commonParams)
    {
        $this->call = $call;
        $this->commonParams = $commonParams;
    }

    public function getViewName(): string
    {
        return ViewNameEnum::VIEW_COMMON;
    }

    public function getParams(): array
    {
        $answered = $this->call && $this->call->status == Call::STATUS_ANSWERED;

        return [
            'userName' => $this->commonParams->getUserName(),
            'content' => $this->call->comment ?? '',
            'body' => $this->commonParams->getBody(),
            'footerDatetime' => $this->commonParams->getInsertTime(),
            'footer' => isset($this->call->applicant) ? "Called <span>{$this->call->applicant->name}</span>" : null,
            'iconClass' => $answered ? 'md-phone bg-green' : 'md-phone-missed bg-red',
        ];
    }
}
