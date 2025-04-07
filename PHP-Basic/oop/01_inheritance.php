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

    class Employee extends User{
        public $title;
        
        public function __construct($name, $email, $age, $password, $title){

            parent::__construct($name, $email, $age, $password);
            $this->title = $title;
        }

        public function get_title(){
            return $this->title;
        }
    }

    $employee1 = new Employee('Nhu Y', 'nhuytran@gmail.com', 22, '123', 'Intern');
    echo $employee1->get_title();
?>