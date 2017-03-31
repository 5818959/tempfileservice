TempFileService
===

Handle with temp files.


Install
---

    composer install


Usage examples
---

Create a temporary file:

```php
$tempFile = \TempFileService\Service::create();
```

Delete a temporary file:

```php
unlink($tempFile);
```

Create with options:

```php
$options = array(
    'dir' => '/path/to/directory',
    'name' => 'filename',
    'prefix' => 'prefix_filename',
    'postfix' => 'filename_postfix',
    'content' => 'sample content',
);

$tempFile = \TempFileService\Service::create($options);
```

If leave `dir` empty - will use system temp directory.  
If leave `name` empty - will generate a temp name.  
If leave `prefix` empty - no prefix will use.  
If leave `postfix` empty - no postfix will use.  
If leave `content` empty - will create an empty file.


More examples
---

Create a temporary file with content:

```php
$tempFile = \TempFileService\Service::create(array(
    'content' => 'some test text',
));
```

Write data to a temporary file:

```php
$tempFile->write('sample content');
```

Read data from a temporary file:

```php
$data = $tempFile->read();
```

Create a temporary file with specified name:

```php
$tempFile = \TempFileService\Service::create(array(
    'name' => 'sample_temp_file',
));
```

Create a temporary file with specified name prefix and postfix:

```php
$tempFile = \TempFileService\Service::create(array(
    'prefix' => 'sample_',
    'postfix' => '.txt',
));
```

Or see `examples/Service.php`.
