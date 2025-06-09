
<?php
function contactform($data,$contact_id){
    //print_r($data);
?>
    <div class='form-container'><h2><?= !empty($data)?'edit':'add';?></h2>
        <form action = '<?= !empty($data)?"edit.php":"insert.php"?>' method = 'post'>
            <input type='hidden' name='contact_id' value='<?= $contact_id ?>'>
            <label for = 'phoneno'>Phone Number:</label><br>
            <input type = 'text' name = 'phoneno' class = 'user' placeholder = 'Enter Phone Number' value="<?=  !empty($data)?$data[0]['phone_number']:'' ?>"><br>
            <label for = 'email'>Email:</label><br>
            <input type = 'text'  name = 'email' class = 'user' placeholder = 'Enter Email' value = "<?=  !empty($data)?$data[0]['email_address']:'' ?>"><br>
            <label for = 'firstname'>First Name:</label><br>
            <input type = 'text'  name = 'firstname' class = 'user' placeholder = 'Enter First Name' value="<?=  !empty($data)?$data[0]['first_name']:''?>"><br>
            <label for = 'lastname'>Last Name:</label><br>
            <input type = 'text' name = 'lastname' class = 'user' placeholder = 'Enter Last Name' value = "<?=  !empty($data)?$data[0]['last_name']:''?>"><br>
            <label for = 'nickname'>Nickname:</label><br>
            <input type = 'text'  name = 'nickname' class = 'user' placeholder = 'Enter Nickname' value = "<?=  !empty($data)?$data[0]['nick_name']:''?>"><br>
            <label for = 'notes'>Notes:</label><br>
            <input type = 'text'  name = 'notes' class = 'user' placeholder = 'Enter Notes' value = "<?=  !empty($data)?$data[0]['notes']:'' ?>"><br>
            <label for = 'birthday'>Birthday:</label><br>
            <input type = 'date'  name = 'birthday' class = 'user' value = "<?=  !empty($data)?$data[0]['birthday']:''?>"><br>
            <label for='relationship'>Relationship:</label><br>
            <input type='text'  name='relationship' class='user' value = "<?=  !empty($data)?$data[0]['relationship']:'' ?>"><br>
            <input type='submit' name="<?=  !empty($data)?'submit_edit_form':'submit_contact_form' ?>" value= "<?=  !empty($data)?'editcontact':'Addcontact' ?>" class='addc-btn'>
        </form>
    </div>
<?php
}

function groupform($data,$group_id){
?>
    <div class='form-container'>
        <h2>Group</h2>
        <form action = '<?= !empty($data)?"edit.php":"insert.php"?>' method = 'post'>
            <input type='hidden' name='group_id' value='<?= $group_id ?>'>
            <label for='group_name'>Group Name:</label><br>
            <input type='text' name='group_name' class='user' placeholder='Enter Group Name' value="<?=  !empty($data)?$data:'' ?>"><br>
            <input type='submit' name="<?=  !empty($data)?'update_group':'addgv' ?>" value="<?=  !empty($data)?'Update Group':'Create Group' ?>" class='addc-btn'>
        </form>
    </div>
<?php
}

function listcontact($rows){
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

function listgroup($row){
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

function listgroupmember($rows){
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

function addmemberform($response,$group_id,$group_name){
?>
    <form action='insert.php' method='post'>
        <label>Select Contact:</label>
        <select name='contact_id' class = 'user' required>
            <option value=''>-- Select Contact --</option>
            <?php foreach ($response as $contact) { ?>
                <option value="<?= $contact['contact_id'] ?>"><?= htmlspecialchars($contact['full_name']) ?></option>
            <?php } ?>
        </select><br>
        <input type='hidden' name='contactid' value='<?= $contact['contact_id'] ?>'>
        <input type='hidden' name='group_id' value='<?= $group_id ?>'>
        <input type='hidden' name='group_name' value='<?= $group_name ?>'>
        <input type='submit' name='add_member' value='Add to Group' class = 'addc-btn'>
    </form>

<?php
}
?>
    

