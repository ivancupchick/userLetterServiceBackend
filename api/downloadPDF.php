<?php
require 'database.php';
require_once("../fpdf/fpdf.php");

$letter = [];

$id = ($_GET['id'] !== null && (int)$_GET['id'] > -1) ? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if ($id === false) {
    return http_response_code(400);
}

$sql = "SELECT * FROM letters WHERE `id` = $id LIMIT 1";

//$sql = "SELECT * FROM letters WHERE `id` = '{$id}' LIMIT 1";
//временно указал id равным 1 для теста, позже его придётся передавать
//$sql = "SELECT id, number, amount FROM policies";

function writeOnPdf(FPDF $pdf, string $text, int $x, int $y)
{
    $pdf->SetXY($x, $y);
    $pdf->Write(0, iconv('utf-8', 'windows-1251', $text));
}


if ($result = mysqli_query($con, $sql)) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
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

    $pdf = new FPDF('L', 'mm', 'A4');

    $pdf->AddPage();

//$pdf=new FPDF();
//// устанавливаем заголовок документа
    $pdf->SetTitle("Скачать PDF письма", true);

//// создаем страницу
//$pdf->AddPage('L');
//$pdf->SetDisplayMode(real,'default');

// добавляем шрифт ариал
    $pdf->AddFont('Arial', '', 'arial.php');
// устанавливаем шрифт Ариал
    $pdf->SetFont('Arial');
// устанавливаем цвет шрифта
//$pdf->SetTextColor(250,60,100);
// устанавливаем размер шрифта
    $pdf->SetFontSize(12);

// добавляем текст

    //1
    writeOnPdf($pdf, $letter['receiverAddress']['komu']['surname'], 140, 77);

    //2
    writeOnPdf($pdf, $letter['receiverAddress']['komu']['name'], 140, 84);

    writeOnPdf($pdf, $letter['receiverAddress']['komu']['otchestvo'], 175, 84);

    //3
    writeOnPdf($pdf, $letter['receiverAddress']['nasPunktName']['oblast'], 140, 91);

    writeOnPdf($pdf, "обл.", 205, 91);

    //4
    writeOnPdf($pdf, $letter['receiverAddress']['nasPunktName']['region'], 140, 98);

    writeOnPdf($pdf, "р-н", 205, 98);

    //5 индекс
    writeOnPdf($pdf, $letter['receiverAddress']['index'], 140, 105);

    writeOnPdf($pdf, $letter['receiverAddress']['nasPunktName']['typeOfTown'], 171, 105);

    writeOnPdf($pdf, $letter['receiverAddress']['nasPunktName']['townName'], 180, 105);

    //6
    writeOnPdf($pdf, $letter['receiverAddress']['kuda']['streetType'], 140, 112);

    writeOnPdf($pdf, $letter['receiverAddress']['kuda']['streetName'], 150, 112);

    writeOnPdf($pdf, $letter['receiverAddress']['kuda']['numberOfHouse'], 185, 112);

    writeOnPdf($pdf, $letter['receiverAddress']['kuda']['numberOfKorpus'], 295, 112);

    writeOnPdf($pdf, $letter['receiverAddress']['kuda']['numberOfFlat'], 205, 112);


//    $pdf->Ln(4);                    //Break

    //рамка
    $pdf->Line(10, 10, 230, 10);  //Set the line
    $pdf->Line(230, 10, 230, 120);  //Set the line
    $pdf->Line(230, 120, 10, 120);  //Set the line
    $pdf->Line(10, 120, 10, 10);  //Set the line

    //верхий левый угол - линии
    $pdf->Line(20, 22 + 2, 90, 22 + 2);
    $pdf->Line(20, 29 + 2, 90, 29 + 2);
    $pdf->Line(20, 36 + 2, 90, 36 + 2);
    $pdf->Line(20, 43 + 2, 90, 43 + 2);
    $pdf->Line(20, 50 + 2, 90, 50 + 2);

    //правый нижний угол - линии

    $pdf->Line(140, 77 + 2, 220, 77 + 2);
    $pdf->Line(140, 84 + 2, 220, 84 + 2);
    $pdf->Line(140, 91 + 2, 220, 91 + 2);
    $pdf->Line(140, 98 + 2, 220, 98 + 2);
    $pdf->Line(140, 105 + 2, 220, 105 + 2);
    $pdf->Line(140, 112 + 2, 220, 112 + 2);




    //вержний левый угол

    //1
    writeOnPdf($pdf, $letter['otpravitelAddress']['otKogo']['surname'], 20, 22);

    //2
    writeOnPdf($pdf, $letter['otpravitelAddress']['otKogo']['name'], 20, 29);

    writeOnPdf($pdf, $letter['otpravitelAddress']['otKogo']['otchestvo'], 55, 29);

    //3
    writeOnPdf($pdf, $letter['otpravitelAddress']['adress']['oblast'], 20, 36);

    writeOnPdf($pdf, "обл.", 80, 36);

    //4
    writeOnPdf($pdf, $letter['otpravitelAddress']['adress']['region'], 20, 43);

    writeOnPdf($pdf, $letter['otpravitelAddress']['adress']['typeOfTown'], 45, 43);

    writeOnPdf($pdf, $letter['otpravitelAddress']['adress']['townName'], 55, 43);

    //5
    writeOnPdf($pdf, $letter['otpravitelAddress']['adress']['streetType'], 20, 50);

    writeOnPdf($pdf, $letter['otpravitelAddress']['adress']['streetName'], 30, 50);

    writeOnPdf($pdf, $letter['otpravitelAddress']['adress']['numberOfHouse'], 65, 50);

    writeOnPdf($pdf, $letter['otpravitelAddress']['adress']['numberOfKorpus'], 75, 50);

    writeOnPdf($pdf, $letter['otpravitelAddress']['adress']['numberOfFlat'], 85, 50);

//индекс отправителя забыли в бд

    $value = "1";
    $pdf->Image('http://chart.apis.google.com/chart?cht=qr&chs=350x350&chl=' . $value . '.png', 47, 65, 45);


    // конец PDF


    $pdf->Output('letter.pdf', 'I');
} else {
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
//writeOnPdf($pdf, $r_ko_n));
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
