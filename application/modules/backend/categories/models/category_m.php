<?php

/**
 * Created by PhpStorm.
 * User: RRajesh
 * Date: 12/11/2016
 * Time: 8:57 PM
 */
class Category_m extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCategories($data)
    {
        $sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order,c1.status,c1.date_added,c1.date_modified FROM categories_path cp LEFT JOIN categories c1 ON (cp.category_id = c1.category_id) LEFT JOIN categories c2 ON (cp.path_id = c2.category_id) LEFT JOIN categories_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN categories_description cd2 ON (cp.category_id = cd2.category_id)";

        if (!empty($data['filter_name'])) {
            $sql .= " AND cd2.name LIKE '%" . $data['filter_name'] . "%'";
        }

        $sql .= " GROUP BY cp.category_id";

        $sort_data = array(
            'name',
            'sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }


        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getCategory($category_id)
    {
        $sql = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM categories_path cp LEFT JOIN categories_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id  GROUP BY cp.category_id) AS path FROM categories c LEFT JOIN categories_description cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '" . (int)$category_id . "'");
        return $sql->row_array();
    }

    public function getCategoryDescription($category_id)
    {
        $category_description_data = array();
        $result = $this->db->where('category_id', (int)$category_id)
            ->get('categories_description')
            ->row_array();


        if ($result) {
            $category_description_data = array(
                'name' => $result['name'],
                'meta_title' => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword' => $result['meta_keyword'],
                'description' => $result['description']
            );
        }

        return $category_description_data;
    }

    public function getCategoryPath($category_id)
    {
        return $this->db->select(array('category_id', 'path_id', 'level'))->from('categories_path')
            ->where('category_id', $category_id)
            ->get()
            ->result_array();
    }

    public function addCategory($data)
    {

        $this->db->cache_on();
        $category = array(
            'parent_id' => (int)$data['parent_id'],
            'sort_order' => (int)$data['sort_order'],
            'status' => (int)$data['status'],
            'date_added' => date('Y-m-d H:i:s'),
            'date_modified' => date('Y-m-d H:i:s')
        );

        $this->db->set($category)
            ->insert('categories');
        $insert_id = $this->db->insert_id();

        if (isset($data['image'])) {
            $this->db->set('image', $data['image'])
                ->where('category_id', $insert_id)
                ->update('categories');
        }
        if ($data['categories_description']) {
            $cat_description = array(
                'category_id' => $insert_id,
                'name' => trim($data['categories_description']['name']),
                'description' => trim($data['categories_description']['description']),
                'meta_title' => trim($data['categories_description']['meta_title']),
                'meta_description' => trim($data['categories_description']['meta_description']),
                'meta_keyword' => trim($data['categories_description']['meta_keyword']),
            );
            $this->db->set($cat_description)->insert('categories_description');

        }

        // MySQL Hierarchical Data Closure Table Pattern
        $level = 0;
        $rows = $this->db->where('category_id', (int)$data['parent_id'])
            ->order_by('level ASC')
            ->get('categories_path')
            ->result_array();
        if ($rows) {
            foreach ($rows as $row) {
                $set = array(
                    'category_id' => (int)$insert_id,
                    'path_id' => (int)$row['path_id'],
                    'level' => $level
                );
                $this->db->set($set)->insert('categories_path');
                $level++;
            }
        }
        $set = array(
            'category_id' => (int)$insert_id,
            'path_id' => (int)$insert_id,
            'level' => $level
        );
        $this->db->set($set)->insert('categories_path');
        $this->db->cache_delete('categories');
        return $insert_id;
    }

    public function editCategory($category_id, $data)
    {
        $category = array(
            'parent_id' => $data['parent_id'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
            'date_modified' => date('Y-m-d H:i:s')
        );
        $this->db->where('category_id', (int)$category_id)
            ->update('categories', $category);

        if (isset($data['image'])) {
            $this->db->set('image', $data['image'])
                ->where('category_id', (int)$category_id)
                ->update('categories');

        }
        if ($data['categories_description']) {
            $description = array(
                'name' => $data['categories_description']['name'],
                'description' => $data['categories_description']['description'],
                'meta_title' => $data['categories_description']['meta_title'],
                'meta_description' => $data['categories_description']['meta_description'],
                'meta_keyword' => $data['categories_description']['meta_keyword'],
            );

            $this->db->where('category_id', (int)$category_id)
                ->update('categories_description', $description);
        }

        // MySQL Hierarchical Data Closure Table Pattern
        $results = $this->db->where('path_id', (int)$category_id)
            ->order_by('level ASC')
            ->get('categories_path')
            ->result_array();

        if ($results) {
            foreach ($results as $cat_path) {
                // Delete the path below the current one
                $this->db->where(array(
                    'category_id' => (int)$category_id,
                    'level <' => (int)$cat_path['level']
                ))->delete('categories_path');

                $path = array();

                // Get the nodes new parents
                $rows = $this->db->where('category_id', (int)$data['parent_id'])
                    ->order_by('level ASC')
                    ->get('categories_path')
                    ->result_array();
                foreach ($rows as $row) {
                    $path[] = $row['path_id'];
                }

                // Get whats left of the nodes current path
                $rows = $this->db->where('category_id', $cat_path['category_id'])
                    ->order_by('level ASC')
                    ->get('categories_path')
                    ->result_array();

                foreach ($rows as $row) {
                    $path[] = $row['path_id'];
                }

                // Combine the paths with a new level
                $level = 0;
                foreach ($path as $path_id) {
                    $this->db->query("REPLACE INTO `categories_path` SET category_id = '" . (int)$cat_path['category_id'] . "', `path_id` = '" . (int)$path_id . "', LEVEL = '" . (int)$level . "'");
                    $level++;
                }
            }
        } else {

            // Delete the path below the current one
            $this->db->where('category_id', (int)$category_id)->delete('categories_path');

            // Fix for records with no paths
            $level = 0;

            $rows = $this->db->where('category_id', (int)$data['parent_id'])->order_by('level ASC')->get('categories_path')->result_array();

            foreach ($rows as $result) {
                $this->db->set(array('category_id' => (int)$category_id, 'path_id' => $result['path_id'], 'level' => (int)$level))->insert('categories_path');
                $level++;
            }
            $this->db->query("REPLACE INTO `categories_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', level = '" . (int)$level . "'");
        }
        $this->db->cache_delete('categories');
    }

    public function deleteCategory($category_id)
    {
        $this->db->where('category_id', $category_id)->delete('categories_path');
        $rows = $this->db->where('path_id', $category_id)->get('categories_path')->result_array();
        foreach ($rows as $row) {
            $this->deleteCategory($row['category_id']);
        }
        $this->db->where('category_id', $category_id)->delete('categories');
        $this->db->where('category_id', $category_id)->delete('categories_description');
        $this->db->cache_delete('categories');
    }

    public function addFile($path, $files)
    {
        foreach ($files as $file) {

            $insertArray = array(
                'unique_value' => 'categories_' . $file,
                'name' => $file,
                'entity' => 'categories',
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

    public function deleteExcelEntry($fileName)
    {
        $this->db->where_in('name', $fileName)
            ->delete('excel_files');
        $this->db->truncate('categories');
        $this->db->truncate('categories_description');
        $this->db->truncate('categories_path');
    }

    public function getUploadedFile()
    {
        return $this->db->get('excel_files')->result_array();
    }


    public function importCategory($path, $files = array())
    {
        $excelRows = $this->getExcelData($path, $files);

        $i = 0;
        foreach ($excelRows as $excelRow) {

            $categories = array(
                'categories_id' => $excelRow['id'],
                'image' => '',
                'parent_id' => $excelRow['parent_id'],
                'sort_order' => $i,
                'status' => trim($excelRow['status']),
            );
            $categories['categories_description'] = array(
                'name' => $excelRow['name'],
                'description' => $excelRow['description'],
                'meta_description' => $excelRow['meta_description'],
                'meta_title' => $excelRow['meta_title'],
                'meta_keyword' => $excelRow['meta_keyword']
            );

            $this->addCategory($categories);
            $i++;
        }
        if (count($excelRows) == $i) {

            $this->addFile($path, $files);
        }
        return false;
    }

    public function getExcelData($path, $files = array())
    {
        $this->load->library('excel');

        $categories = array();
        foreach ($files as $file) {

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

            //removing column from array
            $column = $rowData[0];

            //converting excel column to table column
            $column = array_map(function ($value) {
                return strtolower(str_replace(' ', '_', $value));
            }, $column);

            unset($rowData[0]);

            //filtered array without column
            $rowData = array_values($rowData);

            foreach ($rowData as $item) {
                $categories[] = array_combine($column, $item);
            }

            return $categories;
        }
        return false;
    }

    public function updateExcelEntries($file, $data)
    {
        $this->db->set($data)
            ->where('unique_value', 'categories_', $file)
            ->update('excel_files');
    }


    public function updateCategoriesExcel()
    {

    }
}