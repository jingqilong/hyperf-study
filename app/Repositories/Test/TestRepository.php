<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Repositories\Test;

use App\Model\Test\TestModel;

class TestRepository extends ApiRepository
{

    /**
     * MemberBaseRepository constructor.
     * @param TestModel $model
     */
    public function __construct(TestModel $model)
    {
        $this->model = $model;
    }
}
