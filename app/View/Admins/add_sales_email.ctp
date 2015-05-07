<div class="col-md-12">
  <!-- general form elements -->
  <div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title"><?php echo $page_title;?></h3>
      <a class="btn btn-primary btn-sm btn-flat pull-right" href="/admins/sales_team_email">Go Back</a>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="post" enctype ="multipart/form-data">
      <div class="box-body">
        <!-- <div class="form-group"> -->
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="text" name="data[SalesTeam][email]" required pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" class="form-control" id="exampleInputEmail1" title="Please enter a valid email." placeholder="Enter email" value = "<?= @$email['SalesTeam']['email'] ?>">
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="data[SalesTeam][disabled]" class="form-control">
            <option value="0"<?php if(@$email['SalesTeam']['disabled']==0){echo "selected";} ?>>Enable</option>
            <option value="1"<?php if(@$email['SalesTeam']['disabled']==1){echo "selected";} ?>>Disable</option>
          </select>
        </div>
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary" >Submit</button>
      </div>
    </form>
  </div><!-- /.box -->
</div>