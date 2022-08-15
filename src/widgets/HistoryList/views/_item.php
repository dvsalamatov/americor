<?php

use app\models\History;
use app\widgets\HistoryList\helpers\HistoryListHelper;
use app\widgets\HistoryList\helpers\itemFactory\ItemParamsFactory;

/**
 * @var History $model
 */

$body = HistoryListHelper::getBodyByModel($model);
$userName = $model->user ? $model->user->username : null;

$viewItemDto = ItemParamsFactory::create($model);

echo $this->render($viewItemDto->getViewName(), $viewItemDto->getParams());

