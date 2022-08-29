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
namespace App\Service\Test;

use App\Event\UserRegistered;
use App\Model\Test\TestModel;
use Hyperf\Config\Annotation\Value;
use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Coroutine;
use Hyperf\Utils\Coroutine\Concurrent;
use Hyperf\Utils\Exception\ParallelExecutionException;
use Hyperf\Utils\Parallel;
use Psr\EventDispatcher\EventDispatcherInterface;

class TestService
{
    /**
     * @Inject
     * @var SessionInterface
     */
    protected $session;

    /**
     * @Value("config.app_name")
     */
    private $configValue;

    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function getUserList1($user)
    {
        $microtime = microtime(true);
        $parallel = new Parallel(10);
        for ($i = 0; $i < 20; ++$i) {
            $parallel->add(function () {
                return Coroutine::id();
            });
        }
        $end = microtime(true);
        try {
            $results = $parallel->wait();
            return ['microtime' => $microtime, 'end' => $end, 'time' => $end - $microtime, 'results' => $results];
        } catch (ParallelExecutionException $e) {
            // $e->getResults() 获取协程中的返回值。
            // $e->getThrowables() 获取协程中出现的异常。
        }
    }

    public function getUserList2($user)
    {
        $concurrent = new Concurrent(10);
        $count = 0;
        for ($i = 0; $i < 15; ++$i) {
            $concurrent->create(function () use (&$count) {
                // Do something...
                ++$count;
            });
        }
        return $count;
    }

    public function getUserList($user)
    {
        // 我们假设存在 User 这个实体
        $user = [123123];
        // 完成账号注册的逻辑
        // 这里 dispatch(object $event) 会逐个运行监听该事件的监听器
        $this->eventDispatcher->dispatch(new UserRegistered($user));
        return $user;
    }

    /**
     * 测试获取配置值.
     */
    public function testSession(): array
    {
        $this->session->set('key1', 'v12341234123alue');
        $session_id = $this->session->getId();
        $value = $this->session->get('key1');
        return [
            'session_id' => $session_id,
            'value' => $value,
        ];
    }

    public function testSetOne()
    {
        return TestModel::query()->insert(['realname' => 'test', 'mobile' => '123123']);
    }
}
