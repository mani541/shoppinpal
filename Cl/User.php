<?php
/**
 * This User will have functions that handles facebook login and logout
 * @author Manikanta Allada.
 * 
 */
class Cl_User
{
	/**
	 * @var will going contain database connection
	 */
	protected $_con;
	
	/**
	 * it will initalize DBclass
	 */
	public function __construct()
	{
		$db = new Cl_DBclass();
		$this->_con = $db->con;
	}
	/**
	 * This method will handle Facebook login
	 * @param array $data
	 * @throws Exception
	 * @return boolean true or false based on success or failure
	 */
	
	public function fb_login( array $data )
	{
		if( !empty( $data ) ){
			// Trim all the incoming data:
			$trimmed_data = array_map('trim', $data);
		}	
		// escape variables for security
		$name = mysqli_real_escape_string( $this->_con, $trimmed_data['name'] );
		$email = mysqli_real_escape_string( $this->_con, $trimmed_data['email'] );
		$social_id = mysqli_real_escape_string( $this->_con, $trimmed_data['id'] );
		$image = mysqli_real_escape_string( $this->_con, $trimmed_data['image'] );
		$query = "SELECT user_id, name, email, created FROM users where email = '$email' and social_id = '$social_id' ";
		$result = mysqli_query($this->_con, $query);
		$data = mysqli_fetch_assoc($result);
		$count =array();
		if($data!= NULL){
	    $count = mysqli_num_rows($result);
		}
		if( ($count >= 1) && ($data != NULL)){
			$_SESSION = $data;
			$_SESSION['logged_in'] = true;
			return true;
		}else{
			$query = "INSERT INTO users (user_id, name, email, social_id,picture,created) VALUES (NULL, '$name', '$email', '$social_id','$image', CURRENT_TIMESTAMP)";
			$result = mysqli_query($this->_con, $query);
			if($result){
				$_SESSION = $trimmed_data;
				$_SESSION['logged_in'] = true;
				return true;
			}
		}
			
		
	}
	/**
	 * Log out process
	 */
	public function logout()
	{
		session_unset();
		session_destroy();
		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);
		header('Location: index.php');
	}
	
	
	public function pr($data = ''){
		echo "<pre>"; print_r( $data ); echo "</pre>";
	}
}