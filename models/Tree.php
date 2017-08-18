<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Json;

class Tree extends Model
{
    public $select;
    public $json;
    public $jsonFile;

    public function rules()
    {
        return [
            [['select'], 'boolean'],
            [['select'], 'default', 'value' => false],
            [['json'], 'string'],
            [['jsonFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'json'],
        ];
    }
    
    public function upload($file)
    {
        if ($this->validate()) {
            $path = Yii::getAlias('@app/uploads/' . $file->baseName);
            $c = 0;
            while (file_exists("$path.json")) {
                $path = Yii::getAlias('@app/uploads/' . $file->baseName)."_$c";
                $c++;
            }
            $path .= '.json';
            $file->saveAs($path);
            return $path;
        } else {
            print_r($this->errors); die();
            return false;
        }
    }

    public static function getTree($path)
    {
        return trim(file_get_contents($path));
    }
}
