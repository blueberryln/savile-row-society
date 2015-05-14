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
      <h3 class="box-title">Slide Blog Post</h3>
      <a class="btn btn-primary btn-sm btn-flat pull-right" href="/admins/add_slide_blogpost">Add New Post</a>
    </div><!-- /.box-header -->
    <div class="box-body">
    <?php if(!empty($slideBlogs)) { ?>
      <table class="table table-bordered blog-table">
        <tr>
          <th><?php echo $this->Paginator->sort('id'); ?></th>
          <th><?php echo $this->Paginator->sort('title','Blog Title'); ?></th>
          <th><?php echo $this->Paginator->sort('description'); ?></th>
          <th>Image</th>
          <th><?php echo $this->Paginator->sort('link'); ?></th>
          <th><?php echo $this->Paginator->sort('time','Date'); ?></th>
          <th><?php echo $this->Paginator->sort('disabled','Status'); ?></th>
          <th>Action</th>
        </tr>
        <?php foreach($slideBlogs as $slideBlog){ ?>
        <tr class = "tr<?php echo $slideBlog['SlideBlog']['id']; ?>">
          <td>#<?php echo $slideBlog['SlideBlog']['id']; ?></td>
          <td class="blog-heading"><?php echo $slideBlog['SlideBlog']['title']; ?></td>
          <td class="blog-heading"><?php echo $slideBlog['SlideBlog']['description']; ?></td>
          <td class="blog_img">
          <?php if($slideBlog['SlideBlog']['image']){ ?>
            <img src="<?php echo HTTP_ROOT ?>files/blog/<?php echo $slideBlog['SlideBlog']['image'] ?>"/>
          <?php } else{ ?>
            <img src= "<?php echo ADMIN_LTE ?>imgres.jpg" />
            <?php }?>
          </td>
          <td><a target= "_blank" href="<?php echo $slideBlog['SlideBlog']['link']; ?>"><?php echo substr($slideBlog['SlideBlog']['link'],0,30).'...'; ?></a></td>
          <td><?php echo date('m/d/Y',$slideBlog['SlideBlog']['time']); ?></td>
          <td class = "status<?php echo $slideBlog['SlideBlog']['id']; ?>">
                      <?php if($slideBlog['SlideBlog']['disabled'] == 0) {?>
                        <button title="Click to Disable" getModel="SlideBlog" rel ="<?php echo $slideBlog['SlideBlog']['id']; ?>" class="label label-success change_status">Enabled</button>
                      <?php } else{ ?>
                        <button title="Click to Enable" getModel="SlideBlog" rel ="<?php echo $slideBlog['SlideBlog']['id']; ?>" class="label label-warning change_status">Disabled</button>
                      <?php }?>
          </td>
          <td>
            <a title="Edit" href="/admins/edit_slide_blogpost/<?php echo base64_encode(convert_uuencode($slideBlog['SlideBlog']['id']));?>" class="fa fa-fw fa-edit"></a> 
            <a title="Delete" href="Javascript:void(0);" getModel="SlideBlog" rel="<?php echo base64_encode(convert_uuencode($slideBlog['SlideBlog']['id']));?>" class="fa fa-fw fa-trash-o delete_record"></a> 
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
