<?php
 
require_once 'db.php';
 
class Functions {
 
private $db;
private $mail;
 
public function __construct() {
 
      $this -> db = new DBOperations();
}
 
public function registerUser($name, $email, $password) {
 
   $db = $this -> db;
 
   if (!empty($name) && !empty($email) && !empty($password)) {
 
      if ($db -> checkUserExist($email)) {
 
         $response["result"] = "failure";
         $response["message"] = "User Already Registered !";
         return json_encode($response);
 
      } else {
 
         $result = $db -> insertData($name, $email, $password);
 
         if ($result) {
 
              $response["result"] = "success";
            $response["message"] = "User Registered Successfully !";
            return json_encode($response);
 
         } else {
 
            $response["result"] = "failure";
            $response["message"] = "Registration Failure";
            return json_encode($response);
 
         }
      }
   } else {
 
      return $this -> getMsgParamNotEmpty();
 
   }
}
 
public function loginUser($email, $password) {
 
  $db = $this -> db;
 
  if (!empty($email) && !empty($password)) {
 
    if ($db -> checkUserExist($email)) {
 
       $result =  $db -> checkLogin($email, $password);
 
       if(!$result) {
 
        $response["result"] = "failure";
        $response["message"] = "Incorrect login or password";
        return json_encode($response);
 
       } else {
 
        $response["result"] = "success";
        $response["message"] = "Login successefull";
        $response["user"] = $result;
        return json_encode($response);
 
       }
    } else {
 
      $response["result"] = "failure";
      $response["message"] = "Invaild login or password";
      return json_encode($response);
 
    }
  } else {
 
      return $this -> getMsgParamNotEmpty();
    }
}
 
public function changePassword($email, $old_password, $new_password) {
 
  $db = $this -> db;
 
  if (!empty($email) && !empty($old_password) && !empty($new_password)) {
 
    if(!$db -> checkLogin($email, $old_password)){
 
      $response["result"] = "failure";
      $response["message"] = 'Incorrect old password';
      return json_encode($response);
 
    } else {
 
    $result = $db -> changePassword($email, $new_password);
 
      if($result) {
 
        $response["result"] = "success";
        $response["message"] = "Password changed successfully";
        return json_encode($response);
 
      } else {
 
        $response["result"] = "failure";
        $response["message"] = 'Error change password';
        return json_encode($response);
 
      }
    }
  } else {
 
      return $this -> getMsgParamNotEmpty();
  }
}
 
public function isEmailValid($email){
 
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}
 
public function getMsgParamNotEmpty(){
 
  $response["result"] = "failure";
  $response["message"] = "Parameters should not be empty!";
  return json_encode($response);
 
}
 
public function getMsgInvalidParam(){
 
  $response["result"] = "failure";
  $response["message"] = "Invalid parameters";
  return json_encode($response);
 
}
 
public function getMsgInvalidEmail(){
 
  $response["result"] = "failure";
  $response["message"] = "Incorrect email";
  return json_encode($response);
 
}
    
    
//new code
public function resetPasswordRequest($email){
 
        $db = $this -> db;
 
        if ($db -> checkUserExist($email)) {
 
            $result =  $db -> passwordResetRequest($email);
 
            if(!$result){
 
                $response["result"] = "failure";
                $response["message"] = "Reset password failure";
                return json_encode($response);
 
            } else {
 
                //$mail_result = $this -> sendPHPMail($result["email"],$result["temp_password"]);
 
            /*    if($mail_result){
 
                    $response["result"] = "success";
                    $response["message"] = "Check your mail for reset password code.";
                    return json_encode($response);
 
                } else {
 
                    $response["result"] = "failure";
                    $response["message"] = "Reset Password Failure";
                    return json_encode($response);
                }
*/
            }
        } else {
 
            $response["result"] = "failure";
            $response["message"] = "Email does not exist";
            return json_encode($response);
 
        }
    }
 
    public function resetPassword($email,$code,$password){
 
        $db = $this -> db;
 
        if ($db -> checkUserExist($email)) {
 
            $result =  $db -> resetPassword($email,$code,$password);
 
            if(!$result){
 
                $response["result"] = "failure";
                $response["message"] = "Reset password failure";
                return json_encode($response);
 
            } else {
 
                $response["result"] = "success";
                $response["message"] = "Password changed successfully";
                return json_encode($response);
 
            }
        } else {
 
            $response["result"] = "failure";
            $response["message"] = "Email does not exist";
            return json_encode($response);
 
        }
    }
}