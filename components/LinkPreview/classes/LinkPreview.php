<?php
/**
 * Open Source Social Network
 *
 * @package   (openteknik.com).ossn
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright 2014-2017 OpenTeknik LLC
 * @license   OPENTEKNIK LLC, COMMERCIAL LICENSE  https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.openteknik.com/
 */
namespace Ossn\Component;
class LinkPreview extends \OssnObject {
		/**
		 * LinkePreview Initilize
		 *
		 * @param string $text A wall post text
		 * @param integer $guid A wallpost/comment guid
		 * @param string $type A linkepreview type
		 *
		 * @return void
		 */
		public function __construct($text = '', $guid = '', $type = 'wallpost') {
				$this->linkPreviewText = $text;
				$this->linkPreviewURL  = false;
				$this->linkPreviewGUID = false;
				$this->linkPreviewType = false;

				if(!empty($guid)) {
						$this->linkPreviewGUID = $guid;
				}
				if(!empty($type)) {
						$this->linkPreviewType = $type;
				}
				preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $this->linkPreviewText, $urls);
				if(count($urls) > 0 && !empty($urls)) {
						$urlR = array_reverse($urls[0]);
						if(isset($urlR[0]) && filter_var($urlR[0], FILTER_VALIDATE_URL)) {
								$this->linkPreviewURL = trim($urlR[0]);
						}
				}
		}
		public function isTwitter() {
				if(empty($this->linkPreviewURL)) {
						return false;
				}
				if(preg_match('#https?://twitter\.com/(?:\#!/)?(\w+)/status(es)?/(\d+)#is', $this->linkPreviewURL)) {
						return true;
				}
				return false;
		}
		public function getTwitterCode() {
				if($this->isTwitter()) {
						return file_get_contents("https://publish.twitter.com/oembed?url={$this->linkPreviewURL}");
				}
				return false;
		}
		/**
		 * Add linke preview to database
		 *
		 * @return boolean
		 */
		public function addLinkPreview() {
				if(empty($this->linkPreviewGUID) || empty($this->linkPreviewURL)) {
						return false;
				}
				if($this->excludeDomains()) {
						return false;
				}
				if(!$this->isTwitter()) {
						$vars = $this->getMeta();
				} else {
						$vars['description'] = '';
						$vars['title']       = '';
						$vars['link']        = $this->linkPreviewURL;
				}
				$this->description = $vars['description'];
				$this->title       = $vars['title'];
				$this->owner_guid  = $this->linkPreviewGUID;
				$this->type        = 'object';
				$this->subtype     = 'LinkPreview';

				$this->data                  = new \stdClass();
				$this->data->link_full       = $vars['link'];
				$this->data->linkPreviewType = $this->linkPreviewType;
				if($this->isTwitter()) {
						if($twitter_code = $this->getTwitterCode()) {
								$this->data->twitter_json = $twitter_code;
						}
				}
				$this->data->linkPreviewImage = false;
				if(!empty($vars['pictures'])) {
						$photo = $vars['pictures'][0];
						if(!empty($vars['pictures'][0])) {
								$this->data->linkPreviewImage = $photo;
						}
				}
				if(!empty($vars['image'])) {
						if(filter_var($vars['image'], FILTER_VALIDATE_URL)) {
								$this->data->linkPreviewImage = $vars['image'];
						}
				}
				return $this->addObject();
		}
		/**
		 * Get JSON data to pre-view for link before posting
		 *
		 * @return boolean
		 */
		public function getJson() {
				if($this->excludeDomains()) {
						return false;
				}
				$data = $this->getMeta();
				if(!empty($data['pictures'][0])) {
						$this->linkPreviewImage = $data['pictures'][0];
				}

				if(!empty($data['image'])) {
						if(filter_var($data['image'], FILTER_VALIDATE_URL)) {
								$this->linkPreviewImage = $data['image'];
						}
				}
				$linkobj                   = new \stdClass();
				$linkobj->linkPreviewImage = $this->linkPreviewImage;
				$linkobj->description      = $data['description'];
				$linkobj->title            = $data['title'];
				$linkobj->link_full        = $this->linkPreviewURL;

				$jsondata = array(
						'contents' => ossn_plugin_view('linkpreview/item_inner', array(
								'item' => $linkobj,
								'guid' => 0,
						)),
				);
				if($this->isTwitter()) {
						if($twitter_code = $this->getTwitterCode()) {
								$json = json_decode($twitter_code, true);
								if(isset($json['html'])) {
										$jsondata = array(
												'contents' => ossn_plugin_view('linkpreview/twitter_code', array(
														'html' => $json['html'],
												)),
										);
								}
						}
				}
				header('Content-Type: application/json;charset=utf-8');
				return json_encode($jsondata);
		}
		/**
		 * Don't linkpreview for the videos channels as they are handled by OssnEmbed
		 *
		 * @return boolean
		 */
		public function excludeDomains() {
				$patterns = array(
						'#(((https?://)?)|(^./))(((www.)?)|(^./))youtube\.com/watch[?]v=([^\[\]()<.,\s\n\t\r]+)#i',
						'#(((https?://)?)|(^./))(((www.)?)|(^./))youtu\.be/([^\[\]()<.,\s\n\t\r]+)#i',
						'/(https?:\/\/)(www\.)?(vimeo\.com\/groups)(.*)(\/videos\/)([0-9]*)/',
						'/(https?:\/\/)(www\.)?(vimeo.com\/)([0-9]*)/',
						'/(https?:\/\/)(player\.)?(vimeo.com\/video\/)([0-9]*)/',
						'/(https?:\/\/)(www\.)?(metacafe\.com\/watch\/)([0-9a-zA-Z_-]*)(\/[0-9a-zA-Z_-]*)(\/)/',
						'/(https?:\/\/www\.dailymotion\.com\/.*\/)([0-9a-z]*)/',
				);
				$regex = "/<a[\s]+[^>]*?href[\s]?=[\s\"\']+" . "(.*?)[\"\']+.*?>" . '([^<]+|.*?)?<\/a>/';
				if(preg_match_all($regex, linkify_lP($this->linkPreviewText), $matches, PREG_SET_ORDER)) {
						foreach ($matches as $match) {
								foreach ($patterns as $pattern) {
										if(preg_match($pattern, $match[2]) > 0) {
												return true;
										}
								}
						}
				}
				return false;
		}
		/**public function isCjk($string) {
				return $this->isChinese($string) || $this->isJapanese($string) || $this->isKorean($string);
		}

		public function isChinese($string) {
				return preg_match('/\p{Han}+/u', $string);
		}

		public function isJapanese($string) {
				return preg_match('/[\x{4E00}-\x{9FBF}\x{3040}-\x{309F}\x{30A0}-\x{30FF}]/u', $string);
		}

		public function isKorean($string) {
				return preg_match('/[\x{3130}-\x{318F}\x{AC00}-\x{D7AF}]/u', $string);
		} */
		public function smartQuotes($string) {
				$chr_map = array(
						// Windows codepage 1252
						"\xC2\x82"     => "'", // U+0082⇒U+201A single low-9 quotation mark
						"\xC2\x84"     => '"', // U+0084⇒U+201E double low-9 quotation mark
						"\xC2\x8B"     => "'", // U+008B⇒U+2039 single left-pointing angle quotation mark
						"\xC2\x91"     => "'", // U+0091⇒U+2018 left single quotation mark
						"\xC2\x92"     => "'", // U+0092⇒U+2019 right single quotation mark
						"\xC2\x93"     => '"', // U+0093⇒U+201C left double quotation mark
						"\xC2\x94"     => '"', // U+0094⇒U+201D right double quotation mark
						"\xC2\x9B"     => "'", // U+009B⇒U+203A single right-pointing angle quotation mark

						// Regular Unicode     // U+0022 quotation mark (")
						// U+0027 apostrophe     (')
						"\xC2\xAB"     => '"', // U+00AB left-pointing double angle quotation mark
						"\xC2\xBB"     => '"', // U+00BB right-pointing double angle quotation mark
						"\xE2\x80\x98" => "'", // U+2018 left single quotation mark
						"\xE2\x80\x99" => "'", // U+2019 right single quotation mark
						"\xE2\x80\x9A" => "'", // U+201A single low-9 quotation mark
						"\xE2\x80\x9B" => "'", // U+201B single high-reversed-9 quotation mark
						"\xE2\x80\x9C" => '"', // U+201C left double quotation mark
						"\xE2\x80\x9D" => '"', // U+201D right double quotation mark
						"\xE2\x80\x9E" => '"', // U+201E double low-9 quotation mark
						"\xE2\x80\x9F" => '"', // U+201F double high-reversed-9 quotation mark
						"\xE2\x80\xB9" => "'", // U+2039 single left-pointing angle quotation mark
						"\xE2\x80\xBA" => "'", // U+203A single right-pointing angle quotation mark
				);
				$chr = array_keys($chr_map); // but: for efficiency you should
				$rpl = array_values($chr_map); // pre-calculate these two arrays
				return str_replace($chr, $rpl, $string);
		}
		/**
		 * Get the link OpenGraph data,  images, title, description
		 *
		 * @return array
		 */
		public function getMeta() {
				if($this->excludeDomains()) {
						return false;
				}
				require_once LinkPreview . 'vendors/vendor/autoload.php';

				$linkPreview      = new \LinkPreview\LinkPreview($this->linkPreviewURL);
				$parsed           = $linkPreview->getParsed();
				$metadata         = array();
				$metadata['link'] = $parsed['general']->getUrl();

				$title       = $this->smartQuotes($parsed['general']->getTitle());
				$description = $this->smartQuotes($parsed['general']->getDescription());

				$metadata['title']       = lp_ossn_input_str($title);
				$metadata['description'] = lp_ossn_input_str($description);

				$metadata['image'] = $parsed['general']->getImage();
				$pictures          = $parsed['general']->getPictures();
				if(!empty($pictures)) {
						foreach ($pictures as $picture) {
								if(!empty($picture)) {
										if(filter_var($picture, FILTER_VALIDATE_URL)) {
												$metadata['pictures'][] = $picture;
										}
								}
						}
				}
				return $metadata;
		}
		/**
		 * Delete the wallpost linkpreview
		 *
		 * @return boolean
		 */
		public function deletePreview() {
				if(!empty($this->linkPreviewGUID)) {
						$preview = $this->searchObject(array(
								'type'           => 'object',
								'subtype'        => 'LinkPreview',
								'owner_guid'     => $this->linkPreviewGUID,
								'entities_pairs' => array(
										array(
												'name'  => 'linkPreviewType',
												'value' => $this->linkPreviewType,
										),
								),
						));
						if($preview) {
								if($preview[0]->deleteObject()) {
										return true;
								}
						}
				}
				return false;
		}
}