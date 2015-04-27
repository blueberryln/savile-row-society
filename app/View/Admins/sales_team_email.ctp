<style>
  td{
    word-break: break-all;
  }
  th > a{
    color:#333;
  }
  .change_status{
    cursor: pointer;
  }
</style>
<div class="col-md-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Emails of Sales Team</h3>
      <a class="btn btn-primary btn-sm btn-flat pull-right" href="/admins/add_sales_email">Add New Email</a>
    </div><!-- /.box-header -->
    <div class="box-body">
    <?php if(!empty($emails)) { ?>
      <table class="table table-bordered blog-table">
        <tr>
          <th>Sr no.</th>
          <th><?php echo $this->Paginator->sort('id'); ?></th>
          <th><?php echo $this->Paginator->sort('email'); ?></th>
          <th><?php echo $this->Paginator->sort('disabled','Status'); ?></th>
          <th>Action</th>
        </tr>
        <?php $i=1; foreach($emails as $email){ ?>
        <tr class = "tr<?= $email['SalesTeam']['id']; ?>">
          <td>#<?= $i; ?></td>
          <td><?= $email['SalesTeam']['id']; ?></td>
          <td><?= $email['SalesTeam']['email']; ?></td>
          <td class = "status<?= $email['SalesTeam']['id']; ?>">
                      <?php if($email['SalesTeam']['disabled'] == 0) {?>
                        <button title="Click to Disable" getModel="SalesTeam" rel ="<?= $email['SalesTeam']['id']; ?>" class="label label-success change_status">Enabled</button>
                      <?php } else{ ?>
                        <button title="Click to Enable" getModel="SalesTeam" rel ="<?= $email['SalesTeam']['id']; ?>" class="label label-warning change_status">Disabled</button>
                      <?php }?>
          </td>
          <td>
          	<a title="Edit" href="/admins/add_sales_email/<?= base64_encode(convert_uuencode($email['SalesTeam']['id']));?>" class="fa fa-fw fa-edit"></a> 
          	<a title="Delete" href="Javascript:void(0);" getModel="SalesTeam" rel="<?= base64_encode(convert_uuencode($email['SalesTeam']['id']));?>" class="fa fa-fw fa-trash-o delete_record"></a> 
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
