# nette-crud
**DEVELOPMENT IN PROGRESS**
Extension was developed to speed up prototyping of application. Do not use it for production environment.

## Install
Install via composer

```
  "require": {
      "v108b/nette-crud": "dev-master"
  }
```

## Setup as modal window
If you wish to display forms in modal windows, follow this process

### Insert after body (@layout)

```
	{ifset $presenter['modalWindow']}
		{control modalWindow}
	{/ifset}
```

### Create modalWindow component factory method (in BasePresenter)

```
	public function createComponentModalWindow()
	{
		return new \V108B\NetteCrud\ModalWindow();
	}
```

### Add crud service extenstion to conlig.neon
```
conlig.neon
	crud: V108B\NetteCrud\Extension
```

### Add to jquery main function (main.js)
```
	$('#modalWindow[data-show="true"]').modal('show');
```

## Usage
```
	<a href="{$presenter['modalWindow-crudView']->link('insert!', 'user')}">
```

## Troubleshooting
Do you have loaded bootstrap js?
```
	<script src=".../bootstrap/dist/js/bootstrap.min.js"></script>
```
