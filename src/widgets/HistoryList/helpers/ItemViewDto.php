<?php

namespace app\widgets\HistoryList\helpers;

class ItemViewDto
{
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
