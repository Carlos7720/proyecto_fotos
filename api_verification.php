<?php
include 'conn.php';

//flag 1 for login
//flag 2 for update register

//print_r($_POST); exit(0);


//flag to check and to execute specific switch case based on flag value sent
$flag = $_POST['flag'];
(int) $flag;

switch ($flag) {
    
    case 1:
        	//assigning data sent to $Email which can be either email or mobile no in return we'll be sending email only
        	$Email = $_POST['email'];
        	$Password = md5($_POST['password']);
        	$fcm_token = $_POST['fcm_token'];
        
        	//creating a query
//        	$query = "SELECT * FROM user WHERE (Email='$Email' OR Mobile='$Email') AND Password = '$Password' AND status=1 ";

     $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $_POST['email']);

        	$result = mysqli_query($connect, $sql);
            
        
            if($result->num_rows>0){
    		    
        		while ($row = mysqli_fetch_assoc($result)) {
                    //Update FCM Token
                	/*$query2 = "UPDATE `user` SET `fcm_token`='$fcm_token' WHERE `id`='".$row['id']."' ";
                	$result2 = mysqli_query($connect, $query2);
        */
        			$json['value'] = 1;
        			$json['message'] = 'User Successfully LoggedIn';
        			$json['email'] = $row['username'];
        			$json['name'] = $row['name'];
        			$json['id'] = $row['id'];
        			$json['status'] = 'success';
        
        		}
    		    
    			
    		}else{
        
        			$json['value'] = 0;
        			$json['message'] = 'Failed to LogIn';
        			$json['email'] = '';
        			$json['name'] = '';
        			$json['id'] = '';
        			$json['status'] = 'failure';
    
    		}
    // 		echo json_encode($json);
    // 		mysqli_close($connect);
            
            break;
            //Ends case 1
    
    case 2:
             $Name = $_POST['name'];
             $Email = $_POST['email'];
             $Mobile = $_POST['mobile'];
             $Password = sha1($_POST['password']);
             $fcm_token = $_POST['fcm_token'];
    	
        /*
    		 $sqlmax = "SELECT max(id) FROM `user`";
    	     $resultmax = mysqli_query($connect, $sqlmax);
    	     $rowmax = mysqli_fetch_array($resultmax);
    	     
    	     if($rowmax[0]==null){
    	          $idnomax=1;
    	     }else{
    	          $idnomax=$rowmax[0]+1;
    	     }
             */
        
            $query = "SELECT * FROM users WHERE username='$Email'";
        	$result = mysqli_query($connect, $query);
        	
    		if(mysqli_num_rows($result)>0){
    			$json['value'] = 2;
    			$json['message'] = ' Email Already Used: ' .$Email;
    			
    		}else{
    			/*$query = "INSERT INTO user (id, Name, Email, Mobile, Password, fcm_token, status) VALUES ('$idnomax','$Name','$Email','$Mobile','$Password','$fcm_token', 1)";*/

        $query = "INSERT INTO users (";
        $query .="name,username,password,user_level,status, tipo";
        $query .=") VALUES (";
        $query .=" '{$Name}', '{$Email}', '{$Password}', '2','1','2'";
        $query .=")";


    			$inserted = mysqli_query($connect, $query);
    			
    			if($inserted == 1 ){    			
    			    
    				$json['value'] = 1;
    				$json['message'] = 'User Successfully Registered';
    			}else{
    				$json['value'] = 0;
    				$json['message'] = 'User Registration Failed';
    			}

      		}
      		
    //   		echo json_encode($json);
    // 		mysqli_close($connect);
            
            break;
            //Ends case 2
    
    default:
        $inserted == 0;
}    
        
	echo json_encode($json);
	mysqli_close($connect);

?>