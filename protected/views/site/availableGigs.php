<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div align ="center">
    <lead>
        The Following Gigs are Available Gigs for you:
    </lead>
</div>

<table class="table table-bordered table-hover" width="647">
    <thead>
        <tr class="warning">
            <th>#</th>
            <th>Job Title</th>
            <th>Company</th>
        </tr>
    </thead>
    <tbody>
       
            <?php
            $incrementor = 1;

            $connection = Yii::app()->db;

            $usersQuery = "select * from PostedGigs";

            $users = $connection->createCommand($usersQuery)->queryAll();
            
          

            foreach ($users as $user) {

                print(" <tr>
                       <td>" . $incrementor . "</td>
                       <td> <a style=text-decoration: none href= /SydeGig/index.php/site/pickupGig/?gig=".$user['pgid'].">". $user['title']."<font color=black> </font> </a> </td>");
                $info = $connection->createCommand("select name n from employer where eid=".$user['employer_id'])->queryRow();
                
                           
                       print("<td>" . $info['n'] . "</td> </tr>");

                $incrementor++;
            }
            ?>
        </tr>
        <tr>

    </tbody>
</table>


