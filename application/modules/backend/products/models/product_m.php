<?php

class Product_m extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProducts()
    {
        return array();
    }

    public function addProduct($data = array())
    {
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }

    public function addFile($path, $files)
    {
        foreach ($files as $file) {
            $insertArray = array(
                'unique_value' => 'products_' . $file,
                'name' => $file,
                'entity' => 'products',
                'attributes' => json_encode(array('size' => filesize($path . $file), 'sha1' => sha1_file($path . $file), 'last_modified' => filemtime($path . $file)))
            );
            $this->db->insert('excel_files', $insertArray);
        }
        return false;
    }

    public function getFiles($file_name)
    {
        return $this->db->where_in('name', $file_name)
            ->get('excel_files')
            ->result_array();
    }

    public function getUploadedFile()
    {
        return $this->db->get('excel_files')->result_array();
    }

    public function importProducts($path, $files = array())
    {
        $excelRows = [];
        foreach ($files as $file) {
            $excelRows[] = $this->_getExcelData($path, $file);
        }

        debug($excelRows);
        /* if ($excelRows) {
          $this->load->model('tool/image_m');
          foreach ($excelRows as $excelRow) {
          foreach ($excelRow as $row) {
          $this->addProduct($row);

          if (is_file($this->image_dir . $row['sku'] . 'jpg')) {

          }
          }
          }
          }

         */
        exit;
    }

    private function _getExcelData($path, $file = array())
    {
        $this->load->library('excel');

        $products = array();

        $filePath = realpath($path . $file);

        //Read your Excel workbook
        try {
            $inputFileType = PHPExcel_IOFactory::identify($filePath);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($filePath);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($filePath, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
        //Get active worksheet dimensions
        $sheet = $objPHPExcel->getSheet(0);

        //Get worksheet dimensions
        $dimension = $sheet->calculateWorksheetDimension();

        //get data form excel in array
        $rowData = $sheet->rangeToArray($dimension);

        $rowData = array_map('array_filter', $rowData);
        $columns = $rowData[0];

        unset($rowData[0]);

        $rowData = array_values(array_filter($rowData));
    }
}
