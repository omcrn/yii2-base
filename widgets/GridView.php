<?php
/**
 * User: Zura
 * Date: 4/4/2016
 * Time: 11:36 AM
 */

namespace centigen\base\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\jui\JuiAsset;


/**
 * Class GridView
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\widgets
 */
class GridView extends \yii\grid\GridView
{
    public $sortable = false;
    public $sortHandler = '<i class="glyphicon glyphicon-option-vertical"></i>';
    public $url = null;
    public $params = [];
    public $orderColumnName = 'order';
    public $oldOrderParamName = 'old_order';
    public $newOrderParamName = 'new_order';

    public function init()
    {
        if ($this->sortable && $this->url === null) {
            throw new InvalidConfigException(self::className() . '::$url must be provided');
        }
        if ($this->sortable) {
            array_unshift($this->columns, [
                'class' => 'yii\grid\Column',
                'contentOptions' => [
                    'class' => 'sorting-handle'
                ],
                'content' => function () {
                    return $this->sortHandler;
                },
                'options' => [
                    'style' => 'width: 30px'
                ]
            ]);
        }
        parent::init();
        $options = $this->rowOptions;
        $this->rowOptions = function ($model) use ($options) {
            return ArrayHelper::merge($options, [
                'data-order' => $model->{$this->orderColumnName}
            ]);
        };
    }

    public function run()
    {
        $result = parent::run();
        if ($this->sortable) {
            $this->registerStyles();
            $this->registerJs();
        }
        return $result;
    }

    protected function registerStyles()
    {
        $style = "
        #{$this->id} .sorting-handle{
            cursor: move
        }
        #{$this->id} .sortable-placeholder{
            display: table-row;
            background-color: #DDE8E6;
            height: 50px
        }
        .ui-sortable-helper{
            display: table;
            width: 100%;
            background-color: #e5e5e5
        }";
        $this->getView()->registerCss($style);
    }

    protected function registerJs()
    {
        $js = 'var prevOrder = null,
                    oldIndex = null;
                var $body = $(\'#' . $this->id . ' table tbody\');
                $body.sortable({
                     items: \'tr\' ,
                     placeholder: \'<tr><td colspan="6">&nbsp;</td></tr>\',
                    //placeholder: \'sortable-placeholder\',
                    handle: \'.sorting-handle\',
                    }).bind(\'sortstart\', function(e, ui) {
                         var $item = ui.item;
                        prevOrder = $item.attr(\'data-order\');
                        oldIndex = $item.index(); 
                    }).bind(\'sortupdate\', function(e, ui) {
                        var $item = ui.item;
                        var newOrder = null,
                            newIndex = $item.index();

                        var $next, $prev;
                        
                      
                        if (oldIndex > newIndex){
                            $next = $item.next();
                            newOrder = $next.attr(\'data-order\');
                            console.log("old index ", oldIndex);
                            console.log("new index ", $item.index());
                            for (var i = $item.index()+1; i <= oldIndex; i++){
                                var $tr = $body.find(\'tr\').eq(i);
                                $tr.attr(\'data-order\', parseInt($tr.attr(\'data-order\'))+1);
                               
                                 $tr.find(\'td\').eq(1).text(i+1);
                            
                            }
                        }else{
                            $prev = $item.prev();
                            newOrder = $prev.attr(\'data-order\');
                            
                             console.log("old index ", oldIndex);
                            console.log("new index ", $item.index());
                            for (var i = $item.index()-1; i >= oldIndex; i--){
                                var $tr = $body.find(\'tr\').eq(i);
                                $tr.attr(\'data-order\', parseInt($tr.attr(\'data-order\'))-1);
                                
                                $tr.find(\'td\').eq(1).text(i+1);
//                                console.log($tr.find(\'td\').eq(1));
                           
                            }
                           
                        }

                        $item.attr(\'data-order\', newOrder);
                        $item.find(\'td\').eq(1).text($item.index()+1);
                        var params = ' . Json::encode($this->params) . ';
                        params.' . $this->oldOrderParamName . ' = prevOrder;
                        params.' . $this->newOrderParamName . ' = newOrder;
                        $.ajax(\'' . $this->url . '\', {
                            data: params,
                            method: "POST",
                            beforeSend: function(){
                               $body.sortable(\'disable\');
                            },
                            complete: function(){
                               $body.sortable(\'enable\');   
                            }
                        });
                });';
        $this->getView()->registerJsFile('/html5sortable/dist/html.sortable.js');
        $this->getView()->registerJs($js);
    }
}
