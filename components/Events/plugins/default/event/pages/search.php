<div class="ossn-page-contents"> 
	<div class="events list-items">
			<?php
			if($params['list']){
				foreach($params['list'] as $item){ ?>
            <div class="row event-list-item">
           			<div class="col-md-4">
                            <div class="image-event">
                				<img src="<?php echo $item->iconURL();?>" />
                			</div>
                    </div>
                    <div class="col-md-8">
                    	<div class="title"><span><?php echo $item->title;?></span></div>
                        <div class="options">
                        	<div class="metadata">
                            	<li><i class="fa fa-flag"></i><?php echo $item->country;?></li>
                                <li><i class="fa fa-map-marker"></i><?php echo $item->location;?></li>
                                <li><i class="fa fa-calendar-o"></i><?php echo date("F, d Y", strtotime($item->date));?></li>
                                <li><i class="fa fa-clock-o"></i><?php echo $item->start_time; ?> - <?php echo $item->end_time; ?></li>
                            </div>
                        	<a href="<?php echo $item->profileURL();?>" class="btn btn-info"><?php echo ossn_print("event:browse");?> <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
            </div>
            <?php
				}
			} if(empty($params['list'])){ 
				echo ossn_print("event:no:result");
			}
			?>
        
	</div>
    <?php echo ossn_view_pagination($params['count']); ?>
</div>