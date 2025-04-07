<?php
    class User{
        public $name;
        public $email;
        public $age;
        public $password;

        // public function __construct(){
        // }

        public function __construct($name, $email, $age, $password){
            $this->name = $name;
            $this->email = $email;
            $this->age = $age;
            $this->password = $password;
        }

        function set_name($name){
            $this->name = $name;
        }
        function get_name(){
            return $this->name;
        }
    }
    
    // $user1 = new User();
    // $user1->name = 'Nhu Y';
    // $user1->email = 'nhuytran@gmail.com';
    // $user1->age = 22;
    // $user1->password = '123';
    // $user1->set_name('Nhu Y');

    $user1 = new User('Nhu Y', 'nhuytran@gmail.com', 22, '123');
    
    print_r($user1);
    echo $user1->get_name();
    

?>