<?php
$TotalCost = $totalCharge = $MealCost = $TotalCost1 = $totalCredit = $totalPaid = $totalBazar = $balance = $totalCredit = $TotalCost =$totalBazar  = $maidBill = $internetBill = $electricBill = $serviceCharge = $othersCharges = 0;

$thisMonth = date("m");
$thisYear  = date("Y");
$query      	= "SELECT * FROM user WHERE m_id =$messID AND id =  $userID";
$memberQuery 	= $db->selectData($query);


//Query ALL Bazar and Meal

	$bazarQuery		= "SELECT SUM(price) AS totalBazar FROM dailybazar WHERE month(Day) = '$thisMonth' AND year(Day)= '$thisYear' AND m_id=$messID";

	$bazarData = $db->selectData($bazarQuery);
    if ($bazarData) {
        $bazarData   = mysqli_fetch_array($bazarData);
        $totalBazar     = $bazarData['totalBazar'];
    }

    $mealQuery		= "SELECT SUM(breakfast) AS breakfast, SUM(lunch) AS lunch, SUM(dinner) AS dinner FROM dailymeal WHERE month(day) = '$thisMonth' AND year(day)= '$thisYear' AND m_id=$messID";

    $mealData = $db->selectData($mealQuery);
    if ($mealData) {
        $mealData   = mysqli_fetch_array($mealData);
        $totalMeal     = $mealData['breakfast'] + $mealData['lunch'] + $mealData['dinner'];
    }
	
	if($totalBazar>0 && $totalMeal>0 ){
		$mealrate 		= $totalBazar / $totalMeal;
	}else{
		$mealrate 		= $totalBazar = $totalMeal = 0;
	}

//Query ALL Bazar and Meal end

 while($row = $memberQuery->fetch_assoc()) {
 	$id 		= $row['id']; 

 	$query1 	= "SELECT SUM(price) AS totalBazar FROM dailybazar WHERE u_id = $id AND month(day) = '$thisMonth' AND year(day)= '$thisYear' AND m_id=$messID";

 	$result1 = $db->selectData($query1);
    if ($result1) {
        $totalBazar = mysqli_fetch_array($result1);
    }

	$query2 	= "SELECT SUM(breakfast) AS breakfast, SUM(lunch) AS lunch, SUM(dinner) AS dinner FROM dailymeal WHERE u_id = $id AND month(day) = '$thisMonth' AND year(day)= '$thisYear' AND m_id=$messID";

	$result2 = $db->selectData($query2);
    if ($result2) {
        $totalMeal = mysqli_fetch_array($result2);
        $totalMeal = $totalMeal['breakfast'] + $totalMeal['lunch'] + $totalMeal['dinner'];
    }

    $MealCost   = $mealrate*$totalMeal;


	$query3 	= "SELECT SUM(paid_amount) AS totalPaid FROM account WHERE u_id = $id AND month(day) = '$thisMonth' AND year(day)= '$thisYear' AND m_id=$messID";

	$result3 = $db->selectData($query3);
    if ($result3) {
        $totalPaid = mysqli_fetch_array($result3);
    }	  
    $mySql = "SELECT * FROM charges WHERE month ='$ledgerMonth' AND years = '$ledgerYear' AND m_id = $messID";
    $ledgerQuery = $db->selectData($mySql);

    if ($ledgerQuery) {
        $charges = mysqli_fetch_array($ledgerQuery);
    }
                
?>
                
<?php
if (isset($charges)) {
    $charges['maid_bill'] = $maidBill;
    $charges['internet_bill'] = $internetBill;
    $charges['electric_bill'] = $electricBill;
    $charges['service_charge'] = $serviceCharge;
    $charges['others'] = $othersCharges;
    $totalCharge = $internetBill + $electricBill + $serviceCharge + $othersCharges;
    }
    $TotalCost = $totalCharge + $MealCost;
    $TotalCost1 = number_format($TotalCost,2);
    $totalCredit = $totalPaid['totalPaid'] + $totalBazar['totalBazar'];
    $balance = $totalCredit - $TotalCost;
    $totalBazar = $totalBazar['totalBazar'];
    $totalPaid = $totalPaid['totalPaid'];
?>
<table class="mealcredit" width="48%" style="float: left;">
    <tr><td width="40%"><td width="2%"></td> <td width="6%"></td></tr>
    <tr><td>Total Bazar <td>: </td> <td><?php echo sprintf("%.2f",$totalBazar);?> </td></tr>
    <tr><td>Payoff <td>: </td> <td><?php echo sprintf("%.2f",$totalPaid);?></tr></td> 
    <tr><td>(+) Total Credit <td>: </td> <td><?php echo sprintf("%.2f",$totalCredit);?></tr></td>
    <tr><td>(-) Total Cost<td>: </td> <td><?php echo sprintf("%.2f", $TotalCost1);?></tr></td>
    <tr><td>Balance<td>: </td> <td><?php echo sprintf("%.2f", $balance);?></tr></td>
</table>
<table class="mealcost" width="50%" style="float: right;">
    <tr><td width="40%"><td width="2%"></td> <td width="8%"></td></tr>
    <tr><td>Total Meal <td>: </td> <td><?php echo sprintf("%.2f", $totalMeal);?></td></tr>
    <tr><td>Meal Rate <td>: </td> <td><?php echo sprintf("%.2f",$mealrate,2);?></tr></td>
    <tr><td>(x) Meal Cost<td>: </td> <td><?php echo $MealCost;?></tr></td>
    <tr><td>Maid Bill <td>: </td> <td><?php echo sprintf("%.2f", $maidBill);?>            
    <tr><td>Electric Bill <td>: </td> <td><?php echo sprintf("%.2f", $electricBill);?></td></tr>
    <tr><td>Internet Bill <td>: </td> <td><?php echo sprintf("%.2f", $internetBill);?></td></tr>
    <tr><td>Service Charge <td>: </td> <td><?php echo sprintf("%.2f", $serviceCharge);?></td></tr>
    <tr><td>Others Charges<td>: </td> <td><?php echo sprintf("%.2f", $othersCharges);?></td></tr>
    <tr><td>(+) Total Cost<td>: </td> <td><?php echo $TotalCost1;?></td></tr>
</table>
<?php
}

?>