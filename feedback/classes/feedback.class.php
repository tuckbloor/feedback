<?php
 class Feedback {

 	public $errors;
 	
 	public function name($name) {
 		$this->name = $name;
 		return $name;
 	}

        public function lastname($lastname) {
        $this->lastname = $lastname;
    }

 	public function rating($rating) {
 		$this->rating = $rating;
 		return $rating;
 	}

 	public function comment($comment) {
 		$this->comment = $comment;
 		return $comment;
 	}

    public function url($url) {
        $this->url = $url;
        return $url;
    }

    public function email($email) {
        $this->email = $email;
        $this->email=filter_var($this->email, FILTER_SANITIZE_EMAIL);

        return  $this->errors;   
    }
    

     //validate make sure all fields are filled in  also honeypot for bots (lastname)        
    public function validate() {
        if(empty($this->comment) || empty($this->name) || empty($this->email) || empty($this->rating) || !empty($this->lastname)) {
        $this->errors = "<p>All Fileds Are Required</p>";
        return $this->errors;             
        }
        else {
        	
        $match="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
        if (!preg_match($match, $this->email)) {
        $this->errors ="<p>Email Not Valid</p>";
        return $this->errors;
}

    if(!$this->errors) {
		$message="You Have Received A Message From " . $this->name . "\r\n";
		$message.="Email: " . $this->email . "\n";
		$message.="Rating: " . $this->rating . "\r\n";
		$message.="Comment: " . $this->comment . "\r\n";
				
		$headers = 'From: $from' . "\r\n";
               
				
        if( mail('$to', "feedback", $message, $headers)) {
	    echo "<p>Thank You For The Feedback</p>";
        mysql_query("INSERT INTO comments (name, email, comment, url, rating, active) VALUES ('$this->name', '$this->email', '$this->comment', '$this->url', '$this->rating', '0')") or die(mysql_error());
	    }
	   
	    else {
		     echo "<p>Sorry The Message Failed</p>";
			 }
           } 

        }
     }
 }
?>