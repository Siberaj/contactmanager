
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
?>
    

