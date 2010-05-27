<?php

	require_once(TOOLKIT . '/class.datasource.php');
	
	Class datasourceforum_discussion_comment_count extends Datasource{
		
		public $dsParamROOTELEMENT = 'forum-discussion-comment-count';
		public $dsParamORDER = 'desc';
		public $dsParamGROUP = '18';
		public $dsParamLIMIT = '20';
		public $dsParamREDIRECTONEMPTY = 'no';
		public $dsParamSORT = 'system:id';
		public $dsParamSTARTPAGE = '1';
		public $dsParamASSOCIATEDENTRYCOUNTS = 'yes';
		
		public $dsParamFILTERS = array(
				'18' => '{$ds-forum-discussions-bookmarked}',
		);
		
		public $dsParamINCLUDEDELEMENTS = array(
				'parent-id'
		);

		public function __construct(&$parent, $env=NULL, $process_params=true){
			parent::__construct($parent, $env, $process_params);
			$this->_dependencies = array('$ds-forum-discussions-bookmarked');
		}
		
		public function about(){
			return array(
					 'name' => 'Forum: Discussion Comment Count',
					 'author' => array(
							'name' => 'Marco Sampellegrini',
							'website' => 'http://dev/forum',
							'email' => 'm@rcosa.mp'),
					 'version' => '1.0',
					 'release-date' => '2010-05-26T08:47:04+00:00');	
		}
		
		public function getSource(){
			return '3';
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

