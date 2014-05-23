<?php
namespace PicqerImporter;

use PHPExcel_Reader_Excel2007;
use PHPExcel_Cell;

class SingleExcelExtractor {

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function processExcel($filename)
    {
        $excelreader = new PHPExcel_Reader_Excel2007();
        $phpexcel = $excelreader->load($filename);

        // Use second sheet for productcodes
        $phpexcel->setActiveSheetIndex(1);

        $lastcolumn = PHPExcel_Cell::columnIndexFromString($phpexcel->getActiveSheet()->getHighestColumn());
        $lastrow = $phpexcel->getActiveSheet()->getHighestRow();

        // Get productcodes
        $productcodes = array();
        for ($activerow = 0; $activerow < $lastrow; $activerow++) {
            for ($activecolumn = 0; $activecolumn < $lastcolumn; $activecolumn++) {
                $celdata = $phpexcel->getActiveSheet()->getCellByColumnAndRow($activecolumn, $activerow)->getValue();
                if (!empty($celdata)) {
                    $productcodes[] = array(
                        'productcode' => trim($celdata),
                        'column' => $activecolumn,
                        'row' => $activerow
                    );
                }
            }
        }

        // Switch to first sheet
        $phpexcel->setActiveSheetIndex(0);

        // Get number of products needed
        $products = array();
        foreach ($productcodes as $productcode) {
            $celdata = $phpexcel->getActiveSheet()->getCellByColumnAndRow($productcode['column'], $productcode['row'])->getValue();
            if (!empty($celdata) && is_numeric($celdata)) {
                $products[$productcode['productcode']] = $celdata;
            }
        }

        return $products;
    }
}