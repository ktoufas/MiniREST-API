<!DOCTYPE html>
<html>
<body>

  <table id="tempProvisions" border="1" style="width:45%; float: left;">
      <tr>
        <th style="width:40%;">Παροχές</th>
        <th> </th>
      </tr>
      <tr>
        <td>Ακαδημαϊκή ταυτότητα:</td>
        <td><?php
	          $_SERVER['authAPM'] ='1975';
            if(isset($_SERVER['authAPM'])){
              $academicID = checkAcademicID($_SERVER['authAPM']);
              if($academicID['registered']) {
                echo  $academicID['academicIdData']['acid'];
              } else {
                echo "<b>Δεν βρέθηκε καταχώρηση</b>";
              }
            }else{
              echo '-';
            }
        ?></td>
      </tr>
      <tr>
        <td>Συγγράμματα (ΕΥΔΟΞΟΣ):</td>
        <td><a target="_blank" href="http://service.eudoxus.gr/student/" >Δήλωση</a></td>
      </tr>
      <tr>
        <?php
          echo "<td>Σίτιση:</td>";
          if(isset($_SERVER['authAPM'])){
            $dining = checkDining($_SERVER['authAPM']);
            if($dining['reg']){
                echo '<td>Εγγεγραμμένος/η στη λέσχη</td>';
            }else{
                echo '<td>Δεν είναι εγγεγγραμμένος στη λέσχη</td>';
            }
          }else{
            echo '<td>-</td>';
          }
        ?>
      </tr>
      <tr>
        <?php
            echo '<td>Γυμναστήριο:</td>';
            if(isset($_SERVER['authAPM'])){
			      $gym = checkGym($_SERVER['authAPM']);

                if(strcmp($gym['gymReg'], "No registration data available") == 0){
                echo '<td><a target="_blank" href="http://gym.web.auth.gr/el/node/5572" >Εγγραφή</a></td>';
                }else if(strcmp($gym['gymReg'], "Registered") == 0){
                 echo '<td>Έχει πραγματοποιηθεί εγγραφή.</td>';
                }else if(strcmp($gym['gymReg'], "Registration has expired") == 0){
                 echo '<td><a target="_blank" href="http://gym.web.auth.gr/el/node/5572" title="Εγγραφή">Η εγγραφή έχει λήξει</a></td>';
                }
            }else{
              echo '<td>-</td>';
            }
        ?>
      </tr>

      <?php
        function checkDining($apm){
      	$url = "localhost:3000/diningStatus/" . $apm;

      	$ch = curl_init($url);

      	//set curl options
      	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

      	//to be removed
      	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      	curl_setopt($ch, CURLOPT_VERBOSE, 0);

      	$response = curl_exec($ch);
      	curl_close($ch);
      	$result = json_decode($response, true);

      	return $result;
        }

        function checkAcademicID($apm) {
		      $url = "localhost:3000/academicIdRegistered/". $apm;

        	$ch = curl_init($url);

        	//set curl options
        	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        	//to be removed
        	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        	curl_setopt($ch, CURLOPT_VERBOSE, 0);

        	$response = curl_exec($ch);
        	curl_close($ch);
        	$result = json_decode($response, true);

        	return $result;
        }

        function checkGym($apm) {
        	$url = "localhost:3000/gymStatus/" . $apm;

        	$ch = curl_init($url);

        	//set curl options
        	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        	//to be removed
        	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        	curl_setopt($ch, CURLOPT_VERBOSE, 0);

        	$response = curl_exec($ch);
        	curl_close($ch);
        	$result = json_decode($response, true);

        	return $result;
        }
	      ?>
  </table>

</body>
</html>
