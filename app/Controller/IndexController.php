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
namespace App\Controller;

use App\Service\Test\TestService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * Class IndexController.
 * @Controller(prefix="test")
 */
class IndexController extends AbstractController
{
    /**
     * @Inject
     * @var TestService
     */
    private $testService;

    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

    public function test()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

    /**
     * @RequestMapping(path="getId", methods="get,post")
     */
    public function getId(): array
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

    /**
     * @RequestMapping(path="getUserList", methods="get")
     */
    public function getUserList(): array
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
        $userList = $this->testService->getUserList($user);
        return [
            'method' => $method,
            'message' => "Hello {$user}.",
            'userList' => $userList,
        ];
    }
}
