<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<style>
<?php echo ossn_plugin_view('polls/css');?>
</style>
<div class="row">
<div class="col-md-12">
        <div class="panel panel-default ossn-polls-form-questions">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-line-chart"></i> <?php echo $params['poll']->title;?></h3>
            </div>
            <div class="panel-body">
            	<?php
				$poll = $params['poll'];
				$options = $poll->getOptions();
				$votes = $poll->getVotes();				
                if($options){
					foreach($options as $key => $option){ 
						$color = substr($key, 0, 3);
						if($color == '000' || $color == 'fff'){
								$color = '';
						}
						if(strlen($color) > 0){
								$color = "background-color:#{$color};";
						}
				?>
				   <div class="row ossn-polls-item">
                  	<div class="col-md-12 col-sm-12 col-xs-12">
                        	  <label><?php echo $option;?></label>
	                		   <div class="progress">
                               		<?php if(isset($votes[$key])){ ?>
 									 <div class="progress-bar" role="progressbar" style="width: <?php echo $votes[$key];?>%;<?php echo $color;?>" aria-valuemax="100">
                      				   <?php echo $votes[$key];?>%
                       			    </div>
                                    <?php } else { ?>
  									 <div class="progress-bar" role="progressbar" style="color:#000;width: 0%;<?php echo $color;?>" aria-valuemax="100">
                      				   &nbsp;&nbsp;0%
                       			    </div>                                   
                                    <?php } ?>
				   			</div>
                 		  </div>
                    </div>      
                   <?php
					}
				}
				?>
            </div>
            <div class="panel-footer text-center">
                <?php if(isset($poll->is_ended)){ ?>
                		<div class="alert alert-warning margin-top-10"><?php echo ossn_print('polls:ended');?></div>     
                <?php } ?>
            </div>
        </div>
</div>
</div>