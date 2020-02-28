<?php

//$r_ko_n = mysqli_real_escape_string($con, trim($request->receiverAddress->komu->name));
//$r_ko_s = mysqli_real_escape_string($con, trim($request->receiverAddress->komu->surname));
//$r_ko_o = mysqli_real_escape_string($con, trim($request->receiverAddress->komu->otchestvo));

$r_ko_n = "Имя";
$r_ko_s = "Фамилия";
$r_ko_o = "Отчество";
//
//$r_ku_st = mysqli_real_escape_string($con, trim($request->receiverAddress->kuda->streetType));
////обрабатывать тип улицы (передаётся enum)
//$r_ku_sn = mysqli_real_escape_string($con, trim($request->receiverAddress->kuda->streetName));
//$r_ku_noh = mysqli_real_escape_string($con, trim($request->receiverAddress->kuda->numberOfHouse));
//$r_ku_nok = mysqli_real_escape_string($con, trim($request->receiverAddress->kuda->numberOfKorpus));
//$r_ku_nof = mysqli_real_escape_string($con, trim($request->receiverAddress->kuda->numberOfFlat));
//
//$r_index = mysqli_real_escape_string($con, trim($request->receiverAddress->index));
//
//$r_npn_o = mysqli_real_escape_string($con, trim($request->receiverAddress->nasPunktName->oblast));
//$r_npn_r = mysqli_real_escape_string($con, trim($request->receiverAddress->nasPunktName->region));
//$r_npn_tn = mysqli_real_escape_string($con, trim($request->receiverAddress->nasPunktName->townName));
//$r_npn_tot = mysqli_real_escape_string($con, trim($request->receiverAddress->nasPunktName->typeOfTown));
//
//$o_ok_n = mysqli_real_escape_string($con, trim($request->otpravitelAddress->otKogo->name));
//$o_ok_s = mysqli_real_escape_string($con, trim($request->otpravitelAddress->otKogo->surname));
//$o_ok_o = mysqli_real_escape_string($con, trim($request->otpravitelAddress->otKogo->otchestvo));
//
//$o_a_o = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->oblast));
//$o_a_r = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->region));
//$o_a_tn = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->townName));
//$o_a_tot = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->typeOfTown));
//
//$o_a_st = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->streetType));
//$o_a_sn = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->streetName));
//$o_a_noh = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->numberOfHouse));
//$o_a_nok = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->numberOfKorpus));
//$o_a_nof = mysqli_real_escape_string($con, trim($request->otpravitelAddress->adress->numberOfFlat));
//
//$dateAndTimeOfStartWay = mysqli_real_escape_string($con, (int)$request->dateAndTimeOfStartWay);
// подключаем шрифты
//define('FPDF_FONTPATH',"fpdf/font/");
// подключаем библиотеку
//require('fpdf/fpdf.php');
require_once( "../fpdf/fpdf.php" );
// создаем PDF документ

$pdf = new FPDF( 'L', 'mm', 'A4' );

$pdf->AddPage();

//$pdf=new FPDF();
//// устанавливаем заголовок документа
$pdf->SetTitle("Скачать PDF письма", true);

//// создаем страницу
//$pdf->AddPage('L');
//$pdf->SetDisplayMode(real,'default');

// добавляем шрифт ариал
$pdf->AddFont('Arial','','arial.php');
// устанавливаем шрифт Ариал
$pdf->SetFont('Arial');
// устанавливаем цвет шрифта
//$pdf->SetTextColor(250,60,100);
// устанавливаем размер шрифта
$pdf->SetFontSize(6);

// добавляем текст
$pdf->SetXY(140,75);
$pdf->Write(0,iconv('utf-8', 'windows-1251', $r_ko_n));

$pdf->SetXY(140,82);
$pdf->Write(0,iconv('utf-8', 'windows-1251',$r_ko_s));

$pdf->SetXY(175,82);
$pdf->Write(0,iconv('utf-8', 'windows-1251',$r_ko_o));




// выводим документа в браузере
$pdf->Output('letter.pdf','I');



//require_once( "../fpdf/fpdf.php" );
//
//// Начало конфигурации
//
//$textColour = array( 0, 0, 0 );
//$headerColour = array( 100, 100, 100 );
//$tableHeaderTopTextColour = array( 255, 255, 255 );
//$tableHeaderTopFillColour = array( 125, 152, 179 );
//$tableHeaderTopProductTextColour = array( 0, 0, 0 );
//$tableHeaderTopProductFillColour = array( 143, 173, 204 );
//$tableHeaderLeftTextColour = array( 99, 42, 57 );
//$tableHeaderLeftFillColour = array( 184, 207, 229 );
//$tableBorderColour = array( 50, 50, 50 );
//$tableRowFillColour = array( 213, 170, 170 );
//$reportName = "привет";
//$reportNameYPos = 160;
//$logoFile = "widget-company-logo.png";
//$logoXPos = 50;
//$logoYPos = 108;
//$logoWidth = 110;
//$columnLabels = array( "Q1", "Q2", "Q3", "Q4" );
//$rowLabels = array( "SupaWidget", "WonderWidget", "MegaWidget", "HyperWidget" );
//$chartXPos = 20;
//$chartYPos = 250;
//$chartWidth = 160;
//$chartHeight = 80;
//$chartXLabel = "Product";
//$chartYLabel = "2009 Sales";
//$chartYStep = 20000;
//
//$chartColours = array(
//                  array( 255, 100, 100 ),
//                  array( 100, 255, 100 ),
//                  array( 100, 100, 255 ),
//                  array( 255, 255, 100 ),
//                );
//
//$data = array(
//          array( 9940, 10100, 9490, 11730 ),
//          array( 19310, 21140, 20560, 22590 ),
//          array( 25110, 26260, 25210, 28370 ),
//          array( 27650, 24550, 30040, 31980 ),
//        );
//
//// Конец конфигурации
//
//
////  Создаем титульную страницу
//
//
//$pdf = new FPDF( 'P', 'mm', 'A4' );
//
//
//
//$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
//
//
//$pdf->AddPage();
//
//
//
//// Название отчета
////$pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);
////$pdf->SetFont('DejaVu','B',12);
////$pdf->SetFont( 'Arial', 'B', 24 );
//// добавляем шрифт ариал
//$pdf->AddFont('Arial','','arial.php');
//// устанавливаем шрифт Ариал
//$pdf->SetFont('Arial');
//
//
//$pdf->Ln( $reportNameYPos );
//
//
////$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
//
//// добавляем текст
//$pdf->SetXY(10,10);
//$pdf->Write(0,iconv('utf-8', 'windows-1251',$reportName));
//
//
//
//
///***
//  Выводим PDF
//***/
//
//
//
//$pdf->Output( "report.pdf", "I" );

?>



