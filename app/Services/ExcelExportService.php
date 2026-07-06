<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExcelExportService
{
    /**
     * Generate elegant Excel spreadsheet.
     *
     * @param  string  $title  Laporan Title
     * @param  array  $metadata  Key-value pairs of metadata (e.g. Period, Exported At)
     * @param  array  $headers  List of column headers
     * @param  array  $rows  List of data rows (each row must align with headers)
     * @param  array  $columnFormats  Optional column alignments or formats (e.g. ['A' => 'center'])
     */
    public static function generate(
        string $title,
        array $metadata,
        array $headers,
        array $rows,
        array $columnFormats = []
    ): Spreadsheet {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        // Ensure gridlines are visible
        $sheet->setShowGridlines(true);

        // 1. Draw Title
        $sheet->setCellValue('A2', strtoupper($title));
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(16)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('1E293B'));

        // 2. Draw Metadata
        $rowIdx = 4;
        foreach ($metadata as $key => $value) {
            $sheet->setCellValue('A'.$rowIdx, $key.':');
            $sheet->setCellValue('B'.$rowIdx, $value);
            $sheet->getStyle('A'.$rowIdx)->getFont()->setBold(true)->setSize(10)->getColor()->setRGB('475569');
            $sheet->getStyle('B'.$rowIdx)->getFont()->setSize(10)->getColor()->setRGB('1E293B');
            $rowIdx++;
        }

        $rowIdx += 1; // leave one empty row

        // 3. Draw Headers
        $colLetter = 'A';
        $headerRow = $rowIdx;
        foreach ($headers as $header) {
            $sheet->setCellValue($colLetter.$headerRow, $header);
            $sheet->getStyle($colLetter.$headerRow)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E3A8A'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $colLetter++;
        }
        $lastCol = chr(ord($colLetter) - 1);

        // Set header row height
        $sheet->getRowDimension($headerRow)->setRowHeight(28);

        // 4. Draw Rows
        $dataStartRow = $headerRow + 1;
        $currentRow = $dataStartRow;
        foreach ($rows as $rowData) {
            $colLetter = 'A';
            foreach ($rowData as $cellVal) {
                $cellCoordinate = $colLetter.$currentRow;
                $sheet->setCellValue($cellCoordinate, $cellVal);

                // Alignment based on format or default text
                $align = Alignment::HORIZONTAL_LEFT;
                if (isset($columnFormats[$colLetter])) {
                    if ($columnFormats[$colLetter] === 'center') {
                        $align = Alignment::HORIZONTAL_CENTER;
                    } elseif ($columnFormats[$colLetter] === 'right') {
                        $align = Alignment::HORIZONTAL_RIGHT;
                    }
                }

                $sheet->getStyle($cellCoordinate)->getAlignment()->setHorizontal($align)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle($cellCoordinate)->getFont()->setSize(10);

                // Style specific status/active values
                $valLower = strtolower(trim((string) $cellVal));
                if (in_array($valLower, ['dipesan', 'aktif', 'open', 'yes', 'true', 'active'])) {
                    $sheet->getStyle($cellCoordinate)->getFont()->setBold(true)->getColor()->setRGB('1D4ED8'); // Blue/Green theme
                } elseif (in_array($valLower, ['dibatalkan', 'tidak aktif', 'non-aktif', 'no', 'false', 'inactive'])) {
                    $sheet->getStyle($cellCoordinate)->getFont()->setBold(true)->getColor()->setRGB('B91C1C'); // Red
                } elseif (in_array($valLower, ['selesai'])) {
                    $sheet->getStyle($cellCoordinate)->getFont()->setBold(true)->getColor()->setRGB('047857'); // Green
                }

                $colLetter++;
            }

            // Row styling: height & alternating backgrounds (zebra)
            $sheet->getRowDimension($currentRow)->setRowHeight(22);
            $bgRgb = ($currentRow % 2 === 0) ? 'F8FAFC' : 'FFFFFF';
            $sheet->getStyle('A'.$currentRow.':'.$lastCol.$currentRow)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $bgRgb],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E2E8F0'],
                    ],
                ],
            ]);

            $currentRow++;
        }

        // 5. Auto fit column widths
        $colLetter = 'A';
        for ($i = 0; $i < count($headers); $i++) {
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
            $colLetter++;
        }

        return $spreadsheet;
    }
}
