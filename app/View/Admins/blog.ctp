<div class="col-md-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Blog Details</h3>
      <a class="btn btn-primary btn-sm btn-flat pull-right" href="/admins/add_blogpost">Add New Post</a>
    </div><!-- /.box-header -->
    <div class="box-body">
    <?php if(!empty($posts)) { ?>
      <table class="table table-bordered blog-table">
        <tr>
          <th>S.No</th>
          <th>Blog Title</th>
          <th>Image</th>
          <th>Link</th>
          <th>Action</th>
        </tr>
        <?php $i=1; foreach($posts as $post){ ?>
        <tr class = "tr<?= $post['Blog']['id']; ?>">
          <td>#<?= $i; ?></td>
          <td class="blog-heading"><?= $post['Blog']['title']; ?></td>
          <td class="blog_img">
          <?php if($post['Blog']['image']){ ?>
          	<img src="<?= HTTP_ROOT ?>images/blog/<?= $post['Blog']['image'] ?>"/>
          <?php } else{ ?>
          	<img src= "<?= ADMIN_LTE ?>imgres.jpg" />
          	<?php }?>
          </td>
          <td><a href="Javascript:;"></a><?= $post['Blog']['link']; ?></td>
          <td>
          	<a href="/admins/edit_blogpost/<?= base64_encode(convert_uuencode($post['Blog']['id']));?>" class="fa fa-fw fa-edit"></a> 
          	<a href="Javascript:void(0);" rel="<?= base64_encode(convert_uuencode($post['Blog']['id']));?>" class="fa fa-fw fa-trash-o delete_blogpost"></a> 
          </td>
        </tr>
        <?php $i++; } ?>
      </table>
      <?php } else{?>
      <span>No records</span>
      <?php }?>
    </div><!-- /.box-body -->
    <?php if($this->Paginator->numbers()) { ?>
	    <div class="box-footer clearfix">
	      <ul class="pagination pagination-sm no-margin pull-right">
	        <!-- <li><a href="#">&laquo;</a></li> -->
	        <?php 
	        echo @$this->Paginator->prev('« ',array('tag'=>'li','title'=>'Previous Page'),null,array('class' => 'disabled'));
	        echo @$this->Paginator->numbers(array('tag'=>'li','separator'=>''));
	        echo @$this->Paginator->next(' »',array('tag'=>'li','title'=>'Next Page'),null,array('class' => 'disabled'));
	        ?>
	        <!-- <li><a href="#">&raquo;</a></li> -->
	      </ul>
	    </div>
    <?php }?>
  </div><!-- /.box -->

</div><!-- /.col -->
