<?php
/**
 * User: Zura
 * Date: 3/8/2016
 * Time: 12:06 PM
 */

namespace centigen\base\grid;


/**
 * Class CheckboxColumn
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\grid
 */
class CheckboxColumn extends \yii\grid\CheckboxColumn
{
    public $prefix = '';

    public $suffix = '';

    public $headerPrefix = '';

    public $headerSuffix = '';

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $content = parent::renderDataCellContent($model, $key, $index);
        return $this->prefix.$content.$this->suffix;
    }

    protected function renderHeaderCellContent()
    {
        $content = parent::renderHeaderCellContent();
        return $this->prefix.$content.$this->suffix;
    }
}