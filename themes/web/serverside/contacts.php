<?php


try {
    $conn = new PDO('mysql:host=10.23.237.79;dbname=siegcinfo', 'smsubcoti', 'U4cKZ_NI0*2UeSHs');
    $stmt = $conn->prepare("SELECT contacts.contact_name, churchs.unit_name, contacts.ramal FROM contacts
    LEFT JOIN churchs ON contacts.unit_id = churchs.id
    WHERE contacts.status Like 'actived'");
    $stmt->execute();

    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    echo serialize($result);

  
  } catch(PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
  }


?>