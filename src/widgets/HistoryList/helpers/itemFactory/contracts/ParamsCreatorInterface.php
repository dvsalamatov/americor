<?php

namespace app\widgets\HistoryList\helpers\itemFactory\contracts;

interface ParamsCreatorInterface
{
    public function getViewName(): string;

    public function getParams(): array;
}
