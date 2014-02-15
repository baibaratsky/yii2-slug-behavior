Yii2 slug behavior
==================

This Yii2 model behavior automates the slug generation process. To attach the behavior put the following code in your model:
```php
    public function behaviors()
   	{
   		return [
   			'slug' => [
   				'class' => Slug::className(),

   				// These parameters are optional, default values presented here:
   				'sourceAttributeName' => 'name', // If you want to make a slug from another attribute, set it here
   				'slugAttributeName' => 'slug', // Name of the attribute containing a slug
                'replacement' => '-', // The replacement to use for spaces in the slug
                'lowercase' => true, // Whether to return the string in lowercase or not
                'unique' => true, // Check if the slug value is unique, add number if not
   			],
   		];
   	}
```