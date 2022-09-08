<div class="widget">
    <h4><a href="<?=base_url('content/'.$path)?>">Новости</a></h4>
    <div>
        <ul>
            <? foreach ($content as $item): ?>
                <li>
                    <a href="<?= base_url('content/'.$path) ?>/<?=$item->alias?>"><?= $item->title ?></a>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
</div>  