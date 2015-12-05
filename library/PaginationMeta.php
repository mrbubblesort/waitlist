<?php

namespace Library;

use Phalcon;

/**
 * Stupid little class to hold all the data needed to actually make the pagination
 */
class PaginationMeta {

    public static $sort = array('asc', 'desc');

    public $query = null;	//"column_name (ASC|DESC)".  sql fragment that can be passed to phalcon's find or findFirst.
    public $baseLink = null;	//"controller/action". base url fragment for the page.
                                //override if you need to perserve any custom params from the dispatcher
    public $pageLink = null;	//"column_name/(0|1)".  url fragment that can be appended to phalcon's Tag::linkTo($url)
    public $orderColumn = null;	//current column we're ordering on
    public $order = 0;		//0 or 1, for 'up' or 'down'
    public $page = 1;		//current page
    public $limit = 10;		//current limit

    /**
     * Pulls all the data that might be in the url and saves it here
     *
     * @param Phalcon\Mvc\Dispatcher $dispatcher
     * @param array $map
     * @param array $default{order_by, order, limit}
     */
    public function __construct(Phalcon\Dispatcher $dispatcher, array $map = array(), $default = array()) {

        $di = Phalcon\DI::getDefault();

        // Set page
        if($di->get('request')->hasQuery('page') && $di->get('request')->getQuery('page', array('int'))) {
            $this->page = $di->get('request')->getQuery('page', array('int'));
        }

        // Set limit
        if($di->get('request')->hasQuery('limit') && $di->get('request')->getQuery('limit', array('int'))) {
            $this->limit = $di->get('request')->getQuery('limit', array('int'));
        }
        else if(isset($default['limit'])) {
            $this->limit = $default['limit'];
        }

        // Map values
        foreach($map as $k => $v) {
            $p = $dispatcher->getParam($k);
            if($p !== null) {
                $p = (int)(bool)$p; //force it to be 0 or 1
                $this->query = "$v " . self::$sort[$p];
                $this->pageLink = "/$k/".(int)$p;
                $this->orderColumn = $k;
                $this->order = (int)$p;
                break;
            }
        }

        // Set default values if nothing set
        if($this->query === NULL && count((array)$default)) {
            if(count($map) && isset($default['order_by']) && isset($map[$default['order_by']])) {
                $this->query = $map[$default['order_by']] . ' ' . self::$sort[(int)(bool)$default['order']];
                $this->orderColumn = $default['order_by'];
                $this->order = (int)(bool)$default['order'];
            }
            else if(isset($default['order_by'])) {
                // Pass complex order
                if(is_array($default['order_by'])) {
                    $order = array();
                    foreach($default['order_by'] as $k => $v) {
                        $order_by[] = isset($default['order'][$k])
                                    ? $v . ' ' . self::$sort[(int)(bool)$default['order'][$k]]
                                    : $v . ' ' . self::$sort[$default['order']];
                    }
                    $this->orderColumn = $default['order_by'][0];
                    $this->order = (array)$default['order'][0];
                    $this->query = implode(', ', $order_by);
                }
                // Simple order
                else {
                    $this->query = $default['order_by'] . ' ' . self::$sort[(int)(bool)$default['order']];
                    $this->orderColumn = $default['order_by'];
                    $this->order = (int)(bool)$default['order'];
                }
            }
        }

        if($dispatcher instanceof Phalcon\Mvc\Dispatcher) {
            $this->baseLink = $dispatcher->getControllerName() . '/' . $dispatcher->getActionName();
        }
    }

}
