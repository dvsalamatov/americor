<?php

namespace app\widgets\HistoryList\helpers\itemFactory;

use app\models\Sms;
use app\models\Task;
use app\widgets\HistoryList\helpers\itemFactory\contracts\ParamsCreatorInterface;

class ParamsFromTask implements ParamsCreatorInterface
{
    private ?Task $task;
    private CommonParams $commonParams;

    public function __construct(?Task $task, CommonParams $commonParams)
    {
        $this->task = $task;
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
            'iconClass' => 'fa-check-square bg-yellow',
            'footerDatetime' => $this->commonParams->getInsertTime(),
            'footer' => isset($this->task->customerCreditor->name)
                ? "Creditor: " . $this->task->customerCreditor->name
                : ''
        ];
    }
}
