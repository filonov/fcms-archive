<? foreach ($content as $item): ?>
    <div class="entry">
        <div class="meta">
            <h2><?= $item->title ?></h2>
        </div>
        <?= $item->text ?>
    </div>
<? endforeach; ?>
