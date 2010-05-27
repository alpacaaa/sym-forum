<?php

	require_once(TOOLKIT . '/class.datasource.php');
	
	Class datasourceforum_discussions_bookmarked extends Datasource{
		
		public $dsParamROOTELEMENT = 'forum-discussions-bookmarked';
		public $dsParamORDER = 'desc';
		public $dsParamLIMIT = '20';
		public $dsParamREDIRECTONEMPTY = 'no';
		public $dsParamPARAMOUTPUT = 'system:id';
		public $dsParamSORT = 'system:id';
		public $dsParamSTARTPAGE = '1';
		public $dsParamASSOCIATEDENTRYCOUNTS = 'yes';
		
		public $dsParamFILTERS = array(
				'id' => '{$ds-member-bookmarks:\'no-match\'}',
		);
		
		public $dsParamINCLUDEDELEMENTS = array(
				'system:pagination',
				'topic',
				'created-by',
				'creation-date',
				'last-post',
				'last-active',
				'pinned',
				'closed'
		);

		public function __construct(&$parent, $env=NULL, $process_params=true){
			parent::__construct($parent, $env, $process_params);
			$this->_dependencies = array('$ds-member-bookmarks');
		}
		
		public function about(){
			return array(
					 'name' => 'Forum: Discussions (Bookmarked)',
					 'author' => array(
							'name' => 'Marco Sampellegrini',
							'website' => 'http://dev/forum',
							'email' => 'm@rcosa.mp'),
					 'version' => '1.0',
					 'release-date' => '2010-05-27T08:05:19+00:00');	
		}
		
		public function getSource(){
			return '2';
		}
		
		public function allowEditorToParse(){
			return true;
		}
		
		public function grab(&$param_pool=NULL){
			$result = new XMLElement($this->dsParamROOTELEMENT);
				
			try{
				include(TOOLKIT . '/data-sources/datasource.section.php');
			}
			catch(FrontendPageNotFoundException $e){
				// Work around. This ensures the 404 page is displayed and
				// is not picked up by the default catch() statement below
				FrontendPageNotFoundExceptionHandler::render($e);
			}			
			catch(Exception $e){
				$result->appendChild(new XMLElement('error', $e->getMessage()));
				return $result;
			}	

			if($this->_force_empty_result) $result = $this->emptyXMLSet();
			return $result;
		}
	}

