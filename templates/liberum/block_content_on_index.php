<? foreach ($content as $item): ?>
    <div class="entry">
        <div class="meta">
            <i class="icon-calendar"></i> <?= $item->created ?> <span class="pull-right"><?= $item->title ?></span>
        </div>
        <?= $item->text ?>
        <div class="button"><a href="<?= base_url('content/news') ?>">Все новости</a></div>
    </div>
<? endforeach; ?>
