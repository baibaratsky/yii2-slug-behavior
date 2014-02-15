<?php

namespace baibaratsky\yii\behaviors\model;

use yii\base\Behavior;
use yii\base\Exception;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\helpers\Inflector;
use yii\validators\UniqueValidator;

/**
 * Class Slug
 * @package baibaratsky\yii\behaviors\model
 *
 * @property Model $owner
 */
class Slug extends Behavior
{
    public $sourceAttributeName = 'name';
    public $slugAttributeName = 'slug';

    public $replacement = '-';
    public $lowercase = true;

    public $unique = true;

    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'generateSlug'
        ];
    }

    public function generateSlug()
    {
        if (empty($this->owner->{$this->slugAttributeName}) && !empty($this->owner->{$this->sourceAttributeName})) {
            $slug = Inflector::slug(
                    $this->owner->{$this->sourceAttributeName},
                    $this->replacement,
                    $this->lowercase
            );
            $this->owner->{$this->slugAttributeName} = $slug;

            if ($this->unique) {
                $suffix = 1;
                while (!$this->uniqueCheck()) {
                    $this->owner->{$this->slugAttributeName} = $slug . $this->replacement . ++$suffix;
                }
            }
        }
    }

    public function uniqueCheck()
    {
        if ($this->owner instanceof ActiveRecordInterface) {
            /** @var Model $model */
            $model = clone $this->owner;
            $uniqueValidator = new UniqueValidator;
            $uniqueValidator->validateAttribute($model, $this->slugAttributeName);
            return !$model->hasErrors($this->slugAttributeName);
        }

        throw new Exception('Can\'t check if the slug is unique.');
    }
}
 