<?php

namespace app\widgets\HistoryList\helpers\itemFactory;

use app\models\History;
use app\widgets\HistoryList\helpers\itemFactory\contracts\ParamsCreatorInterface;
use app\widgets\HistoryList\helpers\ItemViewDto;

class ItemParamsFactory
{
    private string $eventName;

    public function __construct(string $eventName)
    {
        $this->eventName = $eventName;
    }

    private function createParamsCreator(History $history): ParamsCreatorInterface
    {
        $commonParams = new CommonParams($history);

        switch ($this->eventName) {
            case History::EVENT_CREATED_TASK:
            case History::EVENT_COMPLETED_TASK:
            case History::EVENT_UPDATED_TASK:
                return new ParamsFromTask($history->task, $commonParams);
            case History::EVENT_INCOMING_SMS:
            case History::EVENT_OUTGOING_SMS:
                return new ParamsFromSms($history->sms, $commonParams);
            case History::EVENT_OUTGOING_FAX:
            case History::EVENT_INCOMING_FAX:
                return new ParamsFromFax($history->fax, $commonParams);
            case History::EVENT_CUSTOMER_CHANGE_TYPE:
                return new ParamsFromChangeType($history);
            case History::EVENT_CUSTOMER_CHANGE_QUALITY:
                return new ParamsFromChangeQuanlity($history);
            case History::EVENT_INCOMING_CALL:
            case History::EVENT_OUTGOING_CALL:
                return new ParamsFromCall($history->call, $commonParams);
            default:
                return new ParamsFromDefault($commonParams);
        }
    }

    public function create(History $history): ItemViewDto
    {
        $paramsCreator = $this->createParamsCreator($history);

        return ItemViewDto::create(
            $paramsCreator->getViewName(),
            $paramsCreator->getParams()
        );
    }
}
