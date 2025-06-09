<?php
ob_start();
require_once('config/config.php');

$db = new dbConnection();
$dbConnection = $db->getConnection();

$data = json_decode(file_get_contents('php://input'),true);

switch($data['action']){

    case 'deletecontact':
                        $delete_details = "UPDATE contact_details 
                                        SET contact_details_delete = 1
                                        WHERE contact_id = :contact_id";

                        $result_query = $dbConnection->prepare($delete_details);
                        $result_query->bindParam(':contact_id', $data['contact_id']);

                        if($result_query->execute()){                   
                            $delete_query = "UPDATE contacts 
                                            SET contact_delete = 1
                                            WHERE contact_id = :contact_id";
                            
                            $result_query = $dbConnection->prepare($delete_query);
                            $result_query->bindParam(':contact_id',$data['contact_id']);
                            if ($result_query->execute()) {
                                echo json_encode(["status" => "success", "message" => "Contact deleted successfully"]);
                            } else {
                                echo json_encode(["status" => "error", "message" => "Error deleting contact"]);
                            }
                        }
                        break;

    case 'deletegroup':
                        // to delete group
                        $delete_query = "UPDATE contact_groups
                                         SET group_delete = 1
                                         WHERE group_id = :group_id AND user_id = :user_id";
                        $result_query = $dbConnection->prepare($delete_query);
                        $result_query->bindParam(':group_id', $data['group_id']);
                        $result_query->bindParam(':user_id', $data['user_id']);
                        if($result_query->execute()){
                            $delete_member_query = "UPDATE group_member 
                                                    SET member_delete = 1
                                                    WHERE group_id = :group_id AND member_delete = 0";

                            $result_query = $dbConnection->prepare($delete_member_query);
                            $result_query->bindParam(':group_id', $data['group_id']);
                            if ($result_query->execute()) {
                                echo json_encode(["status" => "success", "message" => "Group deleted successfully"]);
                            } else {
                                echo json_encode(["status" => "error", "message" => "Error deleting group"]);
                            }
                        } 
                                                
                        break;

    case 'deletemember':

                        //to remove member in a group
                        $delete_query = "UPDATE group_member 
                                        SET member_delete = 1
                                        WHERE contact_id= :contact_id AND group_id= :group_id";

                        $result_query = $dbConnection->prepare($delete_query);
                        $result_query->bindParam(':contact_id', $data['contact_id']);
                        $result_query->bindParam(':group_id', $data['group_id']);
                        if ($result_query->execute()) {
                            echo json_encode(["status" => "success", "message" => "Group member removed successfully"]);
                        } else {
                            echo json_encode(["status" => "error", "message" => "Error removing group member"]);
                        }
                            
                        
                        break;

    case 'updatecontact':
                        $update_query = "UPDATE contacts 
                        SET first_name= :firstname , last_name= :lastname, nick_name= :nickname, notes= :notes, birthday= :birthday, relationship= :relationship 
                        WHERE contact_id= :contact_id";
                        $result_query = $dbConnection->prepare($update_query);
                        $result_query->bindParam(':firstname', $data['firstname']);
                        $result_query->bindParam(':lastname', $data['lastname']);
                        $result_query->bindParam(':nickname', $data['nickname']);
                        $result_query->bindParam(':notes', $data['notes']);
                        $result_query->bindParam(':birthday', $data['birthday']);
                        $result_query->bindParam(':relationship', $data['relationship']);
                        $result_query->bindParam(':contact_id', $data['contactId']); 
                        if ($result_query->execute()) {
                            echo json_encode(["status" => "success", "message" => "contact updated successfully"]);
                        } else {
                            echo json_encode(["status" => "error", "message" => "Error updating contact"]);
                        }                        
                        break;

    case 'updategroup':
                        $update_query = "UPDATE contact_groups 
                                         SET group_name= :group_name 
                                         WHERE group_id= :group_id";

                        $result_query = $dbConnection->prepare($update_query);
                        $result_query->bindParam(':group_name', $data['groupName']);
                        $result_query->bindParam(':group_id', $data['groupId']);

                        if ($result_query->execute()) {
                            echo json_encode(["status" => "success", "message" => "Group updated successfully"]);
                        } else {
                            echo json_encode(["status" => "error", "message" => "Error updating group"]);
                        }

                        break;

    case 'addcontact':
                    // to check if phone number exists or not
                    // if it exists, get the phone_id, else insert the new phone and get the phone_id
                    $select_phone_query = "SELECT phone_id FROM contact_phones 
                                           WHERE phone_number = :phoneno";
                    $result_query = $dbConnection->prepare($select_phone_query);
                    $result_query->bindParam(':phoneno', $data['phoneno']);
                    $result_query->execute();
                    if($result_query->rowcount() == 1){
                        $row = $result_query->fetch(PDO::FETCH_ASSOC);
                        $phone_id = $row['phone_id'];
                    }
                    else{
                        $insert_query = "INSERT INTO contact_phones (phone_number) 
                                        VALUES (:phoneno)";
                        $result_query = $dbConnection->prepare($insert_query);
                        $result_query->bindParam(':phoneno', $data['phoneno']);
                        if($result_query->execute()){
                            $phone_id = $dbConnection->lastInsertId();
                        }
                        
                    }

                    // to check if email exists or not
                    // if it exists, get the email_id, else insert the new email and get the email_id
                    $select_email_query = "SELECT email_id FROM contact_emails 
                                           WHERE email_address = :email";
                    $result_query = $dbConnection->prepare($select_email_query);
                    $result_query->bindParam(':email', $data['email']);
                    $result_query->execute();
                    if($result_query->rowcount() == 1)
                    {
                        $row = $result_query->fetch(PDO::FETCH_ASSOC);
                        $email_id = $row['email_id'];
                    }
                    else{
                        $insert_query = "INSERT INTO contact_emails (email_address) 
                                        VALUES (:email)";
                        $result_query = $dbConnection->prepare($insert_query);
                        $result_query->bindParam(':email', $data['email']);
                        if($result_query->execute()){
                            $email_id = $dbConnection->lastInsertId();
                        }
                        
                    }
                    
                    
                    $insert_query = "INSERT INTO contacts (user_id,first_name,last_name,nick_name,notes,birthday,relationship) 
                                    VALUES (:user_id,:firstname,:lastname,:nickname,:notes,:birthday,:relationship)";
                    $result_query = $dbConnection->prepare($insert_query);
                    $result_query->bindParam(':user_id', $data['userid']);
                    $result_query->bindParam(':firstname', $data['firstname']);
                    $result_query->bindParam(':lastname', $data['lastname']);
                    $result_query->bindParam(':nickname', $data['nickname']);
                    $result_query->bindParam(':notes', $data['notes']);
                    $result_query->bindParam(':birthday', $data['birthday']);
                    $result_query->bindParam(':relationship', $data['relationship']);
                    if($result_query->execute()){
                        $contact_id = $dbConnection->lastInsertId();
                    }
                    

                    $details_query = "INSERT INTO contact_details(contact_id,phone_id,email_id)
                                      VALUES (:contact_id,:phone_id,:email_id)";
                    $result_query = $dbConnection->prepare($details_query);
                    $result_query->bindParam(':contact_id', $contact_id);
                    $result_query->bindParam(':phone_id', $phone_id);
                    $result_query->bindParam(':email_id', $email_id);
                    if ($result_query->execute()) {
                        echo json_encode(["status" => "success", "message" => "Contact created successfully"]);
                    } else {
                        echo json_encode(["status" => "error", "message" => "Error creating contact"]);
                    }
                    break;
                    
    case 'addgroup':
                    $insert_query = "INSERT INTO contact_groups(user_id,group_name)
                                    VALUES (:user_id,:group_name)";
                    $result_query = $dbConnection->prepare($insert_query);
                    $result_query->bindParam(':user_id', $data['user_id']);
                    $result_query->bindParam(':group_name', $data['group_name']);
                    if ($result_query->execute()) {
                        echo json_encode(["status" => "success", "message" => "Group created successfully"]);
                    } else {
                        echo json_encode(["status" => "error", "message" => "Error creating group"]);
                    }
                    break;

    case 'addmember':

                    $check_query = "SELECT * FROM group_member
                                    WHERE contact_id = :contact_id AND group_id = :group_id";
                    $result_query = $dbConnection->prepare($check_query);
                    $result_query->bindParam(':contact_id', $data['contact_id']);
                    $result_query->bindParam(':group_id', $data['group_id']);
                    $result_query->execute();

                    if ($result_query->rowcount() > 0) {
                        echo json_encode(["status" =>"success" ,"message"=>"Contact is already in this group"]) ;
                    } 
                    else {
                        $insert_query = "INSERT INTO group_member (contact_id, group_id) 
                                         VALUES (:contact_id, :group_id)";
                        $result_query = $dbConnection->prepare($insert_query);
                        $result_query->bindParam(':contact_id', $data['contact_id']);
                        $result_query->bindParam(':group_id', $data['group_id']);
                        if ($result_query->execute()) {
                            echo json_encode(["status" => "success", "message" => "Group member added successfully"]);
                        } else {
                            echo json_encode(["status" => "error", "message" => "Error adding group member"]);
                        }
                        
                    }
                    break;

    case 'searchcontact':
                        $query = "SELECT contact_id FROM contacts 
                        WHERE first_name LIKE :search AND user_id = :user_id AND contact_delete = 0";
                        $result_query = $dbConnection->prepare($query);
                        $result_query->bindParam(':search', $data['search']);
                        $result_query->bindParam(':user_id', $data['user_id']);
                        $result_query->execute();
                        //echo mysqli_num_rows($result);
                        if($result_query->rowcount() > 0){ 
                            $row = $result_query->fetchall(PDO::FETCH_ASSOC);
                            echo json_encode(["status"=>"success","search"=>"true","contact_id"=>$row]);
                        }else{
                            echo json_encode(["status"=>"error","message"=>"contact not found"]);
                        }
                        
                        break;


    case 'showcontact':
                        $select_query = "SELECT cont.contact_id,CONCAT(cont.first_name,' ',cont.last_name) AS name1,phone.phone_number ,mail.email_address
                        FROM
                        contact_details AS cont_d
                        JOIN 
                        contacts AS cont ON
                        cont_d.contact_id = cont.contact_id
                        JOIN 
                        contact_phones AS phone ON
                        cont_d.phone_id = phone.phone_id
                        JOIN 
                        contact_emails AS mail ON
                        cont_d.email_id = mail.email_id
                        WHERE cont.user_id = :user_id AND cont.contact_delete = 0";
                        $stmt = $dbConnection->prepare($select_query);
                        $stmt->bindParam(':user_id', $data['user_id']);
                        if($stmt->execute()){
                            $value = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo json_encode(["status"=>"success","message"=>$value]);
                        }
                        else{
                            echo json_encode(["status"=>"error","message"=>"Error fetching contacts"]);
                        }
                        break;

    case 'showgroup':
                    $select_query = "SELECT group_id,group_name FROM
                    contact_groups 
                    WHERE user_id = :user_id AND group_delete = 0";
                    $select_result = $dbConnection->prepare($select_query);
                    $select_result->bindParam(':user_id', $data['user_id']);
                    //echo mysqli_num_rows($select_result);
                    if($select_result->execute()){
                        $value = $select_result->fetchall(PDO::FETCH_ASSOC);
                        echo json_encode(["status"=>"success","message"=>$value]);
                    }
                    else{
                        echo json_encode(["status"=>"error","message"=>"Error fetching groups"]);
                    }
                    break;

    case 'showgroupmember':
                            $select_query = "SELECT gm.*,CONCAT(cont.first_name,' ',cont.last_name) AS name1, phone.phone_number, mail.email_address
                                            FROM group_member gm
                                            JOIN 	
                                            contacts AS cont ON 
                                            gm.contact_id = cont.contact_id
                                            JOIN 
                                            contact_details AS cont_d ON 
                                            cont.contact_id = cont_d.contact_id
                                            JOIN 
                                            contact_phones AS phone ON 
                                            cont_d.phone_id = phone.phone_id
                                            JOIN 
                                            contact_emails AS mail ON 
                                            cont_d.email_id = mail.email_id
                                            WHERE gm.group_id = :group_id AND gm.member_delete = 0"; 
                            $select_result = $dbConnection->prepare($select_query);
                            $select_result->bindParam(':group_id', $data['group_id']);
                            if($select_result->execute()){
                                $value = $select_result->fetchall(PDO::FETCH_ASSOC);
                                echo json_encode(["status"=>"success","message"=>$value]);
                            }
                            else{
                                echo json_encode(["status"=>"error","message"=>"Error fetching group members"]);
                            }
                            break;

    case 'showcontactdetails':   
                            $select_query = "SELECT * FROM contacts
                                             WHERE user_id = :user_id AND contact_id = :contact_id";
                            $result_query = $dbConnection->prepare($select_query);
                            $result_query->bindParam(':user_id', $data['user_id']);
                            $result_query->bindParam(':contact_id', $data['contact_id']);
                            $result_query->execute();

                            if($result_query->rowcount() > 0){
                                $row = $result_query->fetchall(PDO::FETCH_ASSOC);
                                echo json_encode(["status"=>"success","message"=>$row]);
                            }
                            else{
                                echo json_encode(["status"=>"error","message"=>"Error fetching contact details"]);
                            }
                            break;

    case 'editcontactform':
                            $select_query = "SELECT cont.*, phone.phone_number, mail.email_address
                                            FROM contacts AS cont
                                            JOIN contact_details AS cd ON cd.contact_id = cont.contact_id
                                            JOIN contact_phones AS phone ON cd.phone_id = phone.phone_id
                                            JOIN contact_emails AS mail ON cd.email_id = mail.email_id
                                            WHERE cont.user_id = :user_id AND cont.contact_id = :contact_id AND cont.contact_delete = 0";

                            $result_query = $dbConnection->prepare($select_query);
                            $result_query->bindParam(':user_id', $data['user_id']);
                            $result_query->bindParam(':contact_id', $data['contact_id']);
                            $result_query->execute();

                            if($result_query->rowcount() > 0){
                                $row = $result_query->fetchall(PDO::FETCH_ASSOC);
                                echo json_encode(["status"=>"success","message"=>$row]);
                            }
                            else{
                                echo json_encode(["status"=>"error","message"=>"Error fetching contact details"]);
                            }
                            break;

    case 'listgroupmember':
                            $contact_query = "SELECT contact_id, CONCAT(first_name, ' ', last_name) AS full_name 
                                                FROM contacts
                                                WHERE user_id = :user_id AND contact_delete = 0";
                            $contact_result = $dbConnection->prepare($contact_query);
                            $contact_result->bindParam(':user_id', $data['user_id']);
                            $contact_result->execute();
                            if($contact_result->rowcount()>0)
                            {
                                $row = $contact_result->fetchall(PDO::FETCH_ASSOC);
                                echo json_encode(["status"=>"success","message"=>$row]);
                            }
                            else{
                                echo json_encode(["status"=>"error","message"=>"Error fetching contact details"]);
                            }
                            break;
   
    case 'login':
                $query = "SELECT * FROM users WHERE email = :email";
                $stmt = $dbConnection->prepare($query);
                $stmt->bindParam(':email', $data['email']);
                if($stmt->execute()){
                    $result = $stmt->fetchall(PDO::FETCH_ASSOC);
                    if($result){
                        echo json_encode(["status"=>"success","message"=>$result]);
                    } else {
                        echo json_encode(["status"=>"error","message"=>"User not found"]);
                    }
                }
                break;

    case 'register':
                    $check_query = "SELECT * FROM users WHERE email = :email";
                    $stmt = $dbConnection->prepare($check_query);
                    $stmt->bindParam(':email', $data['email']);
                    $stmt->execute();
                
                    if ($stmt->rowCount() > 0) {
                        echo json_encode(["status" => "emailexists", "message" => "Email already exists"]);
                    } else {
                        $insert_query = "INSERT INTO users (name, email, password) VALUES (:username, :email, :password)";
                        $stmt = $dbConnection->prepare($insert_query);
                        $stmt->bindParam(':username', $data['username']);
                        $stmt->bindParam(':email', $data['email']);
                        $stmt->bindParam(':password', $data['password']);
                
                        if ($stmt->execute()) {
                            echo json_encode(["status" => "success", "message" => "User registered successfully"]);
                        } else {
                            echo json_encode(["status" => "error", "message" => "Error registering user"]);
                        }
                    }
                    break;
                
  case 'searchcontactdetails':
                            $select_query = "SELECT cont.contact_id,CONCAT(cont.first_name,' ',cont.last_name) AS name1,phone.phone_number ,mail.email_address
                                            FROM
                                            contact_details AS cont_d
                                            JOIN 
                                            contacts AS cont ON
                                            cont_d.contact_id = cont.contact_id
                                            JOIN 
                                            contact_phones AS phone ON
                                            cont_d.phone_id = phone.phone_id
                                            JOIN 
                                            contact_emails AS mail ON
                                            cont_d.email_id = mail.email_id
                                            WHERE cont.user_id = :user_id AND cont.contact_id = :contact_id AND cont.contact_delete = 0";
                            $result_query = $dbConnection->prepare($select_query);
                            $result_query->bindParam(':user_id', $data['user_id']);
                            $result_query->bindParam(':contact_id', $data['contact_id']);
                            $result_query->execute();
                            if($result_query->rowcount() > 0){
                                $row = $result_query->fetchall(PDO::FETCH_ASSOC);
                                echo json_encode(["status"=>"success","message"=>$row]);
                            }
                            else{
                                echo json_encode(["status"=>"error","message"=>"Error fetching contact details"]);
                            }

        
ob_end_flush();
}