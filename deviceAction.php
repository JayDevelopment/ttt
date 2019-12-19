<?php
if($_REQUEST['action'] == 'search') {
    require_once 'Devices.class.php';
    $device = new Devices;
    $device->number = $_GET['device_number'];
    $device->search = $_GET['device_search'];
    
    /*if ($device->number != '') {
    $sql = "SELECT device_id, device_name, device_manufacturer
    FROM $device->table_name
    WHERE device_id = '{$device->number}' LIMIT 1";
    //echo $sql;
    }
    elseif ($device->search != '') {
    $device->check_string_length($device->search);
    $sql = "SELECT device_id, device_name, device_manufacturer
    FROM $device->table_name
    WHERE device_name LIKE '{$device->search}%' LIMIT 50";
    //echo $sql;
} else {
    echo $device->died('*error');
}*/
$device->read();
$rows = array();
if (mysqli_num_rows($device->result) > 0) {
    while($row=result_db1($device->result)) {
        $subArray[device_id]="<a href='viewArticles.php?device_number={$row["device_id"]}&device_search=$device->search' target='_blank'>{$row["device_id"]}</a>";
        $subArray[device_name]=$row['device_name'];
        $subArray[device_manufacturer]=$row['device_manufacturer'];
        #$subArray[image]="<img src='images/{$row['image']}'>";
        $rows[] = $subArray;
        #echo $row['image'];
    }
    print json_encode($rows);
} /*else  {
    $device->validate($device->number, $device->search, $device->result);
} */
} if ($_REQUEST['action'] == 'create') {
    require_once 'Devices.class.php';
    $device = new Devices;
    
    $device_name = $device->test_data($_REQUEST['device_name']);
    $device_manufacturer = $device->test_data($_REQUEST['device_manufacturer']);
    $articles = $device->test_data($_REQUEST['articles']);
    //var_dump($_REQUEST['articles']);
    //var_dump($articles);
    if(preg_match('/^[\w]+\s?[0-9]*?\\.?[0-9]*?$/', $device_name) && 
        preg_match('/^[\w]+\s?[0-9]*?\\.?[0-9]*?$/', $device_manufacturer) && 
        preg_match('/^[1-9,]+$/', $articles)) 
    {
        $articles = explode(',', $articles);
        //var_dump($articles);
        $device->create($device_name, $device_manufacturer, $articles);
        $device->dieMessage('text-success', 'Device Created');
    } else {
          $device->dieMessage('text-danger','*Please insert valid data');
      } 
 
}
?>