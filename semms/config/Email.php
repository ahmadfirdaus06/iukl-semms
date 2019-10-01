<?php
    class Email{

        //testing email address
        public $to = "ahmad0609firdaus@gmail.com";
        public $subject = "";
        public $message = "";
        public $issued_amount = 0.00;
        public $paid_amount = 0.00; 
        public $outstanding = 0.00;

        public function __construct(){
        }

        //trigger on report made
        public function reportMade(){
            $this->subject = "IUKL Student Misconduct";
            $this->message = "Attention! This message was sent directly from IUKL Counselory Department. You are receiving this message because you are being suspected for committing examination misconduct in exam hall. Please contact IUKL Counselor in Student Affairs Division immediately for more details regarding this message.";
            if (mail($this->to,$this->subject,$this->message)){
                return true;
            }
            else{
                return false;
            }
        }

        //trigger on case opened
        public function caseOpened(){
            $this->subject = "IUKL Student Misconduct";
            $this->message = "A case has been opened regarding your previous misconduct. Please contact IUKL Counselor in Student Affairs Division immediately for more details regarding this message.";
            if (mail($this->to,$this->subject,$this->message)){
                return true;
            }
            else{
                return false;
            }
        }

        //trigger right after case opened
        public function primaryInvestigation(){
            $this->subject = "IUKL Student Misconduct";
            $this->message = "Your case is in the stage of 'Primary Investigation'. Please contact IUKL Counselor in Student Affairs Division immediately for more details regarding this message.";
            if (mail($this->to,$this->subject,$this->message)){
                return true;
            }
            else{
                return false;
            }
        }

        //trigger on primary investigation closed
        public function hearing(){
            $this->subject = "IUKL Student Misconduct";
            $this->message = "Your case is in the stage of 'Case Hearing'. Please contact IUKL Counselor in Student Affairs Division immediately for more details regarding this message.";
            if (mail($this->to,$this->subject,$this->message)){
                return true;
            }
            else{
                return false;
            }
        }

        //trigger on primary investigation/case hearing closed
        public function appeal(){
            $this->subject = "IUKL Student Misconduct";
            $this->message = "Your case is in the stage of 'Case Appeal'. Please contact IUKL Counselor in Student Affairs Division immediately for more details regarding this message.";
            if (mail($this->to,$this->subject,$this->message)){
                return true;
            }
            else{
                return false;
            }
        }

        //trigger on primary investigation/case hearing/case appeal closed
        public function fineSettlement(){
            $this->subject = "IUKL Student Misconduct";
            $this->message = "Your case is in the stage of 'Fine Settlement'. Please contact IUKL Counselor in Student Affairs Division immediately for more details regarding this message.";
            if (mail($this->to,$this->subject,$this->message)){
                return true;
            }
            else{
                return false;
            }
        }

        //trigger on fine settlement updated
        //require issued amount
        public function paymentSet(){
            $this->subject = "IUKL Student Misconduct";
            $this->message = "Your total fine amount for current case is RM " . $this->issued_amount . ". Please contact IUKL Counselor in Student Affairs Division immediately for more details regarding this message.";
            if (mail($this->to,$this->subject,$this->message)){
                return true;
            }
            else{
                return false;
            }
        }

        //trigger on payment made
        //require paid amount and outstanding
        public function paid(){
            $this->subject = "IUKL Student Misconduct";
            $this->message = "You have paid RM " . $this->paid_amount . ". The total pending payment is RM " . $this->outstanding . ". Please contact IUKL Counselor in Student Affairs Division immediately for more details regarding this message.";
            if (mail($this->to,$this->subject,$this->message)){
                return true;
            }
            else{
                return false;
            }
        }

        //trigger on outstanding = 0 and fine settlement and case closed
        public function caseClosed(){
            $this->subject = "IUKL Student Misconduct";
            $this->message = "Your case has been closed. Please contact IUKL Counselor in Student Affairs Division immediately for more details regarding this message.";
            if (mail($this->to,$this->subject,$this->message)){
                return true;
            }
            else{
                return false;
            }
        }
    }
?>