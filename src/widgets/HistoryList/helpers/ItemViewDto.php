<?php

namespace app\widgets\HistoryList\helpers;

class ItemViewDto
{
    const VIEW_COMMON = '_item_common';
    const VIEW_STATUS_CHANGE = '_item_statuses_change';

    private string $viewName;

    private array $params;

    public static function create(string $viewName, array $params): self
    {
        $dto = new self;
        $dto->viewName = $viewName;
        $dto->params = $params;

        return $dto;
    }

    public function getViewName(): string
    {
        return $this->viewName;
    }

    public function getParams(): array
    {
        return $this->params;
    }

}
