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
namespace App\Controller\V1\Test;

use App\Controller\AbstractController;
use App\Service\Test\TestService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

/**
 * Class IndexController.
 * @Controller(prefix="test")
 */
class TestController extends AbstractController
{
    /**
     * @Inject
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    /**
     * @Inject
     * @var TestService
     */
    protected $testService;

    /**
     * @RequestMapping(path="testValidation", methods="get,post")
     */
    public function testValidation()
    {
        $validator = $this->validationFactory->make(
            $this->request->all(),
            [
                'foo' => 'required|max:10',
                'bar' => 'required',
            ],
            [
                'foo.required' => 'foo不能为空',
                'foo.max' => 'foo最多只能为10个字符',
                'bar.required' => 'bar is required',
            ]
        );

        if ($validator->fails()) {
            // Handle exception
            $errorMessage = $validator->errors()->first();
            return ['code' => '100', 'msg' => $errorMessage];
        }
        return ['code' => '200', 'msg' => 'success'];
    }

    /**
     * @RequestMapping(path="testSession", methods="get,post")
     */
    public function testSession(): array
    {
        $result = $this->testService->testSession();
        if ($result) {
            return ['code' => '200', 'msg' => 'success', 'data' => $result];
        }
        return ['code' => '100', 'msg' => 'fail'];
    }

    /**
     * @RequestMapping(path="testSetOne", methods="post")
     */
    public function testSetOne(): array
    {
        $result = $this->testService->testSetOne();
        if ($result) {
            return ['code' => '200', 'msg' => 'success', 'data' => $result];
        }
        return ['code' => '100', 'msg' => 'fail'];
    }
}
