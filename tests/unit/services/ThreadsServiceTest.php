<?php

namespace tests\services;

use app\models\Thread;
use app\models\Board;
use app\services\ThreadService;

class ThreadsServiceTest extends \Codeception\Test\Unit
{
    /** @var  \UnitTester */
    protected $tester;

    /** @var array */
    protected $inputData;

    /** @var Thread */
    protected $createdThread;

    protected function _before()
    {
        $this->inputData = [
            'PostData' => [
                'messageText' => 'test thread',
                'name'        => 'unit tester',
                'subject'     => 'testing'
            ],
            'Thread' => ['isChat' => '0']
        ];
    }

    protected function _after()
    {
        $this->createdThread->delete(true);
    }

    // tests
    public function testCreate()
    {
        $this->createdThread = ThreadService::create(Board::findOne(['name' => 'test']), $this->inputData);
        expect_that($this->createdThread);
        expect_that($this->createdThread->postData->messageText == 'test thread');
        expect_that($this->createdThread->postData->name == 'unit tester');
        expect_that($this->createdThread->postData->subject == 'testing');
        expect_that($this->createdThread->isChat == '0');
    }
}