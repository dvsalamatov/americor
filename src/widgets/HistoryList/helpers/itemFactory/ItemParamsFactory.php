<?php

namespace app\widgets\HistoryList\helpers\itemFactory;

use app\models\Call;
use app\models\Customer;
use app\models\Fax;
use app\models\History;
use app\models\Sms;
use app\models\Task;
use app\widgets\HistoryList\helpers\HistoryListHelper;
use app\widgets\HistoryList\helpers\ItemViewDto;
use Yii;
use yii\helpers\Html;

class ItemParamsFactory
{
    public static function create(History $model): ItemViewDto
    {
        $body = HistoryListHelper::getBodyByModel($model);
        $userName = $model->user ? $model->user->username : null;
        $insertTime = $model->ins_ts;

        switch ($model->event) {
            case History::EVENT_CREATED_TASK:
            case History::EVENT_COMPLETED_TASK:
            case History::EVENT_UPDATED_TASK:
                return ItemViewDto::create(
                    ItemViewDto::VIEW_COMMON,
                    self::fromTask($model->task, $userName, $body, $insertTime)
                );
            case History::EVENT_INCOMING_SMS:
            case History::EVENT_OUTGOING_SMS:
                return ItemViewDto::create(
                    ItemViewDto::VIEW_COMMON,
                    self::fromSms($model->sms, $userName, $body, $insertTime)
                );
            case History::EVENT_OUTGOING_FAX:
            case History::EVENT_INCOMING_FAX:
                return ItemViewDto::create(
                    ItemViewDto::VIEW_COMMON,
                    self::fromFax($model->fax, $userName, $body, $insertTime)
                );
            case History::EVENT_CUSTOMER_CHANGE_TYPE:
                return ItemViewDto::create(
                    ItemViewDto::VIEW_STATUS_CHANGE,
                    self::fromChangeType($model)
                );
            case History::EVENT_CUSTOMER_CHANGE_QUALITY:
                return ItemViewDto::create(
                    ItemViewDto::VIEW_STATUS_CHANGE,
                    self::fromChangeQuality($model)
                );
            case History::EVENT_INCOMING_CALL:
            case History::EVENT_OUTGOING_CALL:
                return ItemViewDto::create(
                    ItemViewDto::VIEW_COMMON,
                    self::fromCall($model->call, $userName, $body, $insertTime)
                );
            default:
                return ItemViewDto::create(
                    ItemViewDto::VIEW_COMMON,
                    self::default($userName, $body, $insertTime)
                );
        }
    }

    private static function fromChangeQuality(History $model): array
    {
        return [
            'model' => $model,
            'oldValue' => Customer::getQualityTextByQuality($model->getDetailOldValue('quality')),
            'newValue' => Customer::getQualityTextByQuality($model->getDetailNewValue('quality')),
        ];
    }

    private static function fromChangeType(History $model): array
    {
        return [
            'model' => $model,
            'oldValue' => Customer::getTypeTextByType($model->getDetailOldValue('type')),
            'newValue' => Customer::getTypeTextByType($model->getDetailNewValue('type'))
        ];
    }

    private static function fromTask(?Task $task, ?string $userName, string $body, string $insertTime): array
    {
        return [
            'userName' => $userName,
            'body' => $body,
            'iconClass' => 'fa-check-square bg-yellow',
            'footerDatetime' => $insertTime,
            'footer' => isset($task->customerCreditor->name)
                ? "Creditor: " . $task->customerCreditor->name
                : ''
        ];
    }

    private static function fromFax(?Fax $fax, ?string $userName, string $body, string $insertTime): array
    {
        return [
            'userName' => $userName,
            'body' => $body .
                ' - ' .
                (isset($fax->document) ? Html::a(
                    Yii::t('app', 'view document'),
                    $fax->document->getViewUrl(),
                    [
                        'target' => '_blank',
                        'data-pjax' => 0
                    ]
                ) : ''),
            'footer' => Yii::t('app', '{type} was sent to {group}', [
                'type' => $fax ? $fax->getTypeText() : 'Fax',
                'group' => isset($fax->creditorGroup)
                    ? Html::a($fax->creditorGroup->name, ['creditors/groups'], ['data-pjax' => 0])
                    : ''
            ]),
            'footerDatetime' => $insertTime,
            'iconClass' => 'fa-fax bg-green'
        ];
    }

    private static function fromCall(?Call $call, ?string $userName, string $body, string $insertTime): array
    {
        $answered = $call && $call->status == Call::STATUS_ANSWERED;

        return [
            'userName' => $userName,
            'content' => $call->comment ?? '',
            'body' => $body,
            'footerDatetime' => $insertTime,
            'footer' => isset($call->applicant) ? "Called <span>{$call->applicant->name}</span>" : null,
            'iconClass' => $answered ? 'md-phone bg-green' : 'md-phone-missed bg-red',
        ];
    }

    private static function fromSms(Sms $sms, ?string $userName, string $body, string $insertTime): array
    {
        return [
            'userName' => $userName,
            'body' => $body,
            'footer' => $sms->direction == Sms::DIRECTION_INCOMING ?
                Yii::t('app', 'Incoming message from {number}', [
                    'number' => $model->sms->phone_from ?? ''
                ]) : Yii::t('app', 'Sent message to {number}', [
                    'number' => $model->sms->phone_to ?? ''
                ]),
            'footerDatetime' => $insertTime,
            'iconClass' => 'icon-sms bg-dark-blue'
        ];
    }

    private static function default(?string $userName, string $body, string $insertTime): array
    {
        return [
            'userName' => $userName,
            'body' => $body,
            'bodyDatetime' => $insertTime,
            'iconClass' => 'fa-gear bg-purple-light'
        ];
    }
}
