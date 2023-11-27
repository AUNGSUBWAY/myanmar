<?php
$poll = new \Softlab24\Ossn\Component\Polls;
$all = $poll->getAll(array(
			'entities_pairs' => array(
					array(
						'name' => 'container_type',
						'value' => 'user',
				 	),
			)								   
));
$count = $poll->getAll(array(
		'count' => true,	
		'entities_pairs' => array(
					array(
						'name' => 'container_type',
						'value' => 'user',
				 	),
		)				
));
?>
<div class="ossn-page-contents">
   <table class="table table-striped">
  <tr>
    <th scope="col"><?php echo ossn_print("polls:title");?></th>
    <th scope="col"><?php echo ossn_print("polls:time");?></th>
    <th scope="col"><?php echo ossn_print("polls:status");?></th>
  </tr>
	<?php
		if($all){
			foreach($all as $item){ ?>
            
   <tr>
    <td><a href="<?php echo $item->getURL();?>"><?php echo $item->title;?></a></td>
    <td><?php echo ossn_user_friendly_time($item->time_created);?></td>
    <td>
	<?php if($item->is_ended){?>
    	<label class="badge text-bg-warning"><?php echo ossn_print("polls:status:ended");?></label>
    <?php } else { ?>
     	<label class="badge text-bg-success"><?php echo ossn_print("polls:status:opened");?></label>
    <?php } ?>
    </td>
  </tr>           
            <?php
			}
		}	
	?>
</table>
<?php echo ossn_view_pagination($count); ?>

</div>