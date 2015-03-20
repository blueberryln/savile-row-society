<div class="col-md-12">
  <!-- general form elements -->
  <div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title">Add Blog post</h3>
      <a class="btn btn-primary btn-sm btn-flat pull-right" href="/admins/blog">Go Back</a>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="post" enctype ="multipart/form-data">
      <div class="box-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Title</label>
          <input type="text" name="data[Blog][title]" required class="form-control"  placeholder="Enter Blog Title">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">URL</label>
          <input type="text" name="data[Blog][link]" required class="form-control" pattern = "(([\w]+:)?//)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,63}(:[\d]+)?(/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?" title = "Please use a valid URL" placeholder="Please use a valid URL" />
        </div>
        <div class="form-group">
          <label>Status</label>
          <select required name="data[Blog][disabled]" class="form-control">
            <option value="0">Enable</option>
            <option value="1">Disable</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputFile">Image</label>
          <input required type="file" name="data[Blog][file]" id="exampleInputFile">
          
        </div>
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div><!-- /.box -->
</div>