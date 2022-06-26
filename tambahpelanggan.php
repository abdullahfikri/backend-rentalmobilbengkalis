<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include_once "connection.php";
header("Content-Type: application/json; charset=UTF-8");

$nama = $_POST['nama'];
$kelamin = $_POST['kelamin'];
$nik = $_POST['nik'];
$nomor_telp = $_POST['nomorTelp'];
$alamat = $_POST['alamat'];

$response = [];
try {

    if (trim($nama) !='' && trim($kelamin) !='' && trim($nik) != '' && trim($nomor_telp) != '' && trim($alamat) != ''){

        // UPLOAD IMAGE BEGIN
        $target_dir = "images/";
        $target_file = $target_dir .rand(999,9999). basename($_FILES['image']["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
         // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES['image']["tmp_name"]);
        if($check !== false ) {
             // move file img to server folder
            if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
                 // Menyambung url
                $ip_server = 'https://rentalmobilbengkalis.000webhostapp.com/';
                $folder_root = 'rentalmobil/';
                $url = $ip_server.$folder_root.$target_file;


                $sql = "INSERT INTO `pelanggan`(`nama`, `kelamin`, `nik`, `nomor_telp`, `alamat`, `url_image`) VALUES ('$nama','$kelamin','$nik','$nomor_telp','$alamat', '$url')";

                $execute = mysqli_query($dbConnection, $sql);
                
                if ($execute){
                    $response["status"] = "sukses";
                    $response["message"] = "Berhasil menambah data pelanggan";
                } else {
                    $response["status"] = "failed";
                    $response["message"] = "Gagal menambah data pelanggan";
                    $response["data"] = $row;
                }

            } else {
                    $response["status"] = "failed";
                    $response["message"] = "Gagal mengupload file";
            }

        }
        else {
                    $response["status"] = "failed";
                    $response["message"] = "Mohon upload image";
        }
    } else {
        $response["status"] = "failed";
        $response["message"] = "Data tidak boleh kosong";
    }

}catch (mysqli_sql_exception $exception){
    $response['status'] = 'failed';
    $response["message"] = 'Gagal terhubung ke server';
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;