<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Отзывы гостей — 101HOTELS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/comments.css') ?>">
</head>
<body>
    <header class="hero">
        <div class="hero__overlay"></div>
        <div class="container hero__content">
            <a class="brand" href="<?= site_url('comments') ?>" aria-label="На главную">
                <span class="brand__mark">101</span><span>HOTELS</span>
            </a>
            <div class="hero__copy">
                <p class="hero__eyebrow">Путешествуйте с комфортом</p>
                <h1>Отзывы наших гостей</h1>
                <p>Ваше мнение очень важно бла бла бла</p>
            </div>
        </div>
    </header>

    <main class="page-shell">
        <div class="container">
            <section class="comments-panel" aria-labelledby="comments-title">
                <div class="panel-heading">
                    <div>
                        <p class="section-kicker">Оценка пользователей</p>
                        <h2 id="comments-title">Комментарии <span><?= esc($total) ?></span></h2>
                    </div>
                    <div class="sort-controls" aria-label="Сортировка комментариев">
                        <span class="sort-label">Сортировать:</span>
                        <a class="sort-link <?= $sort === 'id' ? 'is-active' : '' ?>" href="<?= site_url('comments?sort=id&direction=' . ($sort === 'id' && $direction === 'asc' ? 'desc' : 'asc')) ?>">
                            По ID <?= $sort === 'id' ? ($direction === 'asc' ? '↑' : '↓') : '' ?>
                        </a>
                        <a class="sort-link <?= $sort === 'date' ? 'is-active' : '' ?>" href="<?= site_url('comments?sort=date&direction=' . ($sort === 'date' && $direction === 'asc' ? 'desc' : 'asc')) ?>">
                            По дате <?= $sort === 'date' ? ($direction === 'asc' ? '↑' : '↓') : '' ?>
                        </a>
                    </div>
                </div>

                <div id="notice" class="alert d-none" role="status"></div>

                <div id="comments-list" class="comment-list">
                    <?php if (empty($comments)): ?>
                        <div class="empty-state">
                            <span class="empty-state__icon">✦</span>
                            <h3>Здесь пока нет отзывов</h3>
                            <p>Оставьте первый комментарий – он появится здесь сразу.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($comments as $comment): ?>
                            <article class="comment-card" data-comment-id="<?= esc($comment['id']) ?>">
                                <div class="comment-card__avatar" aria-hidden="true"><?= esc(strtoupper(substr($comment['name'], 0, 1))) ?></div>
                                <div class="comment-card__body">
                                    <div class="comment-card__meta">
                                        <div>
                                            <strong><?= esc($comment['name']) ?></strong>
                                            <span>Гость</span>
                                        </div>
                                        <div class="comment-card__actions">
                                            <time datetime="<?= esc($comment['date']) ?>"><?= esc($comment['date']) ?></time>
                                            <button class="delete-comment" type="button" data-id="<?= esc($comment['id']) ?>" aria-label="Удалить комментарий">Удалить</button>
                                        </div>
                                    </div>
                                    <p><?= nl2br(esc($comment['text'])) ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if ($totalPages > 1): ?>
                    <nav class="pagination-wrap" aria-label="Страницы комментариев">
                        <ul class="pagination">
                            <?php for ($number = 1; $number <= $totalPages; $number++): ?>
                                <li class="page-item <?= $number === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= site_url('comments?page=' . $number . '&sort=' . $sort . '&direction=' . $direction) ?>"><?= $number ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </section>

            <section class="form-card" aria-labelledby="form-title">
                <div>
                    <p class="section-kicker">Поделитесь впечатлением</p>
                    <h2 id="form-title">Оставить комментарий</h2>
                    <p class="form-card__intro">Мы опубликуем его сразу после отправки.</p>
                </div>
                <form id="comment-form" action="<?= site_url('comments') ?>" method="post" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">E-mail</label>
                            <input id="name" name="name" type="email" class="form-control" placeholder="you@example.com" autocomplete="email" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date">Дата комментария</label>
                            <input id="date" name="date" type="date" class="form-control" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="text">Ваш отзыв</label>
                        <textarea id="text" name="text" class="form-control" rows="5" maxlength="3000" placeholder="Расскажите о ваших впечатлениях" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <button id="submit-comment" class="btn btn-accent" type="submit">Опубликовать комментарий <span aria-hidden="true">→</span></button>
                </form>
            </section>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-copyright">
            <div class="container">
                <span class="footer-logo">
                    <img src="assets/images/logo.svg" alt="Бесплатное бронирование гостиниц - 101Hotels.com" class="footer-logo-image">
                </span>
                <div class="footer-copyright-text">
                    ©&nbsp;2026 101hotels.com.<br>Все права защищены.
                </div>
            </div>
        </div>
    </footer>
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script>window.commentsUrl = <?= json_encode(site_url('comments'), JSON_UNESCAPED_UNICODE) ?>;</script>
    <script src="<?= base_url('assets/js/comments.js') ?>"></script>
</body>
</html>
