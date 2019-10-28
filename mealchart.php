<div class="meal-Chart-Content">
	<table width="100%">
    	<tr>
    	 	<td>Date</td>
<?php 
$m=0;
$query       = "SELECT * FROM user WHERE m_id = $messID";
$result     = $db->selectData($query);

$query2 = "SELECT * FROM dailymeal WHERE month(day)='$thisMonth' AND year(day) ='$thisYear' AND m_id = $messID GROUP BY day ORDER BY day DESC";
$dateResult     = $db->selectData($query2);

if($result){
while($row = $result->fetch_assoc()) {

$name   = $row['firstname'];
$name   = $fm->textShorten($name,15);
$m++;
?>
    	 	 <td><?php echo $name; ?></td>
<?php } }?>
</tr>
<tr>
    <td></td>
<?php
    for ($i=0; $i <$m ; $i++) { 
        # code...
?>
<td>
    <div class="meal-times">
        <p>B</p>
        <p>L</p>
        <p>D</p>
    </div>
</td>
    

<?php }?>  
</tr>

    	 <?php 
                if ($dateResult) {
                    # code...
                 while($value = $dateResult->fetch_assoc()) {
                 	 $date  = $value['day'];
    	 ?>
    	 <tr>
    	 	 <td><?php echo $value['day'];?></td>
    	 	  <?php 

    	 	       $query       = "SELECT * FROM user WHERE m_id = $messID";
    	 	       $res = $db->selectData($query);
                    while($row = $res->fetch_assoc()) {
                    	$memberId   = $row['id'];
                     $mealQuery = "SELECT * FROM dailymeal WHERE day = '$date' AND u_id = '$memberId'";
                     $mealData = $db->selectData($mealQuery);
                     if ($mealData) {
                        $mealInfo = $mealData->fetch_array();
    	 	  ?>
    	 	 <td>
                
    	 	 	<div class="meal-times">
                    <p><?php echo $mealInfo['breakfast'];?></p>
                    <p><?php echo $mealInfo['lunch'];?></p>
                    <p><?php echo $mealInfo['dinner'];?></p>
                </div>
    	 	 </td>
    	 	 <?php }else{?>
                <div class="meal-times">
                    <p>B</p>
                    <p>L</p>
                    <p>D</p>
                </div>
                <div class="meal-times">
                    <p>0</p>
                    <p>0</p>
                    <p>0</p>
             </td>
            <?php } }?>
    	 	
    	 </tr>
    	 <?php } }?>
    </table>
</div>