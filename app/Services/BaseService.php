<?php

namespace App\Services;

use App\Helpers\DatetimeHelper;

class BaseService
{
    /**
     * the currently authenticated account
     * @var object
     */
    protected object $account;

    /**
     * the ID for the currently authenticated account
     * @var int
     */
    protected int $accountId;

    /**
     * email for the currently authenticated account
     * @var string
     */
    protected string $accountEmail;

    /**
     * @return object
     */
    public function getAccount(): object
    {
        return $this->account;
    }

    /**
     * @param object $account
     */
    public function setAccount(object $account): void
    {
        $this->account = $account;

        $this->setAccountAttribute();
    }

    /**
     * set Account Attribute
     * @return void
     */
    public function setAccountAttribute(): void
    {
        $this->setAccountId($this->getAccount()->id);

        $this->setAccountEmail($this->getAccount()->email);
    }

    /**
     * @return int
     */
    public function getAccountId(): int
    {
        return $this->accountId;
    }

    /**
     * @param int $accountId
     */
    public function setAccountId(int $accountId): void
    {
        $this->accountId = $accountId;
    }

    /**
     * @return string
     */
    public function getAccountEmail(): string
    {
        return $this->accountEmail;
    }

    /**
     * @param string $accountEmail
     */
    public function setAccountEmail(string $accountEmail): void
    {
        $this->accountEmail = $accountEmail;
    }

    /**
     * get Created Columns
     * @return array
     */
    public function getCreatedColumns(): array
    {
        $createdColumns = [
            'created_at' => DatetimeHelper::getDatetime(),
            'created_by' => $this->getAccountEmail(),
        ];

        return $createdColumns;
    }

    /**
     * get Updated Columns
     * @return array
     */
    public function getUpdatedColumns(): array
    {
        return [
            'updated_at' => DatetimeHelper::getDatetime(),
            'updated_by' => $this->getAccountEmail(),
        ];
    }

    /**
     * get Created Updated Columns
     * @return array
     */
    public function getCreatedUpdatedColumns(): array
    {
        return array_merge(
            $this->getCreatedColumns(),
            $this->getUpdatedColumns()
        );
    }

}
