<?php
$config = [];
if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['modules']['gii']['class'] = 'yii\gii\Module';
    $config['modules']['gii']['generators'] = [
                                                    'modelgen' => ['class' => 'mithun\modulegen\module\Generator']
                                            ];
    $config['modules']['tools']['class'] = 'backend\modules\tools\Module';
    $config['modules']['syncsolr']['class'] = 'backend\modules\syncsolr\Module';
}

return $config;