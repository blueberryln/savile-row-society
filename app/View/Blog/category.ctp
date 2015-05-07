<?php
$this->append('header');
echo $this->element('header');
$this->end();
?>
<?php echo $this->element('blog/sidebar'); ?>
<div class="twelve columns blog">
    <? if ($category) : ?>
        <h2>Posts for "<?php echo $category['Category']['name']; ?>" category</h2>
        <?php foreach ($category['Post'] as $post): ?>
            <div id="post-<?php echo $post['id']; ?>" class="post">
                <div class="datetime"><?php echo date('M j, Y', h($post['date'])); ?></div>
                <h1 class="title"><?php echo h($post['title']); ?></h1>
                <div class="author"><?php echo h($post['User']['first_name']); ?> <?php echo h($post['User']['last_name']); ?></div>
                <p>
                    <?php echo h($post['except']); ?><br/>
                    <a href="<?php echo $this->request->webroot; ?>blog/view/<?php echo h($post['slug']); ?>">Read more...</a><br/>
                </p>
                <br/>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>