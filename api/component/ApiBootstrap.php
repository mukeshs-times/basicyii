<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace api\component;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\web\Controller;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use common\component\AppActiveRecord;
use common\component\TcEventAction;


class ApiBootstrap implements BootstrapInterface{
    public function bootstrap($app){
        Yii::$classMap['cdn_service\WhImage'] = Yii::getAlias('@cdnservice/WhImage.php');
        /*
        Event::on(\common\models\Event::className(), AppActiveRecord::EVENT_BEFORE_TRANCINSERT, function ($event) {
            
        });
        
        Event::on(\common\models\Event::className(), AppActiveRecord::EVENT_BEFORE_TRANCUPDATE, function ($event) {
            
        });
        //*/
        
         Event::on(ActiveRecord::classname(),  AppActiveRecord::EVENT_AFTER_TRANCINSERT,function ($event){
            TcEventAction::EventActionAfterTrancInsert($event);
             
        });
        
        Event::on(ActiveRecord::classname(),  AppActiveRecord::EVENT_AFTER_TRANCUPDATE,function ($event){
            TcEventAction::EventActionAfterTrancUpdate($event);
             
        });
         
        
    }
}
