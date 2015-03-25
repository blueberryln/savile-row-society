<?php
$this->append('header');
echo $this->element('header');
$this->end();
?>
<?php echo $this->element('blog/sidebar'); ?>
<div class="twelve columns blog">
    <? if ($post) : ?>
        <div id="post-<?php echo $post['Post']['id']; ?>" class="post">
            <div class="datetime"><?php echo date('M j, Y', h($post['Post']['date'])); ?></div>
            <h1 class="title"><?php echo h($post['Post']['title']); ?></h1>
            <div class="author"><?php echo h($post['User']['first_name']); ?> <?php echo h($post['User']['last_name']); ?></div>
            <p>
                <?php echo $post['Post']['content']; ?>
            </p>
            <? if ($post['Category']) : ?>
                <div class="tags">
                    <?php foreach ($post['Category'] as $category) : ?>
                        <a href="<?php echo $this->request->webroot; ?>blog/category/<?php echo $category['slug']; ?>">#<?php echo $category['name']; ?></a>
                    <?php endforeach; ?>
                </div>
                <br/>
            <?php endif; ?>
            <div class="comments">
                <? if ($comments) : ?>
                    <div class="comment-count">Comments (<?php echo count($comments); ?>)</div>
                    <?php foreach ($comments as $comment) : ?>
                        <div id="comment-<?php echo $comment['Comment']['id']; ?>" class="comment">
                            <h3 class="comment-name"><?php echo h($comment['User']['first_name']); ?> <?php echo h($comment['User']['last_name']); ?></h3>
                            <div class="comment-txt"><?php echo $comment['Comment']['text']; ?></div>
                            <div class="comment-datetime">Posted on <?php echo date('F j Y', h($comment['Comment']['created'])); ?> at <?php echo date('H:i', h($comment['Comment']['created'])); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($user_id) : ?>
                    <div class="post-comment">
                        <h3>Post a comment</h3>
                        <form action="<?php echo $this->request->webroot; ?>blog/view/<?php echo h($post['Post']['slug']); ?>" method="POST">
                            <textarea id="comment-text" name="data[Comment][text]"></textarea>
                            <button type="submit">POST</button>
                        </form>
                    </div>
                <?php else : ?>
                    To leave a comment you need to <a href="<?php echo $this->request->webroot; ?>signin" class="btn-signup">sing in</a>.
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
