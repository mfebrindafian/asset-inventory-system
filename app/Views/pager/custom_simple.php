<?php $pager->setSurroundCount(3) ?>
<nav aria-label="Page navigation example">
    <ul class="pagination pagination-primary justify-content-end">
        <li class="page-item <?= $pager->hasPreviousPage() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $pager->getPreviousPage() ?>" aria-label="Previous">
                <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
            </a>
        </li>
        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>"><a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a></li>
        <?php endforeach ?>
        <li class="page-item <?= $pager->hasNextPage() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $pager->getNextPage() ?>">
                <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
            </a>
        </li>
    </ul>
</nav>