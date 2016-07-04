<?php
//XCMSPro: PollQuestion entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function managePollQuestions()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	$entityID = $input['PollQuestionID'];
	
	/*if(empty($entityID) && !empty($input['PollQuestionAlias']))
	{
		$pollQuestionForIDRS = $DS->query("SELECT PollQuestionID FROM PollQuestion WHERE PollQuestionAlias = '".$input['PollQuestionAlias']."'");
		$entityID = $pollQuestionForIDRS[0]['PollQuestionID'];
		$input['PollQuestionID'] = $entityID;
		$CORE->setInputVar("PollQuestionID",$entityID);
	}
	$entityAlias = $input['PollQuestion'];*/
	
	$entityFieldID = $input['PollAnswerID'];
	/*if(empty($entityFieldID) && !empty($input['PollAnswerAlias']))
	{
		$pollAnswerForIDRS = $DS->query("SELECT PollAnswerID FROM PollAnswer WHERE PollAnswerAlias = '".$input['PollAnswerAlias']."'");
		$entityFieldID = $pollAnswerForIDRS[0]['PollAnswerID'];
		$input['PollAnswerID'] = $entityFieldID;
		$CORE->setInputVar("PollAnswerID",$entityFieldID);
	}	*/
	//creat objects			
	$PollQuestion = new PollQuestionClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$PollQuestion->deletePollQuestion($input);
		$PollQuestion->deletePollAnswer($input);
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$PollQuestion->setPollQuestion($input);
		$PollQuestion->setPollAnswer($input);		
	}
	elseif($input['actionMode']=='add1')
	{
		$PollQuestion->updateVotes($input);		
	}
	
	$PollStatisticsRS = $PollQuestion->getPollStatistics($input);
	$result['DB']['PollStatistics'] = $PollStatisticsRS;
	
	$PollQuestionsRS = $PollQuestion->getPollQuestions($input);
	$result['DB']['PollQuestions'] = $PollQuestionsRS;

	if(!empty($entityID))
	{
		$result['DB']['PollQuestion'] = $PollQuestion->getPollQuestion($input);
		if(!empty($entityFieldID))
		{
			$result['DB']['PollAnswer'] = $PollQuestion->getPollAnswer($input);
		}
	}
	
	$result['DB']['PollAnswers'] = $PollQuestion->getPollAnswers($input);
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

?>