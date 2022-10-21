<?php namespace DAO;

    use Models\User as User;

    class UserDAO{
        private $userList = array();

        public function Add(User $user)
        {
            $this->RetrieveData();
            
            array_push($this->userList, $user);

            $this->Save();
        }

        public function GetAll()
        {
            $this->RetrieveData();

            return $this->userList;
        }

        public function GetMaxID(){
            $this -> RetrieveData();
            $maxID = 0;

            foreach($this->userList as $user){
               if($user -> getID() > $maxID){
                $maxID = $user ->getID();
               }
            }

            return $maxID;
        }


        private function Save()
        {
            $arrayToEncode = array();

            foreach($this->userList as $user)
            {              
                $valuesArray["userID"] = $user->getId();
                $valuesArray["userName"] = $user->getNombreUser();
                $valuesArray["password"] = $user ->getContrasena();
                $valuesArray["email"] = $user -> getEmail();
                $valuesArray["accountType"] = $user->getTipodecuenta();



                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            
            file_put_contents('Data/users.json', $jsonContent);
        }

        private function RetrieveData()
        {
            $this->userList = array();

            if(file_exists('Data/users.json'))
            {
                $jsonContent = file_get_contents('Data/users.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray)
                {
                    $user = new User(
                        $valuesArray["userID"],
                        $valuesArray["userName"],
                        $valuesArray["password"]);
                    array_push($this->userList, $user);
                }
            }
        }
    }

?>