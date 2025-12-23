<?php 

    require __DIR__ . '/../Abstract/Person.php';

    class Formateur extends Personne{
        public function __toString(): string
{
    return 'votre name est : '. $this->firstname . '<br/>, last name est : ' . $this->lastname . ' <br/>, votre email est : '. $this->email . ' <br/>, Votre phone est :' . $this->phone;;
}

    }


    
?> 




