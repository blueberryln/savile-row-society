<?php
$this->append('header');
echo $this->element('header');
$this->end();
?>
<?php echo $this->element('blog/sidebar'); ?>
<div class="twelve columns blog">
    <? if ($posts) : ?>
        <?php foreach ($posts as $post): ?>
            <div id="post-<?php echo $post['Post']['id']; ?>" class="post">
                <div class="datetime"><?php echo date('M j, Y', h($post['Post']['date'])); ?></div>
                <h1 class="title"><?php echo h($post['Post']['title']); ?></h1>
                <div class="author"><?php echo h($post['User']['first_name']); ?> <?php echo h($post['User']['last_name']); ?></div>
                <p>
                    <?php echo h($post['Post']['except']); ?><br/>
                    <a href="<?php echo $this->request->webroot; ?>blog/view/<?php echo h($post['Post']['slug']); ?>">Read more...</a><br/>
                </p>
                <br/>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>