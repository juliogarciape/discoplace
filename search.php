<?php 

function getGps($exifCoord, $hemi) {
    $degrees = count($exifCoord) > 0 ? gps2Num($exifCoord[0]) : 0;
    $minutes = count($exifCoord) > 1 ? gps2Num($exifCoord[1]) : 0;
    $seconds = count($exifCoord) > 2 ? gps2Num($exifCoord[2]) : 0;
    $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
    return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
}

function gps2Num($coordPart) {
    $parts = explode('/', $coordPart);
    if (count($parts) <= 0) return 0;
    if (count($parts) == 1) return $parts[0];
    return floatval($parts[0]) / floatval($parts[1]);
}


if(!empty($_FILES['photo']['name'])){
    
    $filename = $_FILES['photo']['tmp_name'];
    $exif = exif_read_data($filename);

    if(isset($exif['GPSLongitude']) && isset($exif['GPSLongitudeRef']) && isset($exif['GPSLatitude']) && isset($exif['GPSLatitudeRef'])){

        $lon = getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
        $lat = getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
        echo json_encode(array('status' => True,"lat" => $lat, "lon" => $lon));

    }else{
        echo json_encode(array('status' => False, "message" => "Esta imagen no registra ubicacion (metadatos no encontrados)"));
    }
    
} else{
    echo "Error 401";
}

?>