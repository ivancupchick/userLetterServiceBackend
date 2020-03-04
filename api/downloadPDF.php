<?php
require 'database.php';
require_once( "../fpdf/fpdf.php" );

$letter = [];
$sql = "SELECT * FROM letters WHERE `id` = '1' LIMIT 1";

//$sql = "SELECT * FROM letters WHERE `id` = '{$id}' LIMIT 1";
//временно указал id равным 1 для теста, позже его придётся передавать
//$sql = "SELECT id, number, amount FROM policies";


if($result = mysqli_query($con,$sql))
{
    $i = 0;
    while($row = mysqli_fetch_assoc($result))
    {
//        $letter['hash'] = $row['hash'];
//        $letter['status'] = $row['status'];

//        $letter['isMejdunarond'] = $row['isMejdunarond'];

        //нижний правый угол
        $letter['receiverAddress']['komu']['name'] = $row['r_ko_n'];
        $letter['receiverAddress']['komu']['surname'] = $row['r_ko_s'];
        $letter['receiverAddress']['komu']['otchestvo'] = $row['r_ko_o'];


        $letter['receiverAddress']['kuda']['streetType'] = $row['r_ku_st'];
        //нужно сделать обработку вида улицы или изменить данные в БД
        $letter['receiverAddress']['kuda']['streetName'] = $row['r_ku_sn'];
        $letter['receiverAddress']['kuda']['numberOfHouse'] = $row['r_ku_noh'];
        $letter['receiverAddress']['kuda']['numberOfKorpus'] = $row['r_ku_nok'];
        $letter['receiverAddress']['kuda']['numberOfFlat'] = $row['r_ku_nof'];

        $letter['receiverAddress']['index'] = $row['r_index'];

        $letter['receiverAddress']['nasPunktName']['oblast'] = $row['r_npn_o'];
        $letter['receiverAddress']['nasPunktName']['region'] = $row['r_npn_r'];
        $letter['receiverAddress']['nasPunktName']['townName'] = $row['r_npn_tn'];
        $letter['receiverAddress']['nasPunktName']['typeOfTown'] = $row['r_npn_tot'];


        //вержний левый угол
        $letter['otpravitelAddress']['otKogo']['name'] = $row['o_ok_n'];
        $letter['otpravitelAddress']['otKogo']['surname'] = $row['o_ok_s'];
        $letter['otpravitelAddress']['otKogo']['otchestvo'] = $row['o_ok_o'];

        $letter['otpravitelAddress']['adress']['oblast'] = $row['o_a_o'];
        $letter['otpravitelAddress']['adress']['region'] = $row['o_a_r'];
        $letter['otpravitelAddress']['adress']['townName'] = $row['o_a_tn'];
        $letter['otpravitelAddress']['adress']['typeOfTown'] = $row['o_a_tot'];

        $letter['otpravitelAddress']['adress']['streetType'] = $row['o_a_st'];
        $letter['otpravitelAddress']['adress']['streetName'] = $row['o_a_sn'];
        $letter['otpravitelAddress']['adress']['numberOfHouse'] = $row['o_a_noh'];
        $letter['otpravitelAddress']['adress']['numberOfKorpus'] = $row['o_a_nok'];
        $letter['otpravitelAddress']['adress']['numberOfFlat'] = $row['o_a_nof'];
//
//        $letter['dateAndTimeOfStartWay'] = $row['dateAndTimeOfStartWay'];

        $i++;
    }

    // начало PDF

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
    $pdf->SetFontSize(12);

// добавляем текст

    //1
    $pdf->SetXY(140,77);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['komu']['surname'] ));

    //2
    $pdf->SetXY(140,84);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['komu']['name']));

    $pdf->SetXY(175,84);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['komu']['otchestvo']));

    //3
    $pdf->SetXY(140,91);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['nasPunktName']['oblast']));

    $pdf->SetXY(205,91);
    $pdf->Write(0,iconv('utf-8', 'windows-1251',  "обл."));

    //4
    $pdf->SetXY(140,98);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['nasPunktName']['region']));

    $pdf->SetXY(205,98);
    $pdf->Write(0,iconv('utf-8', 'windows-1251',  "р-н"));

    //5 индекс
    $pdf->SetXY(140,105);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['index']));

    $pdf->SetXY(171,105);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['nasPunktName']['typeOfTown']));

    $pdf->SetXY(180,105);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['nasPunktName']['townName']));

    //6
    $pdf->SetXY(140,112);
    $pdf->Write(0,iconv('utf-8', 'windows-1251',$letter['receiverAddress']['kuda']['streetType']));

    $pdf->SetXY(150,112);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['kuda']['streetName']));

    $pdf->SetXY(185,112);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['kuda']['numberOfHouse']));

    $pdf->SetXY(295,112);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['kuda']['numberOfKorpus']));

    $pdf->SetXY(205,112);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['receiverAddress']['kuda']['numberOfFlat']));


//    $pdf->Ln(4);                    //Break
    $pdf->Line(10, 10, 230, 10);  //Set the line
    $pdf->Line(230, 10, 230, 120);  //Set the line
    $pdf->Line(230, 120, 10, 120);  //Set the line
    $pdf->Line(10, 120, 10, 10);  //Set the line


//    $pdf->Ln(4);
    //вехний левый угол


    //вержний левый угол

    //1
    $pdf->SetXY( 20, 22);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['otpravitelAddress']['otKogo']['surname']));

    //2
    $pdf->SetXY( 20, 29);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['otpravitelAddress']['otKogo']['name']));

    $pdf->SetXY( 55, 29);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['otpravitelAddress']['otKogo']['otchestvo']));

    //3
    $pdf->SetXY( 20, 36);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['otpravitelAddress']['adress']['oblast']));

    $pdf->SetXY( 80, 36);
    $pdf->Write(0,iconv('utf-8', 'windows-1251',  "обл."));

    //4
    $pdf->SetXY( 20, 43);
    $pdf->Write(0,iconv('utf-8', 'windows-1251', $letter['otpravitelAddress']['adress']['region']));

    $pdf->SetXY( 45, 43);
    $pdf->Write(0,iconv('utf-8', 'windows-1251',  $letter['otpravitelAddress']['adress']['typeOfTown']));

    $pdf->SetXY( 55, 43);
    $pdf->Write(0,iconv('utf-8', 'windows-1251',  $letter['otpravitelAddress']['adress']['townName']));

    //5
    $pdf->SetXY( 20, 50);
    $pdf->Write(0,iconv('utf-8', 'windows-1251',  $letter['otpravitelAddress']['adress']['streetType']));

    $pdf->SetXY( 30, 50);
    $pdf->Write(0,iconv('utf-8', 'windows-1251',  $letter['otpravitelAddress']['adress']['streetName']));

    $pdf->SetXY( 65, 50);
    $pdf->Write(0,iconv('utf-8', 'windows-1251',  $letter['otpravitelAddress']['adress']['numberOfHouse']));

    $pdf->SetXY( 75, 50);
    $pdf->Write(0,iconv('utf-8', 'windows-1251',   $letter['otpravitelAddress']['adress']['numberOfKorpus']));

    $pdf->SetXY( 85, 50);
    $pdf->Write(0,iconv('utf-8', 'windows-1251',   $letter['otpravitelAddress']['adress']['numberOfFlat']));

//индекс отправителя забыли в бд




    // конец PDF


    $pdf->Output('letter.pdf','I');
}
else
{
    http_response_code(404);
}

//$dateAndTimeOfStartWay = mysqli_real_escape_string($con, (int)$request->dateAndTimeOfStartWay);
// подключаем шрифты
//define('FPDF_FONTPATH',"fpdf/font/");
// подключаем библиотеку
//require('fpdf/fpdf.php');
//require_once( "../fpdf/fpdf.php" );
//// создаем PDF документ
//
//$pdf = new FPDF( 'L', 'mm', 'A4' );
//
//$pdf->AddPage();
//
////$pdf=new FPDF();
////// устанавливаем заголовок документа
//$pdf->SetTitle("Скачать PDF письма", true);
//
////// создаем страницу
////$pdf->AddPage('L');
////$pdf->SetDisplayMode(real,'default');
//
//// добавляем шрифт ариал
//$pdf->AddFont('Arial','','arial.php');
//// устанавливаем шрифт Ариал
//$pdf->SetFont('Arial');
//// устанавливаем цвет шрифта
////$pdf->SetTextColor(250,60,100);
//// устанавливаем размер шрифта
//$pdf->SetFontSize(6);
//
//// добавляем текст
//$pdf->SetXY(140,75);
//$pdf->Write(0,iconv('utf-8', 'windows-1251', $r_ko_n));
//
//$pdf->SetXY(140,82);
//$pdf->Write(0,iconv('utf-8', 'windows-1251',$r_ko_s));
//
//$pdf->SetXY(175,82);
//$pdf->Write(0,iconv('utf-8', 'windows-1251',$r_ko_o));
//
//
//
//
//// выводим документа в браузере
//$pdf->Output('letter.pdf','I');
//


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



