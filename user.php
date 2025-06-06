<?php
ob_start();
session_start();
require_once('config/config.php');
include_once('curl.php');
include_once('form.php');

if(!isset($_SESSION['user_id'])){
     header('location:login.php');
}
?>

<head> 
    <link rel="stylesheet" type="text/css" href="assests\css\font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assests\css\bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assests\css\style.css">
    <script src="assests\javascript\jquery.min.js"></script>
    <script src="assests\javascript\bootstrap.min.js"></script>
</head>



<?php
     if(isset($_POST['logout'])){
        session_destroy();
        header('location:login.php');
     }
?>

<div class = 'container-fluid'>
    <!-- header bar -->
    <div class = 'header'>
        <h1 style = "color:black; font-size:33px;">Contact Manager</h1>
        <form  action = 'search.php' method = 'post'>
            <input type = 'search' name = 'search1' placeholder = 'search' value = '' class = 'search-bar'>
            <button type = 'submit' name = 'search' class = 'search-btn'><i class="fa fa-search" aria-hidden="true"></i></button>     
        </form>    
        <h4 style = "color:black;"><?="Welcome ". $_SESSION['username']."!";?></h4>
        <i class="fa fa-user-circle " aria-hidden="true" title = 'profile'></i>
    </div>
    <!-- popup message for contact and group update-->
    <?php
    if(isset($_SESSION['popup'])){
        echo "<div class='popup-c'>".$_SESSION['popup']."<i class='fa fa-times' aria-hidden='true'></i></div>";
        unset($_SESSION['popup']);
    }
    ?>

    
    <div class = 'container1'>
        <!--left side bar--> 
        <div class = 'left-side-bar'>
            <form action = 'user.php'  method = 'post'>
                <i class="fa fa-user" aria-hidden="true"></i>
                <h2>contacts</h2>
                <input type='hidden' name = 'user_id' value = '<?php echo $_SESSION['user_id']; ?>'>
                <input type = 'submit' name = 'listcontact' value = 'listscontact' class='btn'>
                <input type = 'hidden' name = 'addc' value = '<?php echo $_SESSION['user_id']; ?>'>
                <input type = 'submit' name = 'addcon' value = 'addcontact' class='btn'>
            <hr>
                <i class="fa fa-users" aria-hidden = "true" ></i>                
                <h2>Groups</h2>
                <input type ='hidden' name = 'user_id' value = '<?php echo $_SESSION['user_id']; ?>'>
                <input type = 'submit' name = 'listgroup' value = 'listsgroup' class='btn'>
                <input type = 'submit' name = 'addg' value = 'addgroup' class='btn'>

            <hr>
                <button type = 'submit' name = 'logout' class = 'logout_btn'><i class="fa fa-sign-out" aria-hidden="true"></i><h4>Logout</h4></button>      
            </form>
        </div>

        <!--list div for all opertion(add,update,list,and delete)-->
        <div class = 'list-of-users'>
            <?php
                if(((isset($_POST['listcontact']) ||(empty($_POST))|| $_SESSION['show_contacts'] == true) && (!isset($_SESSION['search'])|| $_SESSION['search'] != true) )){
                    $_SESSION['show_contacts'] = false;
                    //to list contact information   
                ?>

                <div class = 'head-table'>
                    <h4>Contacts</h4>
                    <table cellspacing = '0' cellpadding = '0' border = '0' width = '100%'>
                        <tr class = 'table-header'>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Action</th>
                            <th></th>
                        </tr>
                        <?php

                        $postLoad = json_encode(["action"=>"showcontact","user_id"=>$_SESSION['user_id']]);
                        $res = new curl_function();
                        $res->setOptions($postLoad);
                        $response = $res->execute();
                        //echo mysqli_num_rows($select_result);                
                        if($response['status'] == 'success'){
                            foreach($response["message"] as $rows){
                                echo "<tr class ='row-data'>
                                    <form action = 'user.php' method = 'post'>
                                        <input type = 'hidden' name = 'phone' value = '".$rows['phone_number']."'>
                                        <input type = 'hidden' name = 'email' value = '".$rows['email_address']."'>
                                        <input type = 'hidden' name = 'contact_id' value = '".$rows['contact_id']."'>
                                        <input type = 'hidden' name = 'name1' value = '".$rows['name1']."'>
                                        <td><button = 'submit' name = 'viewname' value = '".$rows['name1']."' class = 'view-btn'>".$rows['name1']."</button></td>
                                        <td><button = 'submit' name = 'viewphoneno' value ='".$rows['phone_number']."' class = 'view-btn'>".$rows['phone_number']."</button></td>
                                        <td><button = 'submit' name = 'viewmail' value = '".$rows['email_address']."' class = 'view-btn'>".$rows['email_address']." </button></td>
                                        <td>
                                            <button type = 'submit' name = 'editcontact' value = '".$rows['contact_id']."' class = 'edit-btn'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>    
                                        </td>
                                    </form>
                                       <td>
                                            <form action = 'delete.php' method = 'post' class='del'>
                                                    <input type = 'hidden' name = 'contact_id' value = '".$rows['contact_id']."'>
                                                    <button type = 'submit' name = 'deletecontact' value = '".$rows['contact_id']."' class ='delete-btn'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                            </form> 
                                        </td>   
                                </tr>";
                                }
                        }
                        else{
                            echo "<h2>".$response['message']."</h2>";
                        }?>
                    </table>
                </div>
            <?php }?>
            <!--listcode for contact ends here-->
            
            <?php
            //to list a group
            if(isset($_POST['listgroup'])){?>
                    <div class = 'head-table'>
                        <h4>Groups</h4>
           
                        <table cellspacing = '0' cellpadding='0' border = '0' width ='100%'>
                            <tr class = 'table-header'>
                                <th>group name</th>
                                <th>action</th>
                                <th></th>
                            </tr>
                            <?php
                            $postLoad = json_encode(["action"=>"showgroup","user_id"=>$_SESSION['user_id']]);
                            $res = new curl_function();
                            $res->setOptions($postLoad);
                            $response = $res->execute();
                            if($response['status'] == 'success'){
                                foreach($response["message"] as $row){
                                    echo "<tr class ='row-data'>";
                                    echo "<td> 
                                            <form action = 'user.php' method = 'post' >
                                                <input type = 'hidden' name = 'group_id' value = '".$row['group_id']."'>
                                                <input type = 'hidden' name = 'group_name' value = '".$row['group_name']."'>
                                                <button type = 'submit' name = 'viewgroupmember' value = '' class ='view-btn' >".$row['group_name']."</button>
                                        </td>";
                                    echo "<td>
                                                <button type = 'submit' name = 'editgroup' value = '' class = 'edit-btn'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>
                                            </form>
                                            </td>
                                          <td> <form action = 'delete.php' method = 'post'> 
                                                   <input type = 'hidden' name = 'group_id' value = '".$row['group_id']."'>
                                                    <button type = 'submit' name = 'deletegroup' value = '' class ='delete-btn'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                            </form>    
                                        </td>";
                                    echo "</tr>";
                                }
                                }
                                else{
                                    echo "<h2>".$response['message']."</h2>";
                                }?>
                        </table>
                    </div>
            <?php }?>
          
            
            <?php
                //to view member of a group
                if(isset($_POST['viewgroupmember']))
                {
                    $group_id = $_POST['group_id'];
                    $groupname = $_POST['group_name'];
                ?>
                <div class = 'head-table'>
                    <h4><?= $groupname?></h4>

                    <form action = 'user.php' method = 'post'>
                        <input type = 'hidden' name = 'group_id' value = '<?php echo $group_id; ?>' >
                        <input type = 'hidden' name = 'group_name' value =' <?php echo $groupname; ?>' >
                        <button type = 'submit' name = 'addm' value = '' class = 'add-btn'><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </form> 
                                    
                    <table cellspacing = '0' cellpadding = '0' border = '0' width = '100%'>
                        <tr class = 'table-header'>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        <?php
                            $postLoad = json_encode(["action"=>"showgroupmember","group_id"=>$group_id]);
                            $res = new curl_function();
                            $res->setOptions($postLoad);
                            $response = $res->execute();                            
                        //echo mysqli_num_rows($select_result);
                        if($response['status']=='success'){                
                            foreach($response['message'] as $rows){?>
                                <?php
                                echo "<tr class ='row-data'>
                                    <td>".$rows['name1']."</td>
                                    <td>".$rows['phone_number']."</td>
                                    <td>".$rows['email_address']."</td>
                                    <td>
                                        <form action = 'delete.php' method = 'post'>
                                            <input type = 'hidden' name = 'contact_id' value = ".$rows['contact_id'].">
                                            <input type = 'hidden' name = 'group_id' value = ".$rows['group_id'].">
                                            <button type = 'submit' name = 'deletegroupmember' value = '' class ='delete-btn'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                        </form>    
                                    </td>
                                </tr>";
                            }
                        }
                        else{
                            echo "<h2>".$response['message']."</h2>";
                        }?>
                    
                    </table>
                </div>
            <?php }?>

            
            <?php
                //contact form for add contact
                if(isset($_POST['addcon'])){
                    contactform([], '');
             }?>

           
            <?php
                // to add members into group
                if(isset($_POST['addm'])){
                    
                    $postLoad = json_encode(['action'=>'listgroupmember','user_id'=>$_SESSION['user_id']]);
                    $res = new curl_function();
                    $res->setOptions($postLoad);
                    $response = $res->execute();

                    $group_id = $_POST['group_id'];
                    $group_name = $_POST['group_name'];

                   

                ?>
                <div class='form-container'>
                        <form action='insert.php' method='post'>
                            <label>Select Contact:</label>
                            <select name='contact_id' class = 'user' required>
                                <option value=''>-- Select Contact --</option>
                                <?php foreach ($response['message'] as $contact) { ?>
                                    <option value="<?= $contact['contact_id'] ?>"><?= htmlspecialchars($contact['full_name']) ?></option>
                                <?php } ?>
                            </select><br>
                            <input type='hidden' name='contactid' value='<?= $contact['contact_id'] ?>'>
                            <input type='hidden' name='group_id' value='<?= $group_id ?>'>
                            <input type='hidden' name='group_name' value='<?= $group_name ?>'>
                            <input type='submit' name='add_member' value='Add to Group' class = 'addc-btn'>
                        </form>
                </div>
             
            <?php }?>

            <?php
                //to view each contact details
                if(isset($_POST['viewname'])||isset($_POST['viewphoneno'])||isset($_POST['viewmail'])){
                    $contact_name = $_POST['name1'];
                    $phoneno = $_POST['phone'];
                    $email = $_POST['email'];
                    $contact_id = $_POST['contact_id'];

                    //echo $phoneno;
                    //echo $email;
                    echo "<div class='head-table'><h2>".$contact_name."</h2>";

                        $postLoad = json_encode(["action"=>"showcontactdetails","user_id"=>$_SESSION['user_id'],"phoneno"=>$phoneno,"email"=>$email,"contact_id"=>$contact_id]);
                        $res = new curl_function();
                        $res->setOptions($postLoad);
                        $response = $res->execute();
                        if($response['status'] == 'success'){
                            //echo $response['message'];
                            foreach($response['message'] as $row){
                                $contact_id = $row['contact_id'];
                                $firstname = $row['first_name'];
                                $lastname = $row['last_name'];
                                $nickname = $row['nick_name'];
                                $notes = $row['notes'];
                                $birthday = $row['birthday'];
                                $relationship = $row['relationship'];
                            }
                        }
                        else{
                            echo "<h2>".$response['message']."</h2>";
                        }
                    

                    echo "<table cellspacing = '0' cellpadding = '0' border = '0' width = '100%'>
                            <tr class = 'table-header'>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Nickname</th>
                                <th>Notes</th>
                                <th>Birthday</th>
                                <th>Relationship</th>
                            </tr>
                            <tr class ='row-data'>
                                <td>".$phoneno."</td>
                                <td>".$email."</td>
                                <td>".$firstname."</td>
                                <td>".$lastname."</td>
                                <td>".$nickname."</td>
                                <td>".$notes."</td>
                                <td>".$birthday."</td>
                                <td>".$relationship."</td>
                            </tr>
                            </table>";
                    echo "</div>";
                }
            ?>

            <?php
                //to create group
                if(isset($_POST['addg'])){
                   
                   groupform('', '');
        
                }
            ?> 
            
            
            <?php
                //to edit contact details
                if(isset($_POST['editcontact'])){
                    $contact_id = $_POST['editcontact'];
                    $postLoad = json_encode(["action"=>"editcontactform","user_id"=>$_SESSION['user_id'],"contact_id"=>$contact_id]);
                    $res = new curl_function();
                    $res->setOptions($postLoad);
                    $response = $res->execute();

                    if($response['status']=='success'){
                        contactform($response['message'], $contact_id);
                    }
                    else{
                        echo "<h2>".$response['message']."</h2>";
                    }
                    
                }
            ?>
              
            <?php
                // to edit group name
                if(isset($_POST['editgroup'])){
                    $group_id = $_POST['group_id'];
                    $group_name = $_POST['group_name'];

                    groupform($group_name, $group_id);
                     
                }
            ?>

            <?php
                if(!empty($_SESSION['search'])){
                    //to search contact information 
                    //echo $_SESSION['contact_id'];
                    $_SESSION['search'] = false; 
                ?>

                <div class = 'head-table'>
                    <h4>Contacts</h4>
                    <table cellspacing = '0' cellpadding = '0' border = '0' width = '100%'>
                        <tr class = 'table-header'>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Action</th>
                            <th></th>
                        </tr>
                        <?php
                        
                        foreach($_SESSION['contact_id'] as $contact_id){
                            $postLoad = json_encode(["action"=>"searchcontactdetails","user_id"=>$_SESSION['user_id'],"contact_id"=>$contact_id['contact_id']]);
                            $res = new curl_function();
                            $res->setOptions($postLoad);
                            $response = $res->execute();

                        //echo mysqli_num_rows($select_result);                
                            foreach($response['message'] as $rows){?>
                                    <?php
                                    echo "<tr class ='row-data'>
                                        <form action = 'user.php' method = 'post'>
                                            <input type = 'hidden' name = 'phone' value = '".$rows['phone_number']."'>
                                            <input type = 'hidden' name = 'email' value = '".$rows['email_address']."'>
                                            <input type = 'hidden' name = 'contact_id' value = '".$rows['contact_id']."'>
                                            <input type = 'hidden' name = 'name1' value = '".$rows['name1']."'>
                                            <td><button = 'submit' name = 'viewname' value = '".$rows['name1']."' class = 'view-btn'>".$rows['name1']."</button></td>
                                            <td><button = 'submit' name = 'viewphoneno' value ='".$rows['phone_number']."' class = 'view-btn'>".$rows['phone_number']."</button></td>
                                            <td><button = 'submit' name = 'viewmail' value = '".$rows['email_address']."' class = 'view-btn'>".$rows['email_address']." </button></td>
                                            <td>
                                                <button type = 'submit' name = 'editcontact' value = '".$rows['contact_id']."' class = 'edit-btn'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>    
                                            </td>
                                        </form>
                                        <td>
                                                <form action = 'delete.php' method = 'post' class='del'>
                                                        <input type = 'hidden' name = 'contact_id' value = '".$rows['contact_id']."'>
                                                        <button type = 'submit' name = 'deletecontact' value = '".$rows['contact_id']."' class ='delete-btn'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                                </form> 
                                            </td>   
                                    </tr>";
                            ?>
                           
                    <?php  }
                    }
                    ?>
                    </table>
                </div>
            <?php }?>
             
        </div>
    </div>
</div>

<?php
//to close database connection
ob_end_flush();
?>