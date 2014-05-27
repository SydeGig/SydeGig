<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div align ="center">
    <lead>
        The Following Employees are Available for your Job:
    </lead>
</div>

<table class="table table-bordered table-hover" width="647">
    <thead>
        <tr class="warning">
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
       
            <?php
            $incrementor = 1;

            $connection = Yii::app()->db;

            $usersQuery = "select * from Employee";

            $users = $connection->createCommand($usersQuery)->queryAll();

            foreach ($users as $user) {

                print(" <tr>
                       <td>" . $incrementor . "</td>
                       <td>" . $user['fname'] . " " . $user['lname'] . "</td>
                       <td>" . $user['email'] . "</td> </tr>");

                $incrementor++;
            }
            ?>
        </tr>
        <tr>

    </tbody>
</table>
