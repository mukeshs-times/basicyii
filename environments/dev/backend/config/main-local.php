<?php
$config = [];
if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';    
    $config['modules']['tools']['class'] = 'backend\modules\tools\Module';
    $config['modules']['syncsolr']['class'] = 'backend\modules\syncsolr\Module';
}
return $config;