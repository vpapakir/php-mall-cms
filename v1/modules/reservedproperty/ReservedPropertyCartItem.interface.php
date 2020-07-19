<?php
//XCMSPro: CartItem entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageCartItemsReservedProperty()
{
	global $CORE, $changeCartItemProcessStatus;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['CartItemID'];
	$entityAlias = $input['CartItem'];
	//creat objects			
	$CartItem = new CartItemClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$CartItem->deleteCartItem($input);
	}
	elseif($input['actionMode']=='add')
	{
		if($changeCartItemProcessStatus!='Y')
		{
			$CartItem->addCartItem($input);
			$changeCartItemProcessStatus = 'Y';
		}
	}
	elseif($input['actionMode']=='save')
	{
		if($changeCartItemProcessStatus!='Y')
		{		
			$CartItem->setCartItem($input);
			$changeCartItemProcessStatus = 'Y';
		}
	}

	$CartItemsRS = $CartItem->getCartItemsReservedProperty($input);
	$result['DB']['CartItems'] = $CartItemsRS;
	
	return $result;
}

/**
* Gets CartItems. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getCartItemsReservedProperty($in)
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$CartItem = new CartItemClass();
	//get content
	$CartItemsRS = $CartItem->getCartItemsReservedProperty($input);
	$result['DB']['CartItems'] = $CartItemsRS;

	return $result;
}
?>