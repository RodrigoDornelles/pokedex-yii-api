<?php

// comment out the following two lines when deployed to production
defined('DATABASE_URL') or define('DATABASE_URL', getenv('DATABASE_URL'));
defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV'));

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
