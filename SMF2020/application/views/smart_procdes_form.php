
<!--Calling header content-->
	
	<?php include('smart_header.php');?>

	


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Form Elements</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                   <form method="post" id="search_form" name="search_form"  action="<?php echo base_url();?>smart_controller/table_to_form">
				  <div class="input-group">
                    <input id="search_by_part_name" name="search_by_part_name" type="text" class="form-control" placeholder="Enter Part Name...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit" id="go" type="button" > Go!</button>

                    </span>
                  </div>
                </div>
				</form>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Data Form <small>different parameter values</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
					<?php //foreach ($header as $item):?>
                    <form method="post" id="data_form" name="data_form" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url();?>smart_controller/form_to_table">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="part_name">Part Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <h6 class="error_alert" style="color:#F00;"><?php echo $this->session->flashdata('err');?></h6>
                          <input type="text" id="part_name" name="part_name" value="<?php if (isset($res_arr)){echo $res_arr['part_name'];}//echo $part_name;//$header['part_name']; ?>" required="required" class="form-control col-md-7 col-xs-12">
                          <input type="hidden" id="part_id" name="part_id" value="<?php if (isset($res_arr)){echo $res_arr['part_id'];}else {echo 0;}//echo $part_name;//$header['part_name']; ?>" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="part_casting-metal">Casting Metal <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="part_casting_metal" name="part_casting_metal" value="<?php if (isset($res_arr)){echo $res_arr['part_casting_metal'];} ?>" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="part_surface_area" class="control-label col-md-3 col-sm-3 col-xs-12">Part Surface Area<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
						<input id="part_surface_area" name="part_surface_area" class="form-control col-md-7 col-xs-12" type="text" name="part_surface_area" value="<?php 
						if (isset($res_arr))
						{echo $res_arr['part_surface_area'];
						} ?>" required="required">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Part Weight <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="part_weight" name="part_weight" class="form-control col-md-7 col-xs-12" value="<?php if (isset($res_arr)){echo $res_arr['part_weight'];}?>" required="required" type="text">
                        </div>
                      </div>
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Part Volume <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="part_volume" name="part_volume" class="form-control col-md-7 col-xs-12" value="<?php if (isset($res_arr)){echo $res_arr['part_volume']; }?>" required="required" type="text">
                        </div>
                      </div>
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mold Material <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="mold_material" name="mold_material" class="form-control col-md-7 col-xs-12" value="<?php if (isset($res_arr)){echo $res_arr['mold_material'];} ?>" required="required" type="text">
                        </div>
                      </div>
					  
					  
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" id="cancel" type="button" action="<?php echo base_url();?>smart_controller/smart_dashboard">Cancel</button>
						  <button class="btn btn-primary" id="reset_form" type="button">Reset</button>
                          <button type="submit" class="btn btn-success" >Submit</button>
                        </div>
                      </div>

                    </form>
					<?php //endforeach;?>
                  </div>
                </div>
              </div>
            </div>
			
			
			
			<div>
select stl file: <input type="file" id="file" /> or drop stl file
</div>
<div id="view">
<!--<canvas width="1019" height="719" style="width: 800px; height: 800px;"></canvas>-->
</div>
			
            
          </div>
        </div>
        <!-- /page content -->
		
		<script>
		$("#go1").on('click', function() {
    //alert($("#search_by_part_name").val());
	
	$.ajax({
        url: '<?php echo base_url();?>smart_controller/table_to_form',
        type: 'POST',
        data: {
            search_by_part_name: $("#search_by_part_name").val()
        },
		dataType: "html",
		success: function(html) {
            alert(html);
			//document.location.href = "<?php //echo base_url()?>smart_controller/smart_procdes_form";
        }
        
    });
});

	
</script>

<script>

$("#reset_form").on('click', function() 
{
	
		//alert("hey");
		//$("#data_form")[0].reset();
		$('#part_name').val('');
		$('#part_casting_metal').val('');
		$('#part_surface_area').val('');
		$('#part_weight').val('');
		$('#part_volume').val('');
		$('#mold_material').val('');
				
	});
	
</script>
<script>

$("#cancel").on('click', function() 
{
	document.location.href = "<?php echo base_url()?>smart_controller/smart_home";
				
});
	
</script>
      <!--Calling footer content-->
	<?php include('smart_footer.php');?>
		
