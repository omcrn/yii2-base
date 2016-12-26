<?php
/**
 * User: Zura
 * Date: 12/24/2015
 * Time: 4:20 PM
 */

namespace centigen\base\model;
use yii\base\Model;
use yii\web\UploadedFile;


/**
 * Class ImageModel
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package frontend\models
 *
 * @property UploadedFile $imageFile
 */
class ImageModel extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function getDisplayErrors()
    {
        return implode('<br>', $this->getFirstErrors());
    }
}