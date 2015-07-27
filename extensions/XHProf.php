<?php
/**
 * @author Alexey Tishchenko <tischenkoalexey1@gmail.com>
 * @oDesk https://www.odesk.com/users/~01ad7ed1a6ade4e02e 
 * @website https://sjoorm.com
 * date: 2015-07-26
 */
namespace sjoorm\yii\extensions;
use yii\base\Component;
/**
 * Class XHProf
 * @package sjoorm\yii\extensions
 */
class XHProf extends Component {

    /** @var boolean */
    private $isInitialized = false;

    /** @var string */
    public $namespace = 'my_namespace';
    /** @var string */
    public $host = 'http://xhprof.local';
    /** @var string */
    public $includeLibrary = '/path/to/xhprof/xhprof_lib/utils/xhprof_lib.php';
    /** @var string */
    public $includeRuns = '/path/to/xhprof/xhprof_lib/utils/xhprof_runs.php';

    /**
     * Initializing XHProf
     */
    public function init() {
        if (extension_loaded('xhprof')) {
            parent::init();
            require_once($this->includeLibrary);
            require_once($this->includeRuns);
            xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
            $this->isInitialized = true;
        } else {
            \Yii::warning('PHP extension [xhprof] was not loaded.', 'XHProf');
        }
    }

    /**
     * Stops profiling, saves recorded data and provides URL to view the report
     * @param boolean $html if result should be an HTML link or string URL
     * @return boolean|string URL to report page or FALSE on error
     */
    public function stop($html = true) {
        if ($this->isInitialized) {
            $data = xhprof_disable();
            $runs = new \XHProfRuns_Default();
            $id = $runs->save_run($data, $this->namespace);
            $url = "{$this->host}/index.php?run=$id&source={$this->namespace}";
            return $html ? "<a href=\"$url\" target=\"_blank\">Profiler output</a>" : $url;
        } else {
            return $html ? '<a href="#">XHPROF WAS NOT CONFIGURED CORRECTLY</a>' : false;
        }
    }
}
