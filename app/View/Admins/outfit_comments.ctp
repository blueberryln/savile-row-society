<style>
  td{
    word-break: break-all;
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
                      <th>S.No</th>
                      <th>Outfits</th>
                      <th>User's Name</th>
                      <th>Comments</th>
                     <!--  <th>Time</th> -->
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    <?php $i=1; foreach($comments as $outfit_comment) { ?>
                    <tr class="tr<?= $outfit_comment['OutfitComment']['id']; ?>">
                      <td>#<?= $i; ?></td>
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
                      <!-- <td><?= $outfit_comment['OutfitComment']['time']; ?></td> -->
                      <td>
                      <?php if($outfit_comment['OutfitComment']['disabled'] == 0) {?>
                      	<span class="label label-success">Enabled</span>
                      <?php } else{ ?>
                      	<span class="label label-warning">Disabled</span>
                      	<?php }?>
                      </td>
                      <td>
                      	<a title="Edit" href="/admins/edit_comments/<?= base64_encode(convert_uuencode($outfit_comment['OutfitComment']['id']));?>" class="fa fa-fw fa-edit"></a> 
                      	<a title="Delete" href="Javascript:void(0);" rel="<?= base64_encode(convert_uuencode($outfit_comment['OutfitComment']['id']));?>" class="fa fa-fw fa-trash-o delete_comment"></a> 
                      </td>
                    </tr>
                    <?php $i++; }?>
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