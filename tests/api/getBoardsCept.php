<?php 
$I = new ApiTester($scenario);
$I->wantTo('GET /api/boards/');
$I->sendGET('/boards/');
$I->seeResponseCodeIs(200);