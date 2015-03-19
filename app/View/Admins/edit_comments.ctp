<div class="col-md-12">
  <!-- general form elements -->
  <div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title">Edit Outfit Comments</h3>
      <a class="btn btn-primary btn-sm btn-flat pull-right" href="/admins/outfit_comments">Go Back</a>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="post" enctype ="multipart/form-data">
      <div class="box-body">
        <div class="form-group">
          <label>Select Stylist</label>
          <select name="stylist" class="form-control select_stylist">
            <option value="">--Select--</option>
            <?php foreach($stylists as $stylist) {?>
            <option value ="<?= $stylist['User']['id']; ?>"><?= $stylist['User']['full_name']; ?></option>
            <?php }?>
          </select>
        </div>

        <div class="form-group select_outfit_div">
          <label>Select Outfit</label>
          <select required name="data[OutfitComment][outfit_id]" class="form-control select_outfit">
            <option value = "<?= $comments['OutfitComment']['outfit_id']; ?>"><?= $comments['Outfit']['outfit_name']; ?>
            </select>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Comment</label>
          <input type="text" name="data[OutfitComment][comment]" required class="form-control" placeholder="Enter comment" value = "<?=   $comments['OutfitComment']['comment']; ?>">
        </div>
        <div class="form-group">
          <label>Status</label>
          <select required name="data[OutfitComment][disabled]" class="form-control">
            <option value="0"<?php if($comments['OutfitComment']['disabled'] == 0 ) {echo "selected";} ?>>Enable</option>
            <option value="1"<?php if($comments['OutfitComment']['disabled'] == 1 ) {echo "selected";} ?>>Disable</option>
          </select>
        </div>
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div><!-- /.box -->
</div>