<?
	$databaseDefinition['t']['PollQuestion']='PollQuestionID,UserID,OwnerID,PermAll,PollQuestionContent,PollQuestionPosition,PollQuestionVotes,PollQuestionComments';
	$databaseDefinition['k']['PollQuestion']='PollQuestionID';	
	$databaseDefinition['langs']['PollQuestion']['PollQuestionContent']='infield';

	$databaseDefinition['t']['PollAnswer']='PollAnswerID,UserID,OwnerID,PermAll,PollQuestionID,PollAnswerContent,PollAnswerPosition,PollAnswerVotes';
	$databaseDefinition['k']['PollAnswer']='PollAnswerID';	
	$databaseDefinition['langs']['PollAnswer']['PollAnswerContent']='infield';
	
	$databaseDefinition['t']['PollStatisticUser']='PollStatisticUserID,UserID,OwnerID,SessionID,PollQuestionID,PollAnswerID';
	$databaseDefinition['k']['PollStatisticUser']='PollStatisticUserID';
?>