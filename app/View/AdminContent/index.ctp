<?
    $createURL = $this->Html->url(array('action' => 'edit', 0, $objectType));
    $createTitle = $this->ObjectType->getTitle('create', $objectType);
    $actions = $this->PHTableGrid->getDefaultActions($objectType);
    $actions['table']['add']['href'] = $createURL;
    $actions['table']['add']['label'] = $createTitle;

    /*
    if ($objectType == 'Category') {
    	$actions['row'][] = array('label' => __('Subcategories'), 'href' => '#sub');
    }
    */
?>
<?=$this->element('admin_title', array('title' => $this->ObjectType->getTitle('index', $objectType)))?>
<div class="text-center">
    <a class="btn btn-primary" href="<?=$createURL?>">
        <i class="icon-white icon-plus"></i> <?=$createTitle?>
    </a>
</div>
<br/>
<?
    echo $this->PHTableGrid->render($objectType, array(
        'baseURL' => $this->ObjectType->getBaseURL($objectType),
        'actions' => $actions
    ));
?>