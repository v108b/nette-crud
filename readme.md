# nette-crud
**DEVELOPMENT IN PROGRESS**
Extension was developed to speed up prototyping of application. Do not use it for production environment.

## Install
Install via composer

```composer
  "require": {
      "v108b/nette-crud": "@dev"
  }
```


## Usage
Configure crud extension in config.neon

```
services:
	crud: V108B\NetteCrud\Extension
```

Use it in Presenter
```php
$this['updateForm'] = $this->context->getService('crud')->getForms()->buildUpdateForm($tableName, $rowId);
```
