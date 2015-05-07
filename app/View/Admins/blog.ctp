<style>
  td{
    word-break: break-all;
  }
  th > a{
    color:#333;
  }
  .blog_status{
    cursor: pointer;
  }
</style>
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
          <th><?php echo $this->Paginator->sort('id'); ?></th>
          <th><?php echo $this->Paginator->sort('title','Blog Title'); ?></th>
          <th>Image</th>
          <th><?php echo $this->Paginator->sort('link'); ?></th>
          <th><?php echo $this->Paginator->sort('time','Date'); ?></th>
          <th><?php echo $this->Paginator->sort('disabled','Status'); ?></th>
          <th>Action</th>
        </tr>
        <?php foreach($posts as $post){ ?>
        <tr class = "tr<?= $post['Blog']['id']; ?>">
          <td>#<?= $post['Blog']['id']; ?></td>
          <td class="blog-heading"><?= $post['Blog']['title']; ?></td>
          <td class="blog_img">
          <?php if($post['Blog']['image']){ ?>
          	<img src="<?= HTTP_ROOT ?>files/blog/<?= $post['Blog']['image'] ?>"/>
          <?php } else{ ?>
          	<img src= "<?= ADMIN_LTE ?>imgres.jpg" />
          	<?php }?>
          </td>
          <td><a target= "_blank" href="<?= $post['Blog']['link']; ?>"><?= substr($post['Blog']['link'],0,30).'...'; ?></a></td>
          <td><?= date('m/d/Y',$post['Blog']['time']); ?></td>
          <td class = "bs<?= $post['Blog']['id']; ?>">
                      <?php if($post['Blog']['disabled'] == 0) {?>
                        <!-- <button title="Click to Disable" rel ="<?= $post['Blog']['id']; ?>" class="label label-success blog_status">Enabled</button> -->
                        <div class="onoffswitch">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                            <label class="onoffswitch-label" for="myonoffswitch">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                      <?php } else{ ?>
                        <!-- <button title="Click to Enable" rel ="<?= $post['Blog']['id']; ?>" class="label label-warning blog_status">Disabled</button> -->
                        <div class="onoffswitch">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                            <label class="onoffswitch-label" for="myonoffswitch">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                      <?php }?>
          </td>
          <td>
          	<a title="Edit" href="/admins/edit_blogpost/<?= base64_encode(convert_uuencode($post['Blog']['id']));?>" class="fa fa-fw fa-edit"></a> 
          	<a title="Delete" href="Javascript:void(0);" rel="<?= base64_encode(convert_uuencode($post['Blog']['id']));?>" class="fa fa-fw fa-trash-o delete_blogpost"></a> 
          </td>
        </tr>
        <?php } ?>
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
	        /*echo @$this->Paginator->prev('« ',array('tag'=>'li','title'=>'Previous Page'),null,array('class' => 'disabled'));*/
	        echo @$this->Paginator->numbers();
	       /* echo @$this->Paginator->next(' »',array('tag'=>'li','title'=>'Next Page'),null,array('class' => 'disabled'));*/
	        ?>
	        <!-- <li><a href="#">&raquo;</a></li> -->
	      </ul>
	    </div>
    <?php }?>
  </div><!-- /.box -->

</div><!-- /.col -->
