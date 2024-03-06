<?php
set_time_limit(0);

$videos = new Videos();
$list   = $videos->getAll(array(
		'page_limit' => false,
));
if($list) {
		foreach($list as $video) {
				if(!isset($video->file_guid) || !isset($video->cover_guid)) {
						$file  = new OssnFile();
						$files = $file->searchFiles(array(
								'type'       => 'object',
								'subtype'    => 'video',
								'owner_guid' => $video->guid,
						));
						
						$file  = new OssnFile();
						$covers = $file->searchFiles(array(
								'type'       => 'object',
								'subtype'    => 'cover',
								'owner_guid' => $video->guid,
						));		
						if($covers){
								$video->data->cover_guid = $covers[0]->guid;
						}	
						if($files) {
								$video->data->file_guid = $files[0]->guid;
						}
						$video->save();
				}
		}
}
//Events
$events = new Events();
$list   = $events->searchObject(array(
		'subtype'    => 'event',
		'page_limit' => false,
));
if($list) {
		foreach($list as $event) {
				if(!isset($event->file_guid)) {
						$file  = new OssnFile();
						$files = $file->searchFiles(array(
								'type'       => 'object',
								'subtype'    => 'event:photo',
								'owner_guid' => $event->guid,
						));
						if($files) {
								$event->data->file_guid = $files[0]->guid;
								$event->save();
						}
				}
		}
}
