<style>
  td{
    word-break: break-all;
  }
  th > a{
    color:#333;
  }
</style>
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Outfits Comments</h3>
                  <a class="btn btn-primary btn-sm btn-flat pull-right" href="/admins/add_comments">Add New Comment</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                <?php if(!empty($comments)) {?>
                  <table class="table table-bordered blog-table">
                    <tr>
                      <th><?php echo $this->Paginator->sort('id'); ?></th>
                      <th><?php echo $this->Paginator->sort('Outfit.outfit_name', 'Outfits'); ?></th>
                      <th><?php echo $this->Paginator->sort('User.full_name', "User's Name"); ?></th>
                      <th><?php echo $this->Paginator->sort('comment'); ?></th>
                      <th><?php echo $this->Paginator->sort('time','Date'); ?></th>
                      <th><?php echo $this->Paginator->sort('disabled','Status'); ?></th>
                      <th><?php echo __('Action');?></th>
                    </tr>
                    <?php foreach($comments as $outfit_comment) { ?>
                    <tr class="tr<?= $outfit_comment['OutfitComment']['id']; ?>">
                      <td>#<?= $outfit_comment['OutfitComment']['id']; ?></td>
                      <td><?= $outfit_comment['Outfit']['outfit_name']; ?></td>
                      <td>
                      	<?php if(!$outfit_comment['User']['full_name']) { 
                      		echo 'Guest';
                      	}
                      	else{
                      		echo $outfit_comment['User']['full_name'];
                      	}

                      ?>
                      </td>
                      <td><?= $outfit_comment['OutfitComment']['comment']; ?></td>
                      <td><?= date('m/d/Y',$outfit_comment['OutfitComment']['time']); ?></td>
                      <td class = "os<?= $outfit_comment['OutfitComment']['id']; ?>">
                      <?php if($outfit_comment['OutfitComment']['disabled'] == 0) {?>
                      	<button title="Click to Disable" rel ="<?= $outfit_comment['OutfitComment']['id'];?>" class="label label-success comment_status">Enabled</button>
                      <?php } else{ ?>
                      	<button title="Click to Enable" rel ="<?= $outfit_comment['OutfitComment']['id'];?>" class="label label-warning comment_status">Disabled</button>
                      <?php }?>
                      </td>
                      <td>
                      	<a title="Edit" href="/admins/edit_comments/<?= base64_encode(convert_uuencode($outfit_comment['OutfitComment']['id']));?>" class="fa fa-fw fa-edit"></a> 
                      	<a title="Delete" href="Javascript:void(0);" rel="<?= base64_encode(convert_uuencode($outfit_comment['OutfitComment']['id']));?>" class="fa fa-fw fa-trash-o delete_comment"></a> 
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