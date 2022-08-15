<?php

namespace app\widgets\HistoryList\helpers\itemFactory;

use app\models\History;
use app\widgets\HistoryList\helpers\HistoryListHelper;

class CommonParams
{
    private ?string $userName;
    private string $body;
    private string $insertTime;

    public function __construct(History $history)
    {
        $this->body = HistoryListHelper::getBodyByModel($history);
        $this->userName = $history->user ? $history->user->username : null;
        $this->insertTime = $history->ins_ts;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getInsertTime(): string
    {
        return $this->insertTime;
    }
}
