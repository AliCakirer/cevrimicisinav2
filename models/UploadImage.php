<?php

namespace kouosl\cevrimicisinav2\models;

use kouosl\cevrimicisinav2\Module;
use Yii;

/**
 * This is the model class for table "cevrimicisinav2s".
 *
 * @property string $imageFile
 *
 *
 */
class UploadImage extends \yii\base\Model
{


    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $imageName;
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png,jpg'],
        ];
    }

    public function upload()
    {

        if ($this->validate()) {

            $this->imageName = Yii::$app->security->generateRandomString(16) . '.' . $this->imageFile->extension;

            $imagePath = sprintf("%s/cevrimicisinav2s/%s",Yii::getAlias ( '@data' ),$this->imageName);

            if (!$this->imageFile->saveAs($imagePath)) {
                yii::$app->session->setFlash('flashMessage', ['type' => 'error', 'message' => Module::t('cevrimicisinav2', 'File not uploaded.' )]);
            }

            return $this->imageName;

        } else {

            yii::$app->session->setFlash('flashMessage', ['type' => 'error', 'message' => Module::t('cevrimicisinav2', 'Invalid File Type.' )]);

            return null;

        }
    }

}
