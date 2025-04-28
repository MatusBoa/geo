<?php

declare(strict_types=1);

namespace App\Core\Database\Concern\Model;

use Carbon\CarbonInterface;
use App\Core\Database\Contract\Model\HasTimestampsInterface;

trait HasTimestampsTrait
{
    /**
     * Laravel's magic method that initializes this trait
     *
     * @see https://medium.com/swlh/laravel-booting-and-initializing-models-with-traits-2f77059b1915
     */
    public function initializeHasTimestampsTrait(): void
    {
        $this->mergeCasts([
            HasTimestampsInterface::ATTR_CREATED_AT => 'datetime',
            HasTimestampsInterface::ATTR_UPDATED_AT => 'datetime',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): CarbonInterface
    {
        return $this->getAttributeValue(HasTimestampsInterface::ATTR_CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): CarbonInterface
    {
        return $this->getAttributeValue(HasTimestampsInterface::ATTR_UPDATED_AT);
    }
}
