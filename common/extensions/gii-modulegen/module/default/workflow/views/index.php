<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\adminUi\widget\Box;
use yii\adminUi\widget\Row;
use yii\adminUi\widget\Column;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;


Row::begin();
    Column::begin();
        Box::begin([
            'type' => Box::TYPE_INFO,
            'header' => $this->title,
            'headerIcon' => 'fa fa-gear',
            'headerButtonGroup' => true,
            'headerButton' => ((\Yii::$app->user->can(\Yii::$app->controller->module->id.'/'.\Yii::$app->controller->id.'/create')) ? Html::a(<?= $generator->generateString('Create {modelClass}', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?>, ['create'], ['class' => 'btn btn-success']) : '')
                            .((\Yii::$app->user->can(\Yii::$app->controller->module->id.'/<?= $generator->getControllerID(true)?>/index')) ? Html::a('<i class="fa fa-trash-o fa-lg"></i>&nbsp; Trash', ['<?= $generator->getControllerID(true)?>/index'], ['class' => 'btn btn-default']) : '')
        ]);
		<?php if(!empty($generator->searchModelClass)): ?>
		<?= ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); 
		<?php endif; ?>
		echo GridView::widget([
                    'filterPosition' => false,
                    'dataProvider' => $state->listingstat,
                    'filterModel' => false,
                    'layout' => "{items}",

                ]);
		<?php if ($generator->indexWidgetType === 'grid'): ?>
		echo GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => 'yii\grid\CheckboxColumn'],

		<?php
		$count = 0;
		if (($tableSchema = $generator->getTableSchema()) === false) {
			foreach ($generator->getColumnNames() as $name) {
				if (++$count < 6) {
					echo "            '" . $name . "',\n";
				} else {
					echo "            // '" . $name . "',\n";
				}
			}
		} else {
			foreach ($tableSchema->columns as $column) {
				$format = $generator->generateColumnFormat($column);
				if (++$count < 6) {
					echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
				} else {
					echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
				}
			}
		}
		?>

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
<?php else: ?>
		echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]);
<?php endif; ?>

		Box::end();
    Column::end();
Row::end();
?>