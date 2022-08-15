<?php

namespace app\widgets\HistoryList\helpers\itemFactory;

use app\models\Customer;
use app\models\History;
use app\widgets\HistoryList\helpers\itemFactory\contracts\ParamsCreatorInterface;

class ParamsFromChangeQuanlity implements ParamsCreatorInterface
{
    private History $history;

    public function __construct(History $history)
    {
        $this->history = $history;
    }

    public function getViewName(): string
    {
        return ViewNameEnum::VIEW_STATUS_CHANGE;
    }

    public function getParams(): array
    {
        return [
            'model' => $this->history,
            'oldValue' => Customer::getQualityTextByQuality($this->history->getDetailOldValue('quality')),
            'newValue' => Customer::getQualityTextByQuality($this->history->getDetailNewValue('quality')),
        ];
    }
}
