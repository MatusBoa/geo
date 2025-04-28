<?php

declare(strict_types=1);

namespace App\Core\Database\Contract\Model;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

interface HasTimestampsInterface
{
    public const string ATTR_CREATED_AT = Model::CREATED_AT;
    public const string ATTR_UPDATED_AT = Model::UPDATED_AT;

    /**
     * @return \Carbon\CarbonInterface
     */
    public function getCreatedAt(): CarbonInterface;

    /**
     * @return \Carbon\CarbonInterface
     */
    public function getUpdatedAt(): CarbonInterface;
}
