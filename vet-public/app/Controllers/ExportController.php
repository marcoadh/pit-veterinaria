<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Shared\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Controllers;
use App\Models\Ollas;
use App\Models\Junta;
use App\Models\Distritos;

Class ExportController extends Controller {
    
    

    public function ExporTotal($request, $response, $args) {

        $data = Ollas::select('tb_ollas_excel.*', 'tb_distritos.distrito as nomdis')
                        ->join('tb_distritos', 'tb_ollas_excel.distrito', '=', 'tb_distritos.idDist')
                        ->where('tb_ollas_excel.estado', '=', 2)
                        ->orderBy('tb_ollas_excel.id', 'ASC')->get();

        $styleArray = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $styleArrayHead = [
            'font' => [
                'bold' => true,
                'size' => 13,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $spreadsheet = new Spreadsheet();


        $sheet = $spreadsheet->getActiveSheet();

         $sheet->setCellValue('A1', 'Distrito ')->getColumnDimension('A')->setWidth(40);
        $sheet->setCellValue('B1', 'Zona/Eje')->getColumnDimension('B')->setWidth(30);
        $sheet->setCellValue('C1', 'AAHH')->getColumnDimension('C')->setWidth(40);
        $sheet->setCellValue('D1', '¿Dónde se ubica la olla común?')->getColumnDimension('D')->setWidth(50);
        $sheet->setCellValue('E1', 'Nombre de la olla común')->getColumnDimension('E')->setWidth(50);
        $sheet->setCellValue('F1', '¿Cuentan con padrones?')->getColumnDimension('F')->setWidth(25);
        $sheet->setCellValue('G1', 'Cuentan con Comedor Popular/Vaso de Leche')->getColumnDimension('G')->setWidth(25);
        
        $sheet->setCellValue('H1', '¿Cuentan con Comité anticovid o articulan con MINSA?')->getColumnDimension('H')->setWidth(25);
        $sheet->setCellValue('I1', 'Nombre de contacto principal')->getColumnDimension('I')->setWidth(25);
        $sheet->setCellValue('J1', 'Cargo de contacto principal*')->getColumnDimension('J')->setWidth(25);
        $sheet->setCellValue('K1', 'Celular de contacto principal')->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('L1', 'Nombre de contacto secundario')->getColumnDimension('L')->setWidth(40);
        $sheet->setCellValue('M1', 'Cargo de contacto secundario')->getColumnDimension('M')->setWidth(25);
        $sheet->setCellValue('N1', 'Celular de contacto secundario')->getColumnDimension('N')->setWidth(45);
        $sheet->setCellValue('O1', 'Acceso a agua')->getColumnDimension('O')->setWidth(25);
        $sheet->setCellValue('P1', 'Acceso a luz')->getColumnDimension('P')->setWidth(30);
        
        $sheet->setCellValue('Q1', '¿Cuenta con la presencia de la Municipalidad distrital ?')->getColumnDimension('Q')->setWidth(35);
        $sheet->setCellValue('R1', 'Tipo de espacio usado para la olla común')->getColumnDimension('R')->setWidth(35);

        $sheet->setCellValue('S1', 'Estado del espacio usado para la olla común')->getColumnDimension('S')->setWidth(25);
        $sheet->setCellValue('T1', 'Tipo de combustible usado para la olla común')->getColumnDimension('T')->setWidth(25);
        $sheet->setCellValue('U1', 'En el espacio de la olla común cuentan con: ¿Techo en buen estado?')->getColumnDimension('U')->setWidth(25);
        $sheet->setCellValue('V1', 'En el espacio de la olla común cuentan con: ¿Punto de lavado?')->getColumnDimension('V')->setWidth(25);
        $sheet->setCellValue('W1', '¿Reciben o cuentan con KITS de Higiene?')->getColumnDimension('W')->setWidth(25);
        $sheet->setCellValue('X1', '¿Cuenta con los equipos e instrumentos necesarios para implementar la olla?')->getColumnDimension('X')->setWidth(25);
        $sheet->setCellValue('Y1', '¿Cómo obtiene insumos para la olla común?')->getColumnDimension('Y')->setWidth(25);

        $sheet->setCellValue('Z1', '¿Cuál es el nombre de la organización que los ayuda?')->getColumnDimension('Z')->setWidth(60);
        $sheet->setCellValue('AA1', '¿Cuántos días a la semana atiende la olla común?')->getColumnDimension('AA')->setWidth(15);
        $sheet->setCellValue('AB1', '¿Cuántas comidas al día prepara la olla común?')->getColumnDimension('AB')->setWidth(50);
        $sheet->setCellValue('AC1', 'Número de raciones que distribuye')->getColumnDimension('AC')->setWidth(25);
        $sheet->setCellValue('AD1', 'Precio por ración')->getColumnDimension('AD')->setWidth(25);
        $sheet->setCellValue('AE1', '¿Cuántas raciones del total son pagadas?')->getColumnDimension('AE')->setWidth(25);
        $sheet->setCellValue('AF1', 'Zonas a las cuales beneficia la olla común')->getColumnDimension('AF')->setWidth(40);
        $sheet->setCellValue('AG1', 'Número de familias beneficiadas')->getColumnDimension('AG')->setWidth(25);
        
        $sheet->setCellValue('AH1', 'Número de niños beneficiados (Menores de 5 años)')->getColumnDimension('AH')->setWidth(25);
        $sheet->setCellValue('AI1', 'Número de adultos mayores beneficiados (Mayores de 60 años)')->getColumnDimension('AI')->setWidth(25);
        $sheet->setCellValue('AJ1', 'Número de personas discapacitadas beneficiadas')->getColumnDimension('AJ')->setWidth(25);
        $sheet->setCellValue('AK1', 'Número de mujeres embarazadas beneficiadas')->getColumnDimension('AK')->setWidth(25);
        $sheet->setCellValue('AL1', 'Número de personas con enfermedades crónicas beneficiadas')->getColumnDimension('AL')->setWidth(25);
        $sheet->setCellValue('AM1', 'Número total de personas beneficiadas')->getColumnDimension('AM')->setWidth(25);
        $sheet->setCellValue('AN1', 'Agrega alguna observación')->getColumnDimension('AN')->setWidth(40);
        
         $sheet->setCellValue('AO1', 'Población Migrante extranjera')->getColumnDimension('AO')->setWidth(25);
         $sheet->setCellValue('AP1', '¿Tienen interés en tener un huerto en la comunidad?')->getColumnDimension('AP')->setWidth(25);
         $sheet->setCellValue('AQ1', '¿En la comunidad cuentan con espacio comunitario para la implementación?')->getColumnDimension('AQ')->setWidth(25);
         $sheet->setCellValue('AR1', '"¿La comunidad cuenta con personas que podrían asumir el liderazgo de un proyecto de este tipo?')->getColumnDimension('AR')->setWidth(25);
         $sheet->setCellValue('AS1', '¿Han recibido capacitaciones sobre la inocuidad para la preparación de los alimentos?')->getColumnDimension('AS')->setWidth(25);
         $sheet->setCellValue('AT1', '¿Han recibido capacitaciones sobre protocolos sanitarios?')->getColumnDimension('AT')->setWidth(25);
         $sheet->setCellValue('AU1', '¿Han recibido otro tipo de capacitaciones?')->getColumnDimension('AU')->setWidth(25);
         $sheet->setCellValue('AV1', 'Latitud')->getColumnDimension('AV')->setWidth(25);
         $sheet->setCellValue('AW1', 'Longitud')->getColumnDimension('AW')->setWidth(25);



        $spreadsheet->getActiveSheet()->getStyle('A1:AW1')->applyFromArray($styleArrayHead);


        $row = 2;
        $startRow = -1;
        $previousKey = '';
        foreach ($data as $index => $value) {
            if ($startRow == -1) {
                $startRow = $row;
                $previousKey = $value['id'];
            }
           $sheet->setCellValue('A' . $row, $value['nomdis']);
            $sheet->setCellValue('B' . $row, $value['zona']);
            $sheet->setCellValue('C' . $row, $value['aahh']);
            $sheet->setCellValue('D' . $row, $value['ubicacion']);
            $sheet->setCellValue('E' . $row, $value['nombre_olla']);
            $sheet->setCellValue('F' . $row, $value['padrones']);
            $sheet->setCellValue('G' . $row, $value['comedorpopular']);
            
            $sheet->setCellValue('H' . $row, $value['comite']);
            $sheet->setCellValue('I' . $row, $value['nombre_contacto']);
            $sheet->setCellValue('J' . $row, $value['cargo_contacto']);
            $sheet->setCellValue('K' . $row, $value['celular_contacto']);
            $sheet->setCellValue('L' . $row, $value['nombre_contacto_secundario']);
            $sheet->setCellValue('M' . $row, $value['cargo_contacto_secundario']);
            $sheet->setCellValue('N' . $row, $value['celular_contacto_secundario']);
            $sheet->setCellValue('O' . $row, $value['agua']);
             $sheet->setCellValue('P' . $row, $value['luz']);
            $sheet->setCellValue('Q' . $row, $value['presencia_muni']);
            
            $sheet->setCellValue('R' . $row, $value['tipo_espacio']);
            $sheet->setCellValue('S' . $row, $value['estado_espacio']);
            $sheet->setCellValue('T' . $row, $value['combustible']);
            $sheet->setCellValue('U' . $row, $value['techo']);
            $sheet->setCellValue('V' . $row, $value['lavado']);
            $sheet->setCellValue('W' . $row, $value['higiene']);
            $sheet->setCellValue('X' . $row, $value['instrumentos']);
            $sheet->setCellValue('Y' . $row, $value['insumos']);
            $sheet->setCellValue('Z' . $row, $value['org_ayuda']);

            $sheet->setCellValue('AA' . $row, $value['dias_atencion']);
            $sheet->setCellValue('AB' . $row, $value['comidas_dia']);
            $sheet->setCellValue('AC' . $row, $value['raciones']);
            $sheet->setCellValue('AD' . $row, $value['precio_racion']);
            $sheet->setCellValue('AE' . $row, $value['raciones_pagadas']);
            $sheet->setCellValue('AF' . $row, $value['zonas_beneficiadas']);
            $sheet->setCellValue('AG' . $row, $value['familias_beneficiadas']);
            $sheet->setCellValue('AH' . $row, $value['ninos_beneficiadas']);
            
            $sheet->setCellValue('AI' . $row, $value['adultos_beneficiadas']);
            $sheet->setCellValue('AJ' . $row, $value['disca_beneficiadas']);
            $sheet->setCellValue('AK' . $row, $value['emba_beneficiadas']);
            $sheet->setCellValue('AL' . $row, $value['enfercro_beneficiadas']);
            $sheet->setCellValue('AM' . $row, $value['total_beneficiadas']);
            $sheet->setCellValue('AN' . $row, $value['observaciones']);
            $sheet->setCellValue('AO' . $row, $value['extranjera']);
            $sheet->setCellValue('AP' . $row, $value['huerto']);
            $sheet->setCellValue('AQ' . $row, $value['espacio_huerto']);
            $sheet->setCellValue('AR' . $row, $value['liderazgo']);
            $sheet->setCellValue('AS' . $row, $value['inocuidad']);
            $sheet->setCellValue('AT' . $row, $value['protocolos']);
            $sheet->setCellValue('AU' . $row, $value['otro_cap']);
            $sheet->setCellValue('AV' . $row, $value['latitud']);
            $sheet->setCellValue('AW' . $row, $value['longitud']);
     
            
            
            $spreadsheet->getActiveSheet()->getStyle('Z' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AA' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AB' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AC' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AD' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AE' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AF' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AG' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AH' . $row)->applyFromArray($styleArray);
            
             $spreadsheet->getActiveSheet()->getStyle('AI' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AJ' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AK' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AL' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AM' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AN' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AO' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AP' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AQ' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AR' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AS' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AT' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AU' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AV' . $row)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('AW' . $row)->applyFromArray($styleArray);
            

            $nextKey = isset($data[$index + 1]) ? $data[$index + 1]['id'] : null;

            if ($row >= $startRow && (($previousKey <> $nextKey) || ($nextKey == null))) {
                 $cellToMerge1 = 'A' . $startRow . ':A' . $row;
                $cellToMerge2 = 'B' . $startRow . ':B' . $row;
                $cellToMerge3 = 'C' . $startRow . ':C' . $row;
                $cellToMerge4 = 'D' . $startRow . ':D' . $row;
                $cellToMerge5 = 'E' . $startRow . ':E' . $row;
                $cellToMerge6 = 'F' . $startRow . ':F' . $row;
                $cellToMerge7 = 'G' . $startRow . ':G' . $row;
                $cellToMerge8 = 'H' . $startRow . ':H' . $row;
                $cellToMerge9 = 'I' . $startRow . ':I' . $row;
                $cellToMerge10 = 'J' . $startRow . ':J' . $row;
                $cellToMerge11 = 'K' . $startRow . ':K' . $row;
                $cellToMerge12 = 'L' . $startRow . ':L' . $row;
                $cellToMerge13 = 'M' . $startRow . ':M' . $row;
                $cellToMerge14 = 'N' . $startRow . ':N' . $row;
                $cellToMerge15 = 'O' . $startRow . ':O' . $row;
                $cellToMerge16 = 'P' . $startRow . ':P' . $row;
                $cellToMerge17 = 'Q' . $startRow . ':Q' . $row;
                $cellToMerge18 = 'R' . $startRow . ':R' . $row;
                $cellToMerge19 = 'S' . $startRow . ':S' . $row;
                $cellToMerge20 = 'T' . $startRow . ':T' . $row;
                $cellToMerge21 = 'U' . $startRow . ':U' . $row;
                $cellToMerge22 = 'V' . $startRow . ':V' . $row;
                $cellToMerge23 = 'W' . $startRow . ':W' . $row;
                $cellToMerge24 = 'X' . $startRow . ':X' . $row;
                $cellToMerge25 = 'Y' . $startRow . ':Y' . $row;

                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge1);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge2);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge3);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge4);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge5);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge6);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge7);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge8);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge9);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge10);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge11);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge12);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge13);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge14);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge15);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge16);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge17);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge18);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge19);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge20);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge21);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge22);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge23);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge24);
                $spreadsheet->getActiveSheet()->mergeCells($cellToMerge25);

                $spreadsheet->getActiveSheet()->getStyle($cellToMerge1)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge2)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge3)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge4)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge5)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge6)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge7)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge8)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge9)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge10)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge11)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge12)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge13)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge14)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge15)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge16)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge17)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge18)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge19)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge20)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge21)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge22)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge23)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge24)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle($cellToMerge25)->applyFromArray($styleArray);
                $startRow = -1;
            }
            $row++;
        }

        $excelWriter = new Xlsx($spreadsheet);

        $tempFile = tempnam(File::sysGetTempDir(), 'phpxltmp');
        $tempFile = $tempFile ?: __DIR__ . '/temp.xlsx';
        $excelWriter->save($tempFile);


        $response = $response->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response = $response->withHeader('Content-Disposition', 'attachment; filename="OllasComunes.xlsx"');

        $stream = fopen($tempFile, 'r+');

        return $response->withBody(new \Slim\Http\Stream($stream));
    }

    

}
