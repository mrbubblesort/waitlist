<?php

namespace Eve\Components;

use Library\PaginationMeta;
use Library\Base\Component as BaseComponent;

/**
 * Pagination helper functions
 */
class Pagination extends BaseComponent {


    public function getRow($page, $name, $url, $options = array()) {
        return ""
            . '<div class="row margin-bottom-sm">'
                . '<div class="col-sm-12 com-md-12">'
                    . '<span class="pull-left pagination-results">'
                        . $this->getResults($page, $name, $options)
                    . '</span>'
                    . '<nav class="pull-right-left">'
                        . '<ul class="pagination pagination-sm">'
                            . $this->getNavigation($page, $url, $options)
                        . '</ul>'
                    . '</nav>'
                . "</div>"
            . "</div>";
    }

    /**
     * Prints "$name x to y of z results"
     *
     * @param Phalcon\Paginator\Adapter\Model || Phalcon\Paginator\Adapter\QueryBuilder $page
     * @param string $name
     */
    public function getResults($page, $name) {

        //sometimes the controller might need to override the actual total because of how the query is written
        $total 		= count($page->items);
        $real_total = (isset($page->meta->real_total)) ? $page->meta->real_total : $page->total_items;

        $start 		= (isset($page->meta->limit))
                    ? (1 + (($page->current - 1)  * $page->meta->limit))
                    : (1 + (($page->current - 1)  * $total));

        $end		= ($start + $total - 1);

        return "$name $start - $end ($real_total Results)";
    }


    /**
     * Prints start, previous, next, & end links
     *
     * @param Phalcon\Paginator\Adapter\Model || Phalcon\Paginator\Adapter\QueryBuilder $page
     * @param string $url
     */
    public function getNavigation($page, $url, $options = array()) {
        $link_attribs = isset($options['link_attribs']) ? $options['link_attribs'] : '';

        $start = "<i class='fa fa-fast-backward small'></i>";
        $end = "<i class='fa fa-fast-forward small'></i>";
        $pagination = '';

        // Check if there should be link or just text depending on the page
        if($page->current != 1) {
            $page_link = (stristr($url, '?')) ? '&page=1' : '?page=1';
            $pagination .= "<li><a $link_attribs data-value='1' href='$url$page_link'>" . $start . "</a></li>";
        }
        else {
            $pagination .= "<li class='disabled'><a $link_attribs data-value='1' href='#'>$start</a><li>";
        }

        // Get 5 pages
        $from = $page->current - 2;
        if($from < 1) {
            $from = 1;
        }
        $to = $from + 4;
        if($to > $page->last) {
            $to = $page->last;
            $from = (($page->last - 4 > 1)) ? $page->last - 4 : 1;
        }

        for($from; $from <= $to; $from++) {
            $page_link = (stristr($url, '?')) ? "&page=$from" : "?page=$from";
            $class = ($from == $page->current) ? 'active' : null;
            $pagination .= "<li class='$class'><a $link_attribs data-value='$from' href='$url$page_link'>$from</a></li>";
        }

        if($page->current != $page->last) {
            $page_link = (stristr($url, '?')) ? "&page=$page->last" : "?page=$page->last";
            $pagination .= "<li><a $link_attribs data-value='$page->last' href='$url$page_link'>" . $end . "</a></li>";
        }
        else {
            $pagination .= "<li class='disabled'><a $link_attribs data-value='$page->last' href='#'>$end</a></li>";
        }

        return $pagination;
    }

    /**
     * Returns sort by link for paginated table headers
     *
     * @param CareerCross\View\Helpers\PaginationMeta $meta
     * @param string $action
     * @param string $text
     * @param string $sort_by
     * @return string
     */
    public function sortByLink(PaginationMeta $meta, $action, $text, $sort_by) {

        //rebuild the query string if there's an existing one
        $query_params = $this->request->getQuery();
        unset($query_params['_url'], $query_params['submit_search']);
        $query_string = ($query_params)
            ? '?' . http_build_query(array_filter($query_params))
            : null;

        // Change icon depending on request
        $icon = '<i class="fa fa-sort"></i>';
        if($meta->orderColumn == $sort_by && $meta->order) {
            $icon = '<i class="fa fa-sort-alpha-desc"></i>';
        }
        else if($meta->orderColumn == $sort_by) {
            $icon = '<i class="fa fa-sort-alpha-asc"></i>';
        }

        $page_link = $action . '/' . $sort_by . '/' . (int)!$meta->order;
        $page_link .= ($query_string != '?') ? '/' . $query_string : null;

        return \Phalcon\Tag::linkTo(array(
            $page_link,
            $text . '&nbsp;' . $icon,
        ));
    }

}