<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);


  // Validate.
  if(
    trim($request->hash) === '' ||
    trim($request->receiverAddress->komu->name) === '' ||
    trim($request->receiverAddress->komu->surname) === '' ||
    trim($request->receiverAddress->komu->otchestvo) === '' // ||
    // trim() === ''
  ) {
    return http_response_code(400);
  }

  // Sanitize.
  $hash = mysqli_real_escape_string($con, trim($request->hash));
  $status = mysqli_real_escape_string($con, trim($request->status));

  $isMejdunarond = mysqli_real_escape_string($con, trim($request->isMejdunarond));

  $r_ko_n = mysqli_real_escape_string($con, trim($request->receiverAddress->komu->name));
  $r_ko_s = mysqli_real_escape_string($con, trim($request->receiverAddress->komu->surname));
  $r_ko_o = mysqli_real_escape_string($con, trim($request->receiverAddress->komu->otchestvo));

  $r_ku_st = mysqli_real_escape_string($con, trim($request->receiverAddress->kuda->streetType));
  $r_ku_sn = mysqli_real_escape_string($con, trim($request->receiverAddress->kuda->streetName));
  $r_ku_noh = mysqli_real_escape_string($con, trim($request->receiverAddress->kuda->numberOfHouse));
  $r_ku_nok = mysqli_real_escape_string($con, trim($request->receiverAddress->kuda->numberOfKorpus));
  $r_ku_nof = mysqli_real_escape_string($con, trim($request->receiverAddress->kuda->numberOfFlat));

  $r_index = mysqli_real_escape_string($con, trim($request->receiverAddress->index));

  $r_npn_o = mysqli_real_escape_string($con, trim($request->receiverAddress->nasPunktName->oblast));
  $r_npn_r = mysqli_real_escape_string($con, trim($request->receiverAddress->nasPunktName->region));
  $r_npn_tn = mysqli_real_escape_string($con, trim($request->receiverAddress->nasPunktName->townName));
  $r_npn_tot = mysqli_real_escape_string($con, trim($request->receiverAddress->nasPunktName->typeOfTown));

  $o_ok_n = mysqli_real_escape_string($con, trim($request->otpravitelAddress->otKogo->name));
  $o_ok_s = mysqli_real_escape_string($con, trim($request->otpravitelAddress->otKogo->surname));
  $o_ok_o = mysqli_real_escape_string($con, trim($request->otpravitelAddress->otKogo->otchestvo));

  $o_a_o = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->oblast));
  $o_a_r = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->region));
  $o_a_tn = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->townName));
  $o_a_tot = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->typeOfTown));

  $o_a_st = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->streetType));
  $o_a_sn = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->streetName));
  $o_a_noh = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->numberOfHouse));
  $o_a_nok = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->numberOfKorpus));
  $o_a_nof = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->numberOfFlat));

  $dateAndTimeOfStartWay = mysqli_real_escape_string($con, (int)$request->dateAndTimeOfStartWay);

  // Create.
  $sql = "INSERT INTO `letters`(`id`,`hash`,`status`, `isMejdunarond`, `r_ko_n`, `r_ko_s`, `r_ko_o`, `r_ku_st`, `r_ku_sn`, `r_ku_noh`, `r_ku_nok`, `r_ku_nof`, `r_index`, `r_npn_o`, `r_npn_r`, `r_npn_tn`, `r_npn_tot`, `o_ok_n`, `o_ok_s`, `o_ok_o`, `o_a_o`, `o_a_r`, `o_a_tn`, `o_a_tot`, `o_a_st`, `o_a_sn`, `o_a_noh`, `o_a_nok`, `o_a_nof`, `dateAndTimeOfStartWay`) VALUES (null,'{$hash}','{$status}','{$isMejdunarond}','{$r_ko_n}','{$r_ko_s}','{$r_ko_o}','{$r_ku_st}','{$r_ku_sn}','{$r_ku_noh}','{$r_ku_nok}','{$r_ku_nof}','{$r_index}','{$r_npn_o}','{$r_npn_r}','{$r_npn_tn}','{$r_npn_tot}','{$o_ok_n}','{$o_ok_s}','{$o_ok_o}','{$o_a_o}','{$o_a_r}','{$o_a_tn}','{$o_a_tot}','{$o_a_st}','{$o_a_sn}','{$o_a_noh}','{$o_a_nok}','{$o_a_nof}','{$dateAndTimeOfStartWay}')";
  // create table policies( id int not null auto_increment, number varchar(20), amount float, primary key(id));

/*

create table letters( id int not null auto_increment,
hash varchar(200),
status varchar(200),
isMejdunarond varchar(200),
r_ko_n varchar(200),
r_ko_s varchar(200),
r_ko_o varchar(200),
r_ku_st varchar(200),
r_ku_sn varchar(200),
r_ku_noh varchar(200),
r_ku_nok varchar(200),
r_ku_nof varchar(200),
r_index varchar(200),
r_npn_o varchar(200),
r_npn_r varchar(200),
r_npn_tn varchar(200),
r_npn_tot varchar(200),
o_ok_n varchar(200),
o_ok_s varchar(200),
o_ok_o varchar(200),
o_a_o varchar(200),
o_a_r varchar(200),
o_a_tn varchar(200),
o_a_tot varchar(200),
o_a_st varchar(200),
o_a_sn varchar(200),
o_a_noh varchar(200),
o_a_nok varchar(200),
o_a_nof varchar(200),
dateAndTimeOfStartWay float,
primary key(id))

*/

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $id = mysqli_insert_id($con);

    $letter = $actual_link . "/../downloadPDF.php?id=" . $id;
    echo json_encode($letter);
  }
  else
  {
    http_response_code(422);
  }
}
