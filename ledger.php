    <div id='content' class="meal-Chart-Content">
        <h2>Ledger for <?php echo $monthName." ".$ledgerYear;?></h2>
        <?php


//Query ALL Bazar and Meal

        $bazarQuery     = "SELECT SUM(price) AS totalBazar FROM dailybazar WHERE month(Day) = '$ledgerMonth' AND year(Day)= '$ledgerYear' AND m_id=$messID";

        $bazarData = $db->selectData($bazarQuery);
        if ($bazarData) {
            $bazarData   = mysqli_fetch_array($bazarData);
            $totalBazar     = $bazarData['totalBazar'];
        }

        $bazarQuery     = "SELECT SUM(price) AS messBazar FROM dailybazar WHERE month(Day) = '$ledgerMonth' AND year(Day)= '$ledgerYear'AND u_id='0' AND m_id=$messID";

        $monthlyBazar = $db->selectData($bazarQuery);
        if ($monthlyBazar) {
            $monthlyBazar   = mysqli_fetch_array($monthlyBazar);
            $monthlyBazar     = $monthlyBazar['messBazar'];
        }

        $bazarQuery     = "SELECT SUM(price) AS dailyBazar FROM dailybazar WHERE month(Day) = '$ledgerMonth' AND year(Day)= '$ledgerYear'AND u_id !='0' AND m_id=$messID";

        $dailyBazar = $db->selectData($bazarQuery);
        if ($dailyBazar) {
            $dailyBazar   = mysqli_fetch_array($dailyBazar);
            $dailyBazar     = $dailyBazar['dailyBazar'];
        }

        $mealQuery      = "SELECT SUM(breakfast) AS breakfast, SUM(lunch) AS lunch, SUM(dinner) AS dinner FROM dailymeal WHERE month(day) = '$ledgerMonth' AND year(day)= '$ledgerYear' AND m_id=$messID";

        $mealData = $db->selectData($mealQuery);
        if ($mealData) {
            $mealData   = mysqli_fetch_array($mealData);
            $totalMeal     = $mealData['breakfast'] + $mealData['lunch'] + $mealData['dinner'];
        }

        if($totalBazar>0 && $totalMeal>0 ){
            $mealrate       = $totalBazar / $totalMeal;
        }else{
            $mealrate       = $totalBazar = $totalMeal = 0;
        }

        ?>
        <div class="meal-account">
            <span style="width:48%; float: left;">
                <p style="width:50%;">Monthly Bazar</p>
                <p style="width:5%;">:</p>
                <p style="width:45%;"><?php echo number_format($monthlyBazar,2);?> Taka</p>

                <p style="width:50%;">Daily Bazar</p>
                <p style="width:5%;">:</p>
                <p style="width:45%;"><?php echo number_format($dailyBazar,2);?> Taka</p>
                <hr style="width:100%; margin: 2px 5px;">
                <p style="width:50%;">(+) Total Bazar</p>
                <p style="width:5%;"> :</p>
                <p style="width:45%;"><?php echo number_format($totalBazar,2);?> Taka</p>
            </span>
            <span style="width:48%; float: right;">
                <p style="width:50%;">Total Bazar</p>
                <p style="width:5%;"> :</p>
                <p style="width:45%;"><?php echo number_format($totalBazar,2);?> Taka</p>

                <p style="width:50%;">Total Meal</p>
                <p style="width:5%;">:</p>
                <p style="width:45%;"><?php echo number_format($totalMeal,2);?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <hr style="width:88%; margin: 2px 28px;">
                <p style="width:50%;">(&divide;) Per Meal</p>
                <p style="width:5%;">:</p>
                <p style="width:45%;"> <?php echo number_format($mealrate,2);?> Taka</p>
            </span>
        </div>   

        <table width="100%">
        	
          <tr>
            <td width="10%">Name</td>
            <td>Total Meal</td>
            <td>Meal Cost</td>
            <td>Maid Bill</td>
            <td>Internet Bill</td>
            <td>Electric Bill</td>
            <td>Service Charge</td>
            <td>Others Charges</td>
            <td>Total Cost</td>
            <td>Payoff</td>
            <td>Total Bazar</td>
            <td>Total Credit</td>
            <td>Balance</td>
        </tr>

        <tr>
            <?php 
            $query          = "SELECT * FROM user WHERE m_id =$messID";
            $memberQuery    = $db->selectData($query);
            while($row = $memberQuery->fetch_assoc()) {
                $name   = $fm->textShorten($row['firstname'], 15);
                $id     = $row['id'];
                ?>

                <td> <?php echo $name;?> </td>
                <td>
                    <?php
                    $mealQuery = "SELECT SUM(breakfast) AS breakfast, SUM(lunch) AS lunch, SUM(dinner) AS dinner FROM dailymeal WHERE u_id = $id AND m_id=$messID AND month(day) = '$ledgerMonth' AND year(day)= '$ledgerYear'";
                    $mealResult     =  $db->selectData($mealQuery);

                    while($meals = $mealResult->fetch_assoc()) {
                        $totalmeals     = $meals['breakfast'] + $meals['lunch'] + $meals['dinner'];
                        echo  $totalmeals;             
                        ?>
                    </td>

                    <td>
                        <?php
                        $mealCost = $totalmeals*$mealrate;
                        $mealCost1 = number_format($totalmeals*$mealrate,2);
                        echo $mealCost1 ;
                        ?>
                    </td>

                    <?php    
                    $mySql = "SELECT * FROM charges WHERE month ='$ledgerMonth' AND years = '$ledgerYear' AND m_id = $messID";
                    $ledgerQuery = $db->selectData($mySql);
                    if ($ledgerQuery) {
                        while($charges = $ledgerQuery->fetch_assoc()) {

                            ?>

                            <td>                                           
                                <?php echo $charges['maid_bill'];?>
                            </td>
                            <td>
                                <?php echo $charges['internet_bill'];?>
                            </td>
                            <td>
                             <?php echo $charges['electric_bill'];?>
                         </td>
                         <td>
                             <?php echo $charges['service_charge'];?>
                         </td>
                         <td>
                             <?php echo $charges['others'];?>
                         </td>
                         <td>
                            <?php
                            $totalCharge = $charges['internet_bill'] + $charges['electric_bill'] + $charges['service_charge'] + $charges['others'];
                            $TotalCost = $totalCharge + $mealCost;
                            $TotalCost1 = number_format($TotalCost,2);
                            echo $TotalCost1;  
                            ?>
                        </td>
                    <?php } }else{?>
                        <td>                                           
                            <?php echo 0;?>
                        </td>
                        <td>
                            <?php echo 0;?>
                        </td>
                        <td>
                         <?php echo 0;?>
                     </td>
                     <td>
                         <?php echo 0;?>
                     </td>
                     <td>
                         <?php echo 0;?>
                     </td>
                     <td>
                         <?php echo 0;?>
                     </td>
                 <?php }?>

                 <td>
                    <?php
                    $paymentQuery      = "SELECT SUM(paid_amount) AS totalPaid FROM account WHERE u_id = $id AND month(day) = '$ledgerMonth' AND year(day)= '$ledgerYear' AND m_id=$messID";
                    $paymentResult     =  $db->selectData($paymentQuery);

                    while($payments = $paymentResult->fetch_array()) {
                        $totalpayment =  $payments['totalPaid'];
                        if (!empty($totalpayment)) {
                            echo $totalpayment;
                        }else{
                            echo 0;
                        }
                    }
                    ?>

                </td>
                <td>
                    <?php
                    $bazarQuery      = "SELECT SUM(price) AS TotalBazar FROM dailybazar WHERE u_id = $id AND m_id = $messID AND month(Day) = '$ledgerMonth' AND year(Day) = '$ledgerYear'";
                    $bazarResult     = $db->selectData($bazarQuery);

                    while($bazars = $bazarResult->fetch_assoc()) {
                        echo number_format($bazars['TotalBazar'],2);

                        $totalBazar =  $bazars['TotalBazar'];
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $totalCredit = $totalBazar+$totalpayment;

                    echo number_format($totalCredit,2);
                    ?>
                </td>
                <td>
                    <?php
                    $TotalCost = $totalCharge + $mealCost;
                    $balance = $totalCredit - $TotalCost;
                    echo number_format($balance,2);
                    ?>
                </td>
            </tr>
        <?php }} ?>
    </table>
</div>
<a href="javascript:genPDF()"><button class="btn btn-danger" style="width: 100px; float: right;" type="submit">Download</button></a>
