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
use Hyperf\Di\Annotation\Inject;
use Hyperf\WebSocketServer\Sender;

/**
 * Class ServerController.
 * @controller(prefix="test")
 */
class ServerController extends AbstractController
{
    /**
     * @Inject
     * @var Sender
     */
    protected $sender;

    public function close(int $fd)
    {
        go(function () use ($fd) {
            sleep(1);
            $this->sender->disconnect($fd);
        });

        return '';
    }

    public function send(int $fd)
    {
        $this->sender->push($fd, 'Hello World.');

        return '';
    }
}
