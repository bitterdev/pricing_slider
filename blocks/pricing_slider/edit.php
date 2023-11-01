<?php

defined('C5_EXECUTE') or die('Access denied');

use Concrete\Core\Application\Service\UserInterface;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Block\View\BlockView;
use Concrete\Core\Form\Service\Form;
use Concrete\Core\Form\Service\Widget\PageSelector;

/** @var string $selector */
/** @var int $timeout */
/** @var int $speed */
/** @var array $items */
/** @var BlockView $view */

$app = Application::getFacadeApplication();
/** @var UserInterface $userInterface */
$userInterface = $app->make(UserInterface::class);
/** @var PageSelector $pageSelector */
$pageSelector = $app->make(PageSelector::class);
/** @var Form $form */
$form = $app->make(Form::class);

echo $userInterface->tabs([
    ['slides', t('Slides'), true],
    ['options', t('Options')],
]);

?>

<div class="tab-content">
    <div class="tab-pane active" id="slides" role="tabpanel">
        <div id="items-container"></div>

        <a href="javascript:void(0);" class="btn btn-primary" id="ccm-add-item">
            <?php echo t("Add Item"); ?>
        </a>
    </div>

    <div class="tab-pane" id="options" role="tabpanel">
        <div class="form-group">
            <?php echo $form->label($view->field('targetPage'), t('Target Page')); ?>
            <?php echo $pageSelector->selectPage('targetPage', $targetPage); ?>
        </div>
    </div>
</div>

<script id="item-template" type="text/template">
    <div class="slider-item">
        <div class="form-group">
            <label for="task-number-<%=id%>">
                <?php echo t("Task Number"); ?>
            </label>

            <input type="number" value="<%=taskNumber%>" id="task-number-<%=id%>" name="items[<%=id%>][taskNumber]" class="form-control" min="0" />
        </div>

        <div class="form-group">
            <label for="price-<%=id%>">
                <?php echo t("Price"); ?>
            </label>

            <input type="number" value="<%=price%>" id="price-<%=id%>" name="items[<%=id%>][price]" class="form-control" min="0" step=".01" />
        </div>

        <a href="javascript:void(0);" class="btn btn-danger">
            <?php echo t("Remove Item"); ?>
        </a>
    </div>
</script>

<style type="text/css">
    .slider-item {
        border: 1px solid #dadada;
        background: #f9f9f9;
        padding: 15px;
        margin-bottom: 15px;
    }
</style>

<script type="text/javascript">
    (function ($) {
        var nextInsertId = 0;
        var items = <?php echo json_encode($items);?>;

        var addItem = function (data) {
            var defaults = {
                id: nextInsertId
            };

            var combinedData = { ...defaults, ...data };

            var $item = $(_.template($("#item-template").html())(combinedData));

            nextInsertId++;

            $item.find(".btn-danger").click(function () {
                $(this).parent().remove();
            });

            $("#items-container").append($item);
        };

        for (var item of items) {
            addItem(item);
        }

        $("#ccm-add-item").click(function (e) {
            e.preventDefault();
            addItem({
                taskNumber: (nextInsertId + 1),
                price: 0.00
            });
            return true;
        });
    })(jQuery);
</script>