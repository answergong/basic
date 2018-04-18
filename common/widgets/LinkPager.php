<?php
/**
 * Created by PhpStorm.
 * User: gxz
 * Date: 2018/4/16
 * Time: 20:12
 */

namespace app\common\widgets;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * 跳转到页数
     *
     * @var String $name
     */
    public $go = true;
    /**
     * @var array 总的设置项
     */
    public $options = ['class' => 'g-page'];

    /**
     * @var string 前一页的样式class.
     */
    public $prevPageCssClass = 'g-page-prev';

    /**
     * @var string 后一页的样式class
     */
    public $nextPageCssClass = 'layui-laypage-next';

    /**
     * @var string 当前页的样式class
     */
    public $activePageCssClass = 'g-page-cur';

    /**
     * @var int 页数按钮显示数量
     */
    public $maxButtonCount = 5;

    /**
     * @var bool 是否显示第一页按钮
     */
    public $firstPageLabel = true;

    /**
     * @var bool 是否显示最后一页按钮
     */
    public $lastPageLabel = true;

    public $hideOnSinglePage = false;
    public $pageSizeParam = true;
    /**
     * @var string 下一页按钮内容
     */
    public $nextPageLabel = '>';

    /**
     * @var string 上一页按钮内容
     */
    public $prevPageLabel = '<';

    public $totalPageLabel = true;
    public $totalPageCssClass = 'g-page-txt';
    public $totalPageTag = 'span';
    /**
     * @var string the CSS class for the disabled page buttons.
     */
    public $disabledPageCssClass = '';
    public $disabledListItemSubTagOptions = ['class' => 'g-page-disabled'];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo $this->renderAll();
    }

    protected function renderAll()
    {
        $content = '';
        $content .= $this->renderPageButtons();
        return Html::tag('div', $content, ['class' => 'link-pager', 'style' => 'margin-top: 60px']);
    }

    protected function renderTotalPage($tag, $class)
    {
        $options = ['class' => empty($class) ? $this->pageCssClass : $class];
        $pageSize = $this->pagination->getLimit();
        $currentPage = $this->pagination->getPage() + 1;
        $start = $this->pagination->getOffset() + 1;
        if ($currentPage == $this->pagination->pageCount) {
            $end = $this->pagination->totalCount;
        } else {
            $end = $start + $pageSize - 1;
        }
        return Html::tag($tag, $start . '-' . $end . '/' . $this->pagination->totalCount . '条记录', $options);
    }

    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }
        $buttons = [];
        $currentPage = $this->pagination->getPage();

        //总数据条数显示
        if ($this->totalPageLabel !== false) {
            $buttons[] = $this->renderTotalPage($this->totalPageTag, $this->totalPageCssClass);
        }

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0,
                false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass,
                $currentPage <= 0, false);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null,
                $this->disableCurrentPageButton && $i == $currentPage, $i == $currentPage);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass,
                $currentPage >= $pageCount - 1, false);
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass,
                $currentPage >= $pageCount - 1, false);
        }
        if ($this->go) {
            $goHtml = <<<goHtml
            <a class="g-form-input g-form-input-sss">
                <input class="input" type="text" id="page-input" value="">
            </a>
            <a href="javascript:;" class="btn go-page">go</a>
goHtml;
            $buttons[] = $goHtml;
            $pageLink = $this->pagination->createUrl(false);
            $goJs = <<<goJs
            $(document).on('click', '.go-page', function () {
                    var _this = $(this),
                        _pageInput = $("#page-input"),
                        goPage = _pageInput.val(),
                        pageLink = "{$pageLink}";
                        pageLink = pageLink.replace("page=1", "page="+goPage);
                    if (goPage >= 1 && goPage <= {$pageCount}) {
                        window.location.href=pageLink;
                    } else {
                        _pageInput.focus();
                    }
                });
goJs;
            $this->view->registerJs($goJs);
        }

        return Html::tag('div', implode("\n", $buttons), $this->options);
    }

    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => empty($class) ? $this->pageCssClass : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $tag = ArrayHelper::remove($this->disabledListItemSubTagOptions, 'tag', 'a');

            return Html::tag($tag, $label, ArrayHelper::merge($options, $this->disabledListItemSubTagOptions));
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        $linkOptions = ArrayHelper::merge($linkOptions, $options);
        return Html::a($label, $this->pagination->createUrl($page), $linkOptions);
    }
}