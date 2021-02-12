<?php

$errors = array();
$name;
$age;
$surname;
$country;
$ageRange;

if ($_SERVER['REQUEST_METHOD'] === 'POST'  && isset($_POST["submit"])) {
    require('../model/Database.php');
    require('validate.php');
    validateName();
    validateSurname();
    validateAge();

    //only if there have been no errors in the form, the entries are validated;
    if(empty($errors)){
        filterAllInputs();
        $result = array();
        dataTreatment($result,$arrayPersonas);
        
        if(sizeof($result) > 0){
            /*
            Inicio una sesión para poder enviar mediante el método POST el array 
            con el resultado de la búsqueda. Y así poder navegar hacia la página de resultados
            sin exponer los datos por la url.
            */
            session_start();
            $_SESSION['result'] = $result;
            session_write_close();
            header('location: ../view/showTable.php');
        }else{
            
            //if the result array is empty, a code is passed to display a snackbar
            header('location: ../index.php?code='."empty");
        }
        
    }else{
        session_start();
        $_SESSION['error'] = $errors;
        session_write_close();
        /*
            Inicio una sesión para poder enviar mediante el método POST el array 
            que contiene los errores cometidos por el usuario en el formulario.
            Y así poder navegar hacia la página de errores sin exponer los datos por la url.
        */
        header('location: ../view/error.php');
    }

}


function dataTreatment(&$result , $data){
    global $name, $age, $surname,$country,$ageRange;

    foreach($data as $person){    
        //Check if the name is field the same as person.
        if($person['firstname'] == $name ){
            //Check if the surname has been filled
            if($surname != ""){
                // If surname has been filled ,
                // check if it is the same surname as the person
               if($surname !== $person['surname']) continue; 
            }
            
             //Check country
             if($country != '-1'){
                if($country != $person['country']) continue;
            }

             if($age != '-1'){
                 switch($ageRange){
                     case '0': 
                        if($age == $person['age']) $result[] = $person;
                     break;
                     case '1':
                         if($person['age'] >=  $age) $result[] = $person ;
                         break;
                    case '2':
                        if( $person['age'] <= $age) $result[] = $person;
                        break;
                 }
             }else{
                $result[] = $person;
             }
        }
    }

}
?>