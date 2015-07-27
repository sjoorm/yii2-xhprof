# yii2-xhprof
Simple Yii2 XHProf extension

Usage:

```php
return [
    'components' => [
        // ...
        'xhprof' => [
            'class' => 'sjoorm\yii\extensions\XHProf',
            'namespace' => 'my-project-1',
            'host' => 'http://xhprof.local',
            'includeLibrary' => '/usr/local/Cellar/php56-xhprof/254eb24/xhprof_lib/utils/xhprof_lib.php',
            'includeRuns' => '/usr/local/Cellar/php56-xhprof/254eb24/xhprof_lib/utils/xhprof_runs.php',
        ],
        // ...
    ],
    'bootstrap' => [
        'xhprof',
    ],
];
```