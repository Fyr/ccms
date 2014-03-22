<?
    $createURL = $this->Html->url(array('action' => 'edit', 0, $object_type));
    $createTitle = $this->ObjectType->getTitle('create', $object_type);
    $actions = $this->PHTableGrid->getDefaultActions('Article');
    $actions['table']['add']['href'] = $createURL;
    $actions['table']['add']['label'] = $createTitle;
?>
<?=$this->element('admin_title', array('title' => $this->ObjectType->getTitle('index', $object_type)))?>
<div class="text-center">
    <a class="btn btn-primary" href="<?=$createURL?>">
        <i class="icon-white icon-plus"></i> <?=$createTitle?>
    </a>
</div>
<br/>
<?
    echo $this->PHTableGrid->render('Article', array(
        'baseURL' => $this->ObjectType->getBaseURL($object_type),
        'actions' => $actions
    ));
?>