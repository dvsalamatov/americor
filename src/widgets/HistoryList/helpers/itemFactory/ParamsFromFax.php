<?php

namespace app\widgets\HistoryList\helpers\itemFactory;

use app\models\Fax;
use app\widgets\HistoryList\helpers\itemFactory\contracts\ParamsCreatorInterface;
use Yii;
use yii\helpers\Html;

class ParamsFromFax implements ParamsCreatorInterface
{
    private ?Fax $fax;
    private CommonParams $commonParams;

    public function __construct(?Fax $fax, CommonParams $commonParams)
    {
        $this->fax = $fax;
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
            'body' => $this->commonParams->getBody() .
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
            'footerDatetime' => $this->commonParams->getInsertTime(),
            'iconClass' => 'fa-fax bg-green'
        ];
    }
}
