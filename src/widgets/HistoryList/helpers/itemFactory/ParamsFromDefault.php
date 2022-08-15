<?php

namespace app\widgets\HistoryList\helpers\itemFactory;

use app\widgets\HistoryList\helpers\itemFactory\contracts\ParamsCreatorInterface;

class ParamsFromDefault implements ParamsCreatorInterface
{
    private CommonParams $commonParams;

    public function __construct(CommonParams $commonParams)
    {
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
            'bodyDatetime' => $this->commonParams->getInsertTime(),
            'iconClass' => 'fa-gear bg-purple-light'
        ];
    }
}
